<?php
// 1. DB接続・共通関数の読み込み
require_once 'includes/db.php';
require_once 'includes/functions/db_helpers.php';
require_once 'includes/functions/content_blocks.php';
require_once 'includes/functions/command_converter.php';

// 2. 豪鬼のキャラクター基本情報・フレームデータ（既存の characters / frame テーブルをそのまま使う）
$character  = getCharacterBySlug($pdo, 'gouki');
$all_frames = $character ? getFrameDataByCharId($pdo, $character['id']) : [];

// 3. 豪鬼専用ガイド文章（強み弱み・立ち回りの基本）の読み込み
if (!function_exists('loadJsonFile')) {
    function loadJsonFile(string $path): array {
        if (!file_exists($path)) {
            return [null, 'ファイルが見つかりません: ' . $path];
        }
        $raw = file_get_contents($path);
        $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw);
        $decoded = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [null, 'JSONの形式が不正です(' . basename($path) . '): ' . json_last_error_msg()];
        }
        return [$decoded, null];
    }
}
[$akumaGuide, $akumaGuideErr] = loadJsonFile(__DIR__ . '/data/akuma_guide.json');
$strengthsWeaknesses = $akumaGuide['strengths_weaknesses'] ?? [];
$basicTactics        = $akumaGuide['basic_tactics'] ?? [];

// 3b. 豪鬼専用コンボ（実戦コンボ集／リーサル判断の両方をここから分配する）
$akumaCombos    = getAkumaCombos($pdo);
$practicalCombos = array_values(array_filter($akumaCombos, fn($c) => $c['purpose'] === 'practical'));
$lethalCombos     = array_values(array_filter($akumaCombos, fn($c) => $c['purpose'] === 'lethal'));

// 3c. 起き攻め／セットアップのマトリクス表 用データ
$akumaOpponentActions = getAkumaOpponentActions($pdo);
$akumaOkiSetups    = getAkumaOkiSetups($pdo, 'oki');
$akumaSetupSetups   = getAkumaOkiSetups($pdo, 'setup');

// 3d. 豪鬼視点でのキャラ対策（28キャラ分。豪鬼自身は一覧から除外する）
$allCharactersForMatchup = array_values(array_filter(getAllCharacters($pdo), fn($c) => $c['char_slug'] !== 'gouki'));
$akumaMatchupMap = getAllAkumaMatchups($pdo);

// 4. ページごとの設定値
$page_title       = "豪鬼を極める者へ | SF6 PORTAL";
$page_description = "ストリートファイター6「豪鬼」の強み・弱み、立ち回り、実戦コンボ、起き攻め、キャラ対策までを1ページに集約した特設ガイド。";
$current_page      = "akuma";
$extra_css          = ['css/layouts/pattern-b-layout.css', 'css/components/akuma.css'];

// 5. ページ内目次（スクロール追従サイドバー。toc-sidebar.php の仕組みをそのまま使う）
$toc_title = "豪鬼特設ページ";
$page_toc = [
    ['href' => '#strengths-weaknesses', 'label' => '強み・弱み'],
    ['href' => '#basic-tactics',        'label' => '立ち回りの基本'],
    ['href' => '#practical-combos',     'label' => '実戦コンボ集'],
    ['href' => '#lethal-combos',        'label' => 'リーサル判断'],
    ['href' => '#oki',                  'label' => '起き攻め・柔道'],
    ['href' => '#setup',                'label' => 'セットアップ'],
    ['href' => '#matchups',             'label' => 'キャラクター対策'],
    ['href' => '#frame-data',           'label' => 'フレームデータ'],
];

/**
 * akuma_combos の1件を、character.php のコンボカードと似た見た目のHTMLに変換する。
 * 実戦コンボ集／リーサル判断の両方で使い回す。
 */
