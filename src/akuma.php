<?php
// 1. DB接続・共通関数の読み込み
require_once 'includes/db.php';
require_once 'includes/functions/db_helpers.php';
require_once __DIR__ . '/includes/functions/frame_table.php';
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

// 「（執筆中）」で始まるテキストブロックは未執筆のプレースホルダー。
// 公開側には出さず、他セクションと同じ「準備中」表示にする（JSON側の文言は執筆用の目印としてそのまま残してよい）
$akumaDraftFilter = function (array $blocks): array {
    return array_values(array_filter($blocks, function ($b) {
        return !(($b['type'] ?? '') === 'text' && mb_strpos(trim((string)($b['body'] ?? '')), '（執筆中）') === 0);
    }));
};
$strengthsWeaknesses = $akumaDraftFilter($strengthsWeaknesses);
$basicTactics        = $akumaDraftFilter($basicTactics);

// 3b. 豪鬼専用コンボ（実戦コンボ集／リーサル判断の両方をここから分配する）
$akumaCombos    = getAkumaCombos($pdo);
$practicalCombos = array_values(array_filter($akumaCombos, fn($c) => $c['purpose'] === 'practical'));
$lethalCombos     = array_values(array_filter($akumaCombos, fn($c) => $c['purpose'] === 'lethal'));

// 3b-2. 始動技（豪鬼の技DB = frame テーブル）の引き当てと、絞り込みセレクトに出す技の抽出
//   実戦コンボ集の絞り込み：purpose = practical のコンボで使われている始動技だけ
//   リーサル判断の絞り込み：全コンボ（practical + lethal）で使われている始動技だけ
$akumaFrameMap = akumaFrameMapByStartKey($all_frames);
$usedStartKeysPractical = [];
$usedStartKeysAll       = [];
foreach ($akumaCombos as $c) {
    $k = akumaStartMoveKey($c['start_move_slug'] ?? '', $c['start_move_variant'] ?? '');
    if ($k === '') { continue; }
    $usedStartKeysAll[$k] = true;
    if ($c['purpose'] === 'practical') { $usedStartKeysPractical[$k] = true; }
}
$startFramesPractical = array_values(array_filter($all_frames, fn($f) => isset($usedStartKeysPractical[akumaStartMoveKey($f['move_slug'], $f['move_variant'] ?? '')])));
$startFramesAll       = array_values(array_filter($all_frames, fn($f) => isset($usedStartKeysAll[akumaStartMoveKey($f['move_slug'], $f['move_variant'] ?? '')])));

// リーサル判断：相手キャラの体力(vitality)で「ダメージ ÷ 体力」を計算するための一覧
$lethalOpponents = getAllCharacters($pdo);

// 3c. 起き攻め／セットアップのマトリクス表 用データ
$akumaOpponentActions = getAkumaOpponentActions($pdo);
$akumaOkiSetups    = getAkumaOkiSetups($pdo, 'oki');
$akumaSetupSetups   = getAkumaOkiSetups($pdo, 'setup');

// 3d. 豪鬼視点でのキャラ対策（28キャラ分。豪鬼自身は一覧から除外する）
$allCharactersForMatchup = array_values(array_filter(getAllCharacters($pdo), fn($c) => $c['char_slug'] !== 'gouki'));
$akumaMatchupMap = getAllAkumaMatchups($pdo);

// 要注意技と確反（akuma_punishes）：相手キャラごとの一覧と、各行が参照する相手のフレーム（ガード時硬直差・技名）
$akumaPunishMap  = getAllAkumaPunishes($pdo);
$comboById       = [];
foreach ($akumaCombos as $c) { $comboById[(int)$c['id']] = $c; }
$punishOppFrames = [];   // "相手キャラID|slug|variant" => frame行
$punishOppIds    = array_keys($akumaPunishMap);
if (!empty($punishOppIds)) {
    $in   = implode(',', array_fill(0, count($punishOppIds), '?'));
    $stmt = $pdo->prepare("SELECT * FROM frame WHERE character_id IN ($in) ORDER BY sort_order ASC");
    $stmt->execute($punishOppIds);
    foreach ($stmt->fetchAll() as $f) {
        $punishOppFrames[(int)$f['character_id'] . '|' . akumaStartMoveKey($f['move_slug'], $f['move_variant'] ?? '')] = $f;
    }
}

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
    /**
     * @param array $frameMap   始動技キー => frame行（始動技名の表示用）
     * @param bool  $lethalSlot true のとき、リーサル判定の結果を JS が書き込むバッジ枠を付ける
     * @param int   $order      登録順（並べ替えのリセット用）
     */
    function renderAkumaComboCard(array $combo, array $frameMap = [], bool $lethalSlot = false, int $order = 0): string {
        $startKey = akumaStartMoveKey($combo['start_move_slug'] ?? '', $combo['start_move_variant'] ?? '');
        $position = $combo['position'] ?? 'Any';
        $hitType  = $combo['hit_type'] ?? 'Normal';

        $html  = '<div class="grid-card akuma-combo-card"';
        $html .= ' data-purpose="' . h($combo['purpose']) . '"';
        $html .= ' data-start="' . h($startKey) . '"';
        $html .= ' data-position="' . h($position) . '"';
        $html .= ' data-hit="' . h($hitType) . '"';
        $html .= ' data-drive="' . (int)$combo['drive_gauge'] . '"';
        $html .= ' data-sa="' . (int)($combo['sa_gauge'] ?? 0) . '"';
        $html .= ' data-damage="' . (int)$combo['damage'] . '"';
        $html .= ' data-order="' . $order . '">';
        $html .= '<div class="grid-card-title">' . h($combo['title']) . '</div>';
        $html .= '<div class="akuma-card-tags">';
        $html .= '<span class="combo-badge">' . h(translateDifficulty($combo['difficulty'])) . '</span>';
        if ($startKey !== '' && isset($frameMap[$startKey])) {
            $html .= '<span class="combo-badge">始動：' . h(akumaStartMoveLabel($frameMap[$startKey])) . '</span>';
        }
        if ($position !== 'Any') {
            $html .= '<span class="combo-badge">' . h(akumaComboPositionOptions()[$position] ?? $position) . '</span>';
        }
        if ($hitType !== 'Normal') {
            $html .= '<span class="combo-badge">' . h(akumaComboHitTypeOptions()[$hitType] ?? $hitType) . '</span>';
        }
        $html .= '</div>';
        if ($lethalSlot) {
            $html .= '<div class="akuma-lethal-badge" hidden></div>';
        }
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
 * 相手キャラ1人分の「要注意技と確反」（akuma_punishes）をHTML化する。
 * 相手の技ごとにまとめ、その中に「距離・位置」ごとの反撃（豪鬼のコンボ）を並べる。
 * フレーム上の確反判定（始動技の発生 ≦ ガード時の不利F）は、技DBの値から自動で表示する。
 */
if (!function_exists('renderAkumaPunishList')) {
    function renderAkumaPunishList(array $punishRows, int $oppCharId, array $oppFrames, array $comboById, array $akumaFrameMap): string {
        if (empty($punishRows)) {
            return '';
        }
        // 相手の技ごとにグループ化
        $groups = [];
        foreach ($punishRows as $row) {
            $key = akumaStartMoveKey($row['opponent_move_slug'], $row['opponent_move_variant'] ?? '');
            $groups[$key][] = $row;
        }
        // 並び：ガード時の不利が大きい技（必要発生Fが大きい）から。不利でない技は後ろ
        uksort($groups, function ($ka, $kb) use ($oppFrames, $oppCharId) {
            $na = akumaPunishFrameCheck($oppFrames[$oppCharId . '|' . $ka] ?? null, null)['need'];
            $nb = akumaPunishFrameCheck($oppFrames[$oppCharId . '|' . $kb] ?? null, null)['need'];
            return ($nb ?? -1) <=> ($na ?? -1);
        });

        $distLabels = akumaPunishDistanceOptions();
        $posLabels  = akumaComboPositionOptions();

        $html  = '<details class="akuma-punish-fold">';
        $html .= '<summary>要注意技と確反（' . count($punishRows) . '件）</summary>';
        foreach ($groups as $key => $rows) {
            $oppFrame = $oppFrames[$oppCharId . '|' . $key] ?? null;
            $need     = akumaPunishFrameCheck($oppFrame, null)['need'];
            $html .= '<div class="akuma-punish-move">';
            $html .= '<div class="akuma-punish-move-head">';
            $html .= '<strong>' . h($oppFrame ? akumaStartMoveLabel($oppFrame) : $key) . '</strong>';
            if ($oppFrame) {
                $guard = trim((string)($oppFrame['guard_adv'] ?? ''));
                if ($guard !== '') {
                    $html .= '<span class="punish-move-adv ' . frameAdvClass($guard) . '">ガード ' . h($guard) . 'F</span>';
                }
                if (isset($oppFrame['startup']) && $oppFrame['startup'] !== '') {
                    $html .= '<span class="akuma-punish-meta">発生 ' . h($oppFrame['startup']) . 'F</span>';
                }
                $html .= '<span class="punish-move-type">' . h(translateMoveType((string)$oppFrame['move_type'])) . '</span>';
            }
            $html .= '</div>';

            foreach ($rows as $row) {
                $combo  = $comboById[(int)($row['akuma_combo_id'] ?? 0)] ?? null;
                $startK = $combo ? akumaStartMoveKey($combo['start_move_slug'] ?? '', $combo['start_move_variant'] ?? '') : '';
                $startF = ($startK !== '') ? ($akumaFrameMap[$startK] ?? null) : null;
                $check  = akumaPunishFrameCheck($oppFrame, $startF);

                $html .= '<div class="akuma-punish-row">';
                $html .= '<div class="akuma-punish-cond">';
                $html .= '<span class="combo-badge">' . h($distLabels[$row['distance']] ?? $row['distance']) . '</span>';
                $html .= '<span class="combo-badge">' . h($posLabels[$row['position']] ?? $row['position']) . '</span>';
                $html .= '</div>';
                $html .= '<div class="akuma-punish-body">';
                if ($combo) {
                    $html .= '<div class="akuma-punish-combo-title">' . h($combo['title']);
                    if ($startF) {
                        $html .= '<span class="akuma-punish-meta">始動：' . h(akumaStartMoveLabel($startF)) . '（発生 ' . h($startF['startup'] ?? '-') . 'F）</span>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="combo-command">' . convertCommandToIcons($combo['recipe']) . '</div>';
                    $html .= '<div class="akuma-punish-meta">ダメージ ' . (int)$combo['damage'] . ' / 消費ドライブ ' . (int)$combo['drive_gauge']
                           . (((int)($combo['sa_gauge'] ?? 0)) > 0 ? ' / 消費SA ' . (int)$combo['sa_gauge'] : '') . '</div>';
                    if ($check['ok'] === false) {
                        $html .= '<div class="akuma-punish-warn">⚠ フレーム上は間に合いません（始動技 ' . (int)$check['startup'] . 'F ＞ 必要 ' . (int)$check['need'] . 'F）。補足の条件を確認してください。</div>';
                    }
                }
                if (!empty($row['note'])) {
                    $html .= '<div class="combo-note">' . renderMatchupMultiline($row['note']) . '</div>';
                }
                $html .= '</div></div>';
            }
            $html .= '</div>';
        }
        $html .= '</details>';
        return $html;
    }
}

/**
 * akuma_matchups の1件（無い場合は null）を、相手キャラ1人分のカードとしてHTML化する。
 * 要注意技と確反（akuma_punishes）があれば、カードの下に折りたたみで表示する（開くとカードが全幅に広がる）。
 */
if (!function_exists('renderAkumaMatchupCard')) {
    function renderAkumaMatchupCard(array $character, ?array $matchup, string $punishHtml = ''): string {
        $name = $character['name_jp'] ?? $character['char_slug'];
        $html = '<div class="grid-card akuma-matchup-card">';
        $html .= '<div class="grid-card-title">' . h($name) . '</div>';

        if ($matchup === null && $punishHtml === '') {
            $html .= '<div style="color:var(--text-secondary); font-size:0.85rem;">🚧 準備中</div>';
            $html .= '</div>';
            return $html;
        }

        if ($matchup !== null) {
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
        }
        $html .= $punishHtml;
        $html .= '</div>';
        return $html;
    }
}

// 5b. タブ構成：立ち回り / コンボ / 起き攻め / 対キャラ / データ
//   開いた直後は「内容のある最初のタブ」を表示する（準備中のタブから始まらないように）。
//   内容が無いタブは、ボタンを少し薄く表示して「まだ準備中」が分かるようにする。
$akumaTabs = [
    'tab-tactics'  => '立ち回り',
    'tab-combos'   => 'コンボ',
    'tab-oki'      => '起き攻め',
    'tab-matchups' => '対キャラ',
    'tab-data'     => 'データ',
];
$akumaTabHasContent = [
    'tab-tactics'  => (!empty($strengthsWeaknesses) || !empty($basicTactics)),
    'tab-combos'   => !empty($akumaCombos),
    'tab-oki'      => (!empty($akumaOkiSetups) || !empty($akumaSetupSetups)),
    'tab-matchups' => (!empty($akumaMatchupMap) || !empty($akumaPunishMap)),
    'tab-data'     => !empty($all_frames),
];
$akumaDefaultTab = 'tab-tactics';
foreach ($akumaTabHasContent as $tabId => $has) {
    if ($has) { $akumaDefaultTab = $tabId; break; }
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

    <!-- タブナビゲーション -->
    <div class="tab-navigation akuma-tab-nav" role="tablist">
      <?php foreach ($akumaTabs as $tabId => $tabLabel): ?>
        <button class="tab-btn<?php echo $tabId === $akumaDefaultTab ? ' active' : ''; ?><?php echo empty($akumaTabHasContent[$tabId]) ? ' is-empty' : ''; ?>"
                type="button" role="tab" data-tab-target="<?php echo h($tabId); ?>"><?php echo h($tabLabel); ?></button>
      <?php endforeach; ?>
    </div>

    <!-- ==================== タブ：tab-tactics ==================== -->
    <div class="tab-content<?php echo $akumaDefaultTab === 'tab-tactics' ? ' active' : ''; ?>" id="tab-tactics" role="tabpanel">

    <!-- 強み・弱み -->
    <section id="strengths-weaknesses" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">強み・弱み</h2>
      <?php if (empty($strengthsWeaknesses)): ?>
        <div class="alert-box">
          <div class="alert-title">🚧 準備中</div>
          <div class="alert-content">豪鬼の強み・弱みの総評は現在準備中です。</div>
        </div>
      <?php endif; ?>
      <?php foreach ($strengthsWeaknesses as $block): ?>
        <?php echo renderContentBlock($block); ?>
      <?php endforeach; ?>
    </section>

    <!-- 立ち回りの基本 -->
    <section id="basic-tactics" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">立ち回りの基本</h2>
      <?php if (empty($basicTactics)): ?>
        <div class="alert-box">
          <div class="alert-title">🚧 準備中</div>
          <div class="alert-content">立ち回りの基本は現在準備中です。</div>
        </div>
      <?php endif; ?>
      <?php foreach ($basicTactics as $block): ?>
        <?php echo renderContentBlock($block); ?>
      <?php endforeach; ?>
    </section>

    </div>

    <!-- ==================== タブ：tab-combos ==================== -->
    <div class="tab-content<?php echo $akumaDefaultTab === 'tab-combos' ? ' active' : ''; ?>" id="tab-combos" role="tabpanel">

    <!-- 実戦コンボ集：始動技・位置・ヒット状況・使えるゲージで絞り込み／並べ替え -->
    <section id="practical-combos" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">実戦コンボ集</h2>
      <?php if (empty($practicalCombos)): ?>
        <div class="alert-box">
          <div class="alert-title">🚧 準備中</div>
          <div class="alert-content">現在、実戦コンボはまだ登録されていません。</div>
        </div>
      <?php else: ?>
        <div class="akuma-filter-bar" id="practicalFilter">
          <div class="akuma-filter-field">
            <label for="pcStart">始動技</label>
            <select id="pcStart">
              <option value="">すべて</option>
              <?php echo renderAkumaStartMoveOptions($startFramesPractical); ?>
            </select>
          </div>
          <div class="akuma-filter-field">
            <label for="pcPos">位置</label>
            <select id="pcPos">
              <option value="">すべて</option>
              <option value="Center">中央</option>
              <option value="OppCorner">相手が端</option>
              <option value="SelfCorner">自分が端</option>
            </select>
          </div>
          <div class="akuma-filter-field">
            <label for="pcHit">ヒット状況</label>
            <select id="pcHit">
              <option value="">すべて</option>
              <?php foreach (akumaComboHitTypeOptions() as $val => $label): ?>
                <option value="<?php echo h($val); ?>"><?php echo h($label); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="akuma-filter-field">
            <label for="pcDrive">使えるドライブ</label>
            <select id="pcDrive">
              <?php for ($i = 0; $i <= 6; $i++): ?>
                <option value="<?php echo $i; ?>" <?php echo $i === 6 ? 'selected' : ''; ?>><?php echo $i === 6 ? '制限なし（6本）' : $i . '本まで'; ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="akuma-filter-field">
            <label for="pcSa">使えるSA</label>
            <select id="pcSa">
              <?php for ($i = 0; $i <= 3; $i++): ?>
                <option value="<?php echo $i; ?>" <?php echo $i === 3 ? 'selected' : ''; ?>><?php echo $i === 3 ? '制限なし（SA3）' : ($i === 0 ? '使わない' : 'SA' . $i . 'まで'); ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="akuma-filter-field">
            <label for="pcSort">並び順</label>
            <select id="pcSort">
              <option value="default">登録順</option>
              <option value="damage">ダメージが高い順</option>
              <option value="drive">ドライブ消費が少ない順</option>
            </select>
          </div>
          <button type="button" class="filter-btn" id="pcReset">条件をリセット</button>
        </div>
        <div class="akuma-filter-count" id="practicalCount" aria-live="polite"></div>
        <div class="card-grid combo-list" id="practicalComboGrid">
          <?php foreach ($practicalCombos as $i => $combo): ?>
            <?php echo renderAkumaComboCard($combo, $akumaFrameMap, false, $i); ?>
          <?php endforeach; ?>
        </div>
        <div class="alert-box" id="practicalNoResult" style="display:none; margin-top:12px;">
          <div class="alert-content">この条件に合うコンボはありません。条件を変えてみてください。</div>
        </div>
      <?php endif; ?>
    </section>

    <!-- リーサル判断：相手キャラの体力 × 残り体力 × 自分のゲージ から、リーサルになるコンボを判定 -->
    <section id="lethal-combos" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">リーサル判断</h2>
      <p class="hero-header-desc" style="margin-bottom:16px;">相手キャラと残り体力、自分が使えるゲージ、始動技（確反なら確反に使う技）を指定すると、「ダメージ ≧ 残り体力」になるコンボを判定します。ダメージは各コンボに登録された値（登録時のヒット状況・位置での値）で、実戦では補正などで前後することがあります。</p>

      <?php if (empty($akumaCombos)): ?>
        <div class="alert-box">
          <div class="alert-title">🚧 準備中</div>
          <div class="alert-content">現在、コンボがまだ登録されていないため、リーサル判断は利用できません。</div>
        </div>
      <?php else: ?>
        <div class="akuma-filter-bar" id="lethalFilter">
          <div class="akuma-filter-field">
            <label for="lcOpp">相手キャラ（体力）</label>
            <select id="lcOpp">
              <option value="10000" data-vitality="10000">標準（体力10000）</option>
              <?php foreach ($lethalOpponents as $opp): ?>
                <option value="<?php echo (int)$opp['id']; ?>" data-vitality="<?php echo (int)$opp['vitality']; ?>"><?php echo h($opp['name_jp']); ?>（<?php echo (int)$opp['vitality']; ?>）</option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="akuma-filter-field akuma-filter-field--wide">
            <label for="lcHp">相手の残り体力</label>
            <div class="akuma-range-row">
              <input type="range" id="lcHp" min="1" max="100" value="30">
              <span id="lcHpValue" class="combo-badge"></span>
            </div>
          </div>
          <div class="akuma-filter-field">
            <label for="lcStart">始動技</label>
            <select id="lcStart">
              <option value="">すべて</option>
              <?php echo renderAkumaStartMoveOptions($startFramesAll); ?>
            </select>
          </div>
          <div class="akuma-filter-field">
            <label for="lcPos">位置</label>
            <select id="lcPos">
              <option value="">すべて</option>
              <option value="Center">中央</option>
              <option value="OppCorner">相手が端</option>
              <option value="SelfCorner">自分が端</option>
            </select>
          </div>
          <div class="akuma-filter-field">
            <label for="lcHit">ヒット状況</label>
            <select id="lcHit">
              <option value="">すべて</option>
              <?php foreach (akumaComboHitTypeOptions() as $val => $label): ?>
                <option value="<?php echo h($val); ?>"><?php echo h($label); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="akuma-filter-field">
            <label for="lcDrive">使えるドライブ</label>
            <select id="lcDrive">
              <?php for ($i = 0; $i <= 6; $i++): ?>
                <option value="<?php echo $i; ?>" <?php echo $i === 6 ? 'selected' : ''; ?>><?php echo $i === 6 ? '制限なし（6本）' : $i . '本まで'; ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="akuma-filter-field">
            <label for="lcSa">使えるSA</label>
            <select id="lcSa">
              <?php for ($i = 0; $i <= 3; $i++): ?>
                <option value="<?php echo $i; ?>" <?php echo $i === 3 ? 'selected' : ''; ?>><?php echo $i === 3 ? '制限なし（SA3）' : ($i === 0 ? '使わない' : 'SA' . $i . 'まで'); ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <label class="akuma-filter-check"><input type="checkbox" id="lcOnly" checked> リーサルになるコンボだけ表示</label>
        </div>
        <div class="akuma-lethal-summary" id="lcSummary" aria-live="polite"></div>
        <div class="card-grid combo-list" id="lethalComboGrid">
          <?php foreach ($akumaCombos as $i => $combo): ?>
            <?php echo renderAkumaComboCard($combo, $akumaFrameMap, true, $i); ?>
          <?php endforeach; ?>
        </div>
        <div class="alert-box" id="lethalNoResult" style="display:none; margin-top:12px;">
          <div class="alert-content">この条件でリーサルになるコンボはありません。「リーサルになるコンボだけ表示」を外すと、届かないコンボも確認できます。</div>
        </div>
      <?php endif; ?>
    </section>

    </div>

    <!-- ==================== タブ：tab-oki ==================== -->
    <div class="tab-content<?php echo $akumaDefaultTab === 'tab-oki' ? ' active' : ''; ?>" id="tab-oki" role="tabpanel">

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

    </div>

    <!-- ==================== タブ：tab-matchups ==================== -->
    <div class="tab-content<?php echo $akumaDefaultTab === 'tab-matchups' ? ' active' : ''; ?>" id="tab-matchups" role="tabpanel">

    <!-- 豪鬼視点でのキャラクター対策（28キャラ分） -->
    <section id="matchups" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">キャラクター対策</h2>
      <p class="hero-header-desc" style="margin-bottom:16px;">豪鬼ならではの行動（間合い・空中技の差し込み等）を踏まえた、相手キャラごとの対策。</p>
      <div class="card-grid">
        <?php foreach ($allCharactersForMatchup as $oppChar): ?>
          <?php echo renderAkumaMatchupCard(
              $oppChar,
              $akumaMatchupMap[$oppChar['id']] ?? null,
              renderAkumaPunishList($akumaPunishMap[(int)$oppChar['id']] ?? [], (int)$oppChar['id'], $punishOppFrames, $comboById, $akumaFrameMap)
          ); ?>
        <?php endforeach; ?>
      </div>
    </section>

    </div>

    <!-- ==================== タブ：tab-data ==================== -->
    <div class="tab-content<?php echo $akumaDefaultTab === 'tab-data' ? ' active' : ''; ?>" id="tab-data" role="tabpanel">

    <!-- フレームデータ -->
    <section id="frame-data" style="margin-bottom:32px;">
      <h2 class="hero-header-title" style="font-size:1.3rem;">フレームデータ</h2>
      <?php if (empty($all_frames)): ?>
        <div class="alert-box">
          <div class="alert-title">💡 Notice</div>
          <div class="alert-content">現在、フレームデータは登録されていません。</div>
        </div>
      <?php else: ?>
        <?php echo renderFrameTable($all_frames, 'frame-table-akuma'); ?>
      <?php endif; ?>
    </section>

    </div>

  </main>
</div>

<script src="js/frame-table.js?v=<?php echo (int)@filemtime(__DIR__ . '/js/frame-table.js'); ?>"></script>

<!-- タブ切り替え：ボタン／目次リンク／URLのハッシュ（#tab-combos や #lethal-combos）に対応 -->
<script>
  (function () {
    var buttons = Array.prototype.slice.call(document.querySelectorAll('.tab-btn[data-tab-target]'));
    var panels  = Array.prototype.slice.call(document.querySelectorAll('.tab-content'));
    if (buttons.length === 0) return;

    function showTab(id) {
      buttons.forEach(function (b) { b.classList.toggle('active', b.dataset.tabTarget === id); });
      panels.forEach(function (p) { p.classList.toggle('active', p.id === id); });
    }
    function panelOf(el) {
      return el.classList.contains('tab-content') ? el : el.closest('.tab-content');
    }
    // 要素のあるタブを開き、必要ならその位置までスクロールする
    function openTarget(id, scroll) {
      var el = document.getElementById(id);
      if (!el) return false;
      var panel = panelOf(el);
      if (!panel) return false;
      showTab(panel.id);
      if (scroll && el !== panel) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
      return true;
    }

    buttons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        showTab(btn.dataset.tabTarget);
        if (history.replaceState) history.replaceState(null, '', '#' + btn.dataset.tabTarget);
      });
    });

    // 左の目次リンク：対象が別のタブにあっても、そのタブを開いてからスクロールする
    var sidebar = document.getElementById('sidebar');
    if (sidebar) {
      sidebar.addEventListener('click', function (e) {
        var a = e.target.closest('a[href^="#"]');
        if (!a) return;
        var id = a.getAttribute('href').slice(1);
        if (openTarget(id, true)) {
          e.preventDefault();
          if (history.replaceState) history.replaceState(null, '', '#' + id);
        }
      });
    }

    // 初期表示・戻る/進む：ハッシュが指すタブを開く（ハッシュが無ければサーバー側で決めた初期タブのまま）
    function fromHash() {
      var h = location.hash.slice(1);
      if (h) openTarget(h, true);
    }
    window.addEventListener('hashchange', fromHash);
    fromHash();
  })();