if (!function_exists('renderAkumaComboCard')) {
    function renderAkumaComboCard(array $combo): string {
        $html  = '<div class="grid-card" data-purpose="' . h($combo['purpose']) . '"';
        $html .= ' data-hp-min="' . (int)($combo['hp_threshold_min'] ?? 0) . '"';
        $html .= ' data-hp-max="' . (int)($combo['hp_threshold_max'] ?? 100) . '">';
        $html .= '<div class="grid-card-title">' . h($combo['title']) . '</div>';
        $html .= '<div style="display:flex; flex-wrap:wrap; gap:4px; margin-bottom:8px;">';
        $html .= '<span class="combo-badge">' . h(translateDifficulty($combo['difficulty'])) . '</span>';
        if (($combo['purpose'] ?? '') === 'lethal' && $combo['hp_threshold_min'] !== null) {
            $html .= '<span class="combo-badge">体力' . (int)$combo['hp_threshold_min'] . '〜' . (int)$combo['hp_threshold_max'] . '%</span>';
        }
        $html .= '</div>';
        $html .= '<div class="combo-command" style="margin:8px 0;">' . convertCommandToIcons($combo['recipe']) . '</div>';
        $html .= '<div style="font-size:0.85rem; color:var(--text-secondary);">ダメージ ' . (int)$combo['damage']
                . ' / 消費ドライブ ' . (int)$combo['drive_gauge']
                . (((int)($combo['sa_gauge'] ?? 0)) > 0 ? ' / 消費SA ' . (int)$combo['sa_gauge'] : '') . '</div>';
        if (!empty($combo['memo'])) {
            $html .= '<div class="combo-note" style="margin-top:8px;">' . renderComboMemo($combo['memo']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }
}

/**
 * 1つの「状況」（akuma_oki_setups の1行）を、択 × 相手の行動 のマトリクス表としてHTML化する。
 * 起き攻め／セットアップの両セクションで使い回す。
 */
if (!function_exists('renderAkumaMatrixBlock')) {
    function renderAkumaMatrixBlock($pdo, array $setup, array $opponentActions): string {
        $options = getAkumaOkiOptionsBySetupId($pdo, $setup['id']);
        if (empty($options)) {
            return '';
        }
        $optionIds = array_column($options, 'id');
        $outcomeMap = getAkumaOkiOutcomesByOptionIds($pdo, $optionIds);

        $html  = '<div class="akuma-matrix-block">';
        $html .= '<div class="akuma-matrix-title">' . h($setup['title']) . '</div>';
        if (!empty($setup['description'])) {
            $html .= '<div class="akuma-matrix-desc">' . h($setup['description']) . '</div>';
        }
        $html .= '<div style="overflow-x:auto;"><table class="akuma-matrix-table"><thead><tr><th>択</th>';
        foreach ($opponentActions as $action) {
            $html .= '<th>' . h($action['label']) . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach ($options as $option) {
            $html .= '<tr><td class="akuma-matrix-option-cell"><span class="akuma-matrix-option-title">' . h($option['title']) . '</span>';
            if (!empty($option['note'])) {
                $html .= '<span class="akuma-matrix-option-note">' . h($option['note']) . '</span>';
            }
            $html .= '</td>';

            foreach ($opponentActions as $action) {
                $outcome = $outcomeMap[$option['id']][$action['id']] ?? null;
                if ($outcome === null) {
                    $html .= '<td style="color:var(--text-secondary);">—</td>';
                    continue;
                }
                $titleAttr = !empty($outcome['note']) ? ' title="' . h($outcome['note']) . '"' : '';
                $html .= '<td class="' . h(akumaOutcomeClass($outcome['result'])) . '"' . $titleAttr . '>'
                       . h(akumaOutcomeLabel($outcome['result'])) . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</tbody></table></div></div>';
        return $html;
    }
}

/**
 * akuma_matchups の1件（無い場合は null）を、相手キャラ1人分のカードとしてHTML化する。
 */
if (!function_exists('renderAkumaMatchupCard')) {
    function renderAkumaMatchupCard(array $character, ?array $matchup): string {
        $name = $character['name_jp'] ?? $character['char_slug'];
        $html = '<div class="grid-card">';
        $html .= '<div class="grid-card-title">' . h($name) . '</div>';

        if ($matchup === null) {
            $html .= '<div style="color:var(--text-secondary); font-size:0.85rem;">🚧 準備中</div>';
            $html .= '</div>';
            return $html;
        }

        if (!empty($matchup['overview'])) {
            $html .= '<div class="grid-card-desc">' . renderMatchupMultiline($matchup['overview']) . '</div>';
        }
        if (!empty($matchup['favorable_moves'])) {
            $html .= '<div class="combo-note" style="margin-top:8px;"><strong class="training-block-heading">■相性のいい技</strong><br>' . renderMatchupMultiline($matchup['favorable_moves']) . '</div>';
        }
        if (!empty($matchup['win_condition'])) {
            $html .= '<div class="combo-note" style="margin-top:8px;"><strong class="training-block-heading">■勝ち筋</strong><br>' . renderMatchupMultiline($matchup['win_condition']) . '</div>';
        }
        if (!empty($matchup['lose_condition'])) {
            $html .= '<div class="combo-note" style="margin-top:8px;"><strong class="training-block-heading">■負け筋</strong><br>' . renderMatchupMultiline($matchup['lose_condition']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }
}

// 6. Head部分の読み込み
include 'includes/head.php';
?>

<?php include 'includes/header.php'; ?>

<div class="main-wrapper akuma-theme">

  <?php include 'includes/toc-sidebar.php'; ?>

  <main class="content-area">

    <!-- ヒーローセクション -->
    <div class="akuma-hero">
      <div class="akuma-hero-watermark">鬼</div>
      <div class="akuma-hero-eyebrow">SPECIAL CHARACTER GUIDE</div>
      <h1 class="akuma-hero-title">豪鬼を極める者へ</h1>
      <p class="akuma-hero-desc">
        初心者から上級者まで対応した、豪鬼専用の完全ガイド。強み・弱みの理解から、実戦級のコンボ、
        起き攻め・セットアップの択、キャラクター対策まで、豪鬼を使いこなすために必要な情報をここに集約していく。
      </p>
    </div>

    <?php if ($character === null): ?>
      <div class="alert-box warning">
        <div class="alert-title">⚠️ エラー</div>
        <div class="alert-content">キャラクターデータ（gouki）が見つかりませんでした。</div>
      </div>
    <?php endif; ?>

    <?php if ($akumaGuideErr !== null): ?>
      <div class="alert-box warning">
        <div class="alert-title">⚠️ ガイド文章の読み込みエラー</div>
        <div class="alert-content"><?php echo h($akumaGuideErr); ?></div>
      </div>
    <?php endif; ?>

    <!-- 強み・弱み -->
    <section id="strengths-weaknesses" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">強み・弱み</h2>
      <?php foreach ($strengthsWeaknesses as $block): ?>
        <?php echo renderContentBlock($block); ?>
      <?php endforeach; ?>
    </section>

    <!-- 立ち回りの基本 -->
    <section id="basic-tactics" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">立ち回りの基本</h2>
      <?php foreach ($basicTactics as $block): ?>
        <?php echo renderContentBlock($block); ?>
      <?php endforeach; ?>
    </section>

    <!-- 実戦コンボ集 -->
    <section id="practical-combos" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">実戦コンボ集</h2>
      <?php if (empty($practicalCombos)): ?>
        <div class="alert-box">
          <div class="alert-title">🚧 準備中</div>
          <div class="alert-content">現在、実戦コンボはまだ登録されていません。</div>
        </div>
      <?php else: ?>
        <div class="card-grid">
          <?php foreach ($practicalCombos as $combo): ?>
            <?php echo renderAkumaComboCard($combo); ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>

    <!-- リーサル判断：体力%を指定すると、該当するコンボだけが絞り込まれる -->
    <section id="lethal-combos" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">リーサル判断</h2>
      <p class="hero-header-desc" style="margin-bottom:16px;">相手の残り体力(%)を指定すると、その体力帯で選ぶべきコンボだけが表示される。</p>

      <?php if (empty($lethalCombos)): ?>
        <div class="alert-box">
          <div class="alert-title">🚧 準備中</div>
          <div class="alert-content">現在、リーサル用コンボはまだ登録されていません。</div>
        </div>
      <?php else: ?>
        <div class="filter-bar" style="margin-bottom:16px;">
          <label for="lethalHpRange" style="font-size:0.85rem; color:var(--text-secondary); white-space:nowrap;">相手の残り体力：</label>
          <input type="range" id="lethalHpRange" min="0" max="100" value="100" style="flex:1;">
          <span id="lethalHpValue" class="combo-badge" style="min-width:56px; text-align:center;">100%</span>
        </div>
        <div class="card-grid" id="lethalComboGrid">
          <?php foreach ($lethalCombos as $combo): ?>
            <?php echo renderAkumaComboCard($combo); ?>
          <?php endforeach; ?>
        </div>
        <div class="alert-box" id="lethalNoResult" style="display:none; margin-top:12px;">
          <div class="alert-content">この体力帯に該当するコンボがありません。</div>
        </div>
      <?php endif; ?>
    </section>

    <!-- 起き攻め・柔道：択 × 相手の行動 のマトリクス表 -->
    <section id="oki" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">起き攻め・柔道</h2>
      <?php if (empty($akumaOkiSetups)): ?>
        <div class="alert-box">
          <div class="alert-title">🚧 準備中</div>
          <div class="alert-content">現在、起き攻めの択はまだ登録されていません。</div>
        </div>
      <?php else: ?>
        <?php foreach ($akumaOkiSetups as $setup): ?>
          <?php echo renderAkumaMatrixBlock($pdo, $setup, $akumaOpponentActions); ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </section>

    <!-- セットアップ（詐欺飛び等）：同じくマトリクス表 -->
    <section id="setup" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">セットアップ</h2>
      <?php if (empty($akumaSetupSetups)): ?>
        <div class="alert-box">
          <div class="alert-title">🚧 準備中</div>
          <div class="alert-content">現在、セットアップの択はまだ登録されていません。</div>
        </div>
      <?php else: ?>
        <?php foreach ($akumaSetupSetups as $setup): ?>
          <?php echo renderAkumaMatrixBlock($pdo, $setup, $akumaOpponentActions); ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </section>

    <!-- 豪鬼視点でのキャラクター対策（28キャラ分） -->
    <section id="matchups" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">キャラクター対策</h2>
      <p class="hero-header-desc" style="margin-bottom:16px;">豪鬼ならではの行動（間合い・空中技の差し込み等）を踏まえた、相手キャラごとの対策。</p>
      <div class="card-grid">
        <?php foreach ($allCharactersForMatchup as $oppChar): ?>
          <?php echo renderAkumaMatchupCard($oppChar, $akumaMatchupMap[$oppChar['id']] ?? null); ?>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- フレームデータ -->
    <section id="frame-data" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">フレームデータ</h2>
      <?php if (empty($all_frames)): ?>
        <div class="alert-box">
          <div class="alert-title">💡 Notice</div>
          <div class="alert-content">現在、フレームデータは登録されていません。</div>
        </div>
      <?php else: ?>
        <div class="table-container">
          <table class="data-table">
            <thead>
              <tr>
                <th>技名</th>
                <th>種別</th>
                <th>発生(F)</th>
                <th>持続</th>
                <th>硬直</th>
                <th>ガード時硬直差</th>
                <th>ヒット時硬直差</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($all_frames as $frame): ?>
                <tr>
                  <td>
                    <?php echo h($frame['move_name_jp']); ?>
                    <?php if (!empty($frame['move_variant'])): ?>
                      <span style="color:var(--text-secondary); font-size:0.8rem;">（<?php echo h($frame['move_variant']); ?>）</span>
                    <?php endif; ?>
                  </td>
                  <td><?php echo h(translateMoveType($frame['move_type'])); ?></td>
                  <td><?php echo h($frame['startup']); ?></td>
                  <td><?php echo h($frame['active']); ?></td>
                  <td><?php echo h($frame['recovery']); ?></td>
                  <td class="<?php echo frameAdvClass($frame['guard_adv']); ?>"><?php echo h($frame['guard_adv']); ?></td>
                  <td class="<?php echo frameAdvClass($frame['hit_adv']); ?>"><?php echo h($frame['hit_adv']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </section>

  </main>
</div>

<!-- リーサル判断：体力%スライダーで該当コンボを絞り込む -->
<script>
  (function () {
    var range    = document.getElementById('lethalHpRange');
    var valueTag = document.getElementById('lethalHpValue');
    var grid     = document.getElementById('lethalComboGrid');
    var noResult = document.getElementById('lethalNoResult');
    if (!range || !grid) return;

    var cards = grid.querySelectorAll('.grid-card');

    function applyFilter() {
      var hp = parseInt(range.value, 10);
      valueTag.textContent = hp + '%';
      var visibleCount = 0;

      cards.forEach(function (card) {
        var min = parseInt(card.dataset.hpMin, 10);
        var max = parseInt(card.dataset.hpMax, 10);
        var match = hp >= min && hp <= max;
        card.style.display = match ? '' : 'none';
        if (match) visibleCount++;
      });

      if (noResult) {
        noResult.style.display = visibleCount === 0 ? '' : 'none';
      }
    }

    range.addEventListener('input', applyFilter);
    applyFilter();
  })();
</script>

<?php include 'includes/footer.php'; ?>