</script>

<!-- 実戦コンボ集の絞り込み／リーサル判断（相手の体力 × ダメージ × 使えるゲージ） -->
<script>
  (function () {
    function toInt(v, d) { var n = parseInt(v, 10); return isNaN(n) ? d : n; }
    function val(id) { var el = document.getElementById(id); return el ? el.value : ''; }
    function fmt(n) { return Number(n).toLocaleString('ja-JP'); }

    // 位置：「位置問わず」のコンボは、どの位置を選んでも表示する
    function posMatch(sel, cardPos) { return sel === '' || cardPos === 'Any' || cardPos === sel; }

    // 始動技・位置・ヒット状況・ドライブ・SA の共通判定
    function baseMatch(card, f) {
      if (f.start !== '' && card.dataset.start !== f.start) return false;
      if (!posMatch(f.pos, card.dataset.position)) return false;
      if (f.hit !== '' && card.dataset.hit !== f.hit) return false;
      if (toInt(card.dataset.drive, 0) > f.drive) return false;
      if (toInt(card.dataset.sa, 0) > f.sa) return false;
      return true;
    }

    // ---------- 実戦コンボ集 ----------
    var pGrid = document.getElementById('practicalComboGrid');
    if (pGrid) {
      var pCards = Array.prototype.slice.call(pGrid.querySelectorAll('.akuma-combo-card'));
      var pCount = document.getElementById('practicalCount');
      var pNo    = document.getElementById('practicalNoResult');
      var pIds   = ['pcStart', 'pcPos', 'pcHit', 'pcDrive', 'pcSa', 'pcSort'];

      function pApply() {
        var f = { start: val('pcStart'), pos: val('pcPos'), hit: val('pcHit'), drive: toInt(val('pcDrive'), 6), sa: toInt(val('pcSa'), 3) };
        var sort = val('pcSort');
        var shown = 0;
        pCards.forEach(function (c) {
          var ok = baseMatch(c, f);
          c.style.display = ok ? '' : 'none';
          if (ok) shown++;
        });
        pCards.slice().sort(function (a, b) {
          var da = toInt(a.dataset.damage, 0), db = toInt(b.dataset.damage, 0);
          if (sort === 'damage') return db - da;
          if (sort === 'drive') return (toInt(a.dataset.drive, 0) - toInt(b.dataset.drive, 0)) || (db - da);
          return toInt(a.dataset.order, 0) - toInt(b.dataset.order, 0);
        }).forEach(function (c) { pGrid.appendChild(c); });
        pCount.textContent = shown + '件を表示（全' + pCards.length + '件）';
        pNo.style.display = shown === 0 ? '' : 'none';
      }

      pIds.forEach(function (id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('change', pApply);
      });
      var pReset = document.getElementById('pcReset');
      if (pReset) {
        pReset.addEventListener('click', function () {
          document.getElementById('pcStart').value = '';
          document.getElementById('pcPos').value = '';
          document.getElementById('pcHit').value = '';
          document.getElementById('pcDrive').value = '6';
          document.getElementById('pcSa').value = '3';
          document.getElementById('pcSort').value = 'default';
          pApply();
        });
      }
      pApply();
    }

    // ---------- リーサル判断 ----------
    var lGrid = document.getElementById('lethalComboGrid');
    if (lGrid) {
      var lCards  = Array.prototype.slice.call(lGrid.querySelectorAll('.akuma-combo-card'));
      var oppSel  = document.getElementById('lcOpp');
      var hpRange = document.getElementById('lcHp');
      var hpValue = document.getElementById('lcHpValue');
      var onlyChk = document.getElementById('lcOnly');
      var summary = document.getElementById('lcSummary');
      var lNo     = document.getElementById('lethalNoResult');
      var lIds    = ['lcOpp', 'lcHp', 'lcStart', 'lcPos', 'lcHit', 'lcDrive', 'lcSa', 'lcOnly'];

      function lApply() {
        var vit    = toInt(oppSel.options[oppSel.selectedIndex].dataset.vitality, 10000);
        var pct    = toInt(hpRange.value, 30);
        var remain = Math.round(vit * pct / 100);
        hpValue.textContent = pct + '%（' + fmt(remain) + '）';

        var f = { start: val('lcStart'), pos: val('lcPos'), hit: val('lcHit'), drive: toInt(val('lcDrive'), 6), sa: toInt(val('lcSa'), 3) };
        var shown = 0, eligibleCount = 0, best = null;

        lCards.forEach(function (c) {
          var eligible = baseMatch(c, f);
          var dmg      = toInt(c.dataset.damage, 0);
          var lethal   = dmg >= remain;
          var badge    = c.querySelector('.akuma-lethal-badge');
          var show     = eligible && (!onlyChk.checked || lethal);

          c.style.display = show ? '' : 'none';
          if (show) shown++;
          if (eligible) {
            eligibleCount++;
            if (best === null || dmg > toInt(best.dataset.damage, 0)) best = c;
          }
          if (badge) {
            if (eligible) {
              badge.hidden = false;
              badge.className = 'akuma-lethal-badge ' + (lethal ? 'is-ok' : 'is-ng');
              badge.textContent = lethal ? '✅ リーサル可（+' + fmt(dmg - remain) + '）' : '❌ あと' + fmt(remain - dmg) + '足りない';
            } else {
              badge.hidden = true;
            }
          }
        });

        // ダメージが高い順に並べる
        lCards.slice().sort(function (a, b) {
          return toInt(b.dataset.damage, 0) - toInt(a.dataset.damage, 0);
        }).forEach(function (c) { lGrid.appendChild(c); });

        if (best === null) {
          summary.className = 'akuma-lethal-summary';
          summary.textContent = '条件に合うコンボが登録されていません。始動技や位置、ゲージの条件を緩めてみてください。';
        } else {
          var bestDmg = toInt(best.dataset.damage, 0);
          var bestTitle = best.querySelector('.grid-card-title').textContent;
          var ok = bestDmg >= remain;
          summary.className = 'akuma-lethal-summary ' + (ok ? 'is-ok' : 'is-ng');
          summary.textContent = '残り体力 ' + fmt(remain) + ' に対して、この条件の最大ダメージは ' + fmt(bestDmg) + '（' + bestTitle + '）。'
            + (ok ? 'リーサルを狙えます。' : 'あと ' + fmt(remain - bestDmg) + ' 届きません。');
        }
        lNo.style.display = (shown === 0 && eligibleCount > 0) ? '' : 'none';
      }

      lIds.forEach(function (id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.addEventListener(id === 'lcHp' ? 'input' : 'change', lApply);
      });
      lApply();
    }
  })();
</script>

<?php include 'includes/footer.php'; ?>
