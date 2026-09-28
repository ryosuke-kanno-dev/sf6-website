<?php
// 1. DB接続・共通関数の読み込み
require_once 'includes/db.php';
require_once 'includes/functions/db_helpers.php';
require_once 'includes/functions/command_converter.php';

// buildComboSituationLabel() / translateDifficulty() / comboCategoryKey() / comboCategoryLabel() /
// comboCategoryOrder() / renderComboMemo() は includes/functions/db_helpers.php に
// 共通定義を移動しました（admin/ 側と共用するため）。

// frameAdvClass() / translateMoveType() は includes/functions/db_helpers.php に
// 共通定義を移動しました（admin/ 側と共用するため）。

// matchupCategoryLabel() / matchupCategoryOrder() / matchupConditionTagLabel() は
// includes/functions/db_helpers.php に共通定義を移動しました（admin/ 側と共用するため）。

/**
 * key_points / overview / matchup_guides.content 用のレンダラー。
 * - DB内の改行が実改行ではなく、文字列としてのバックスラッシュn（"\\n"）で
 *   保存されているケースがあるため、まず実改行へ正規化する。
 * - "- " で始まる行 → <ul><li> の箇条書きとしてグループ化
 * - "■" で始まる行 → 太字見出し
 * - それ以外の行 → 通常テキスト（<br>区切り）
 * - 空行はスキップ（Markdown由来の "  \n" ハードブレイク記法にも対応するため rtrim() する）
 */
if (!function_exists('renderMatchupMultiline')) {
    function renderMatchupMultiline(string $text): string {
        // 文字列としての "\r\n" / "\n" / "\r"（バックスラッシュ+文字）を実改行に正規化
        $text = str_replace(['\\r\\n', '\\n', '\\r'], "\n", $text);

        $lines  = preg_split('/\r\n|\r|\n/', $text);
        $html   = '';
        $inList = false;

        foreach ($lines as $line) {
            $trimmed = rtrim($line); // Markdownのハードブレイク記法（行末の半角スペース2つ）等を除去

            if (preg_match('/^-\s+(.*)$/u', $trimmed, $m)) {
                if (!$inList) {
                    $html .= '<ul class="glossary-block-list">';
                    $inList = true;
                }
                $html .= '<li>' . h($m[1]) . '</li>';
                continue;
            }

            if ($inList) {
                $html .= '</ul>';
                $inList = false;
            }

            if ($trimmed === '') {
                continue;
            }

            if (mb_substr($trimmed, 0, 1, 'UTF-8') === '■') {
                $html .= '<strong class="training-block-heading">' . h($trimmed) . '</strong><br>';
            } else {
                $html .= h($trimmed) . '<br>';
            }
        }

        if ($inList) {
            $html .= '</ul>';
        }

        return $html;
    }
}

/**
 * characters.profile_text 等の紹介文用レンダラー。
 * 改行の正規化は renderMatchupMultiline() 側で行うため、ここではそのまま委譲する。
 */
if (!function_exists('renderProfileText')) {
    function renderProfileText(string $text): string {
        return renderMatchupMultiline($text);
    }
}

// renderComboMemo() は includes/functions/db_helpers.php に共通定義を移動しました。

// 2. URLパラメータからキャラクタースラッグを取得（未指定・不正時は 'luke' をデフォルトに）
$char_slug = isset($_GET['char']) ? trim($_GET['char']) : 'luke';

$character = getCharacterBySlug($pdo, $char_slug);

// 指定スラッグが存在しない場合は 'luke' にフォールバック
if (!$character) {
    $character = getCharacterBySlug($pdo, 'luke');
}

// それでも取得できない場合（DBが空 等）は致命的エラーとして停止
if (!$character) {
    die('キャラクターデータが見つかりませんでした。DBの初期データを確認してください。');
}

// 3. 取得したキャラクター情報をページ変数へバインド
$selected_char      = $character['name_jp'] . ' (' . $character['name_en'] . ')';
$selected_char_icon = mb_strtoupper(mb_substr($character['name_en'], 0, 1, 'UTF-8'), 'UTF-8');
$page_title          = "3. {$selected_char} 攻略まとめ | SF6 PORTAL";
$current_page        = "character";

// 4. 関連データの取得
$combos        = getCombosByCharId($pdo, $character['id']);
$punish_frames = getPunishableFramesByCharId($pdo, $character['id']);
$all_frames    = getFrameDataByCharId($pdo, $character['id']);

// combos の中から「確定反撃」用（hit_type = Punish）のものだけを抽出
// （matchup/matchup_guides テーブルが未確認のため、既存の combos データで代用）
$punish_combos = array_values(array_filter($combos, function ($combo) {
    return ($combo['hit_type'] ?? '') === 'Punish';
}));

// コンボ集タブ用：中央／画面端／パニカン・確定反撃始動 の3カテゴリにグループ化
$combosByCategory = [];
foreach ($combos as $combo) {
    $combosByCategory[comboCategoryKey($combo)][] = $combo;
}

// キャラ対策総評（matchup）＋対策コラム一覧（matchup_guides）の取得
$matchup_data   = getMatchupGuideByCharId($pdo, $character['id']);
$matchup        = $matchup_data['matchup'];
$matchup_guides = $matchup_data['guides'];

// matchup_guides.move_slug から frame データを逆引きするためのマップ（追加クエリ不要で参照する）
$framesBySlug = array_column($all_frames, null, 'move_slug');

// category = 'summary'（クイックサマリー：試合前の3大重要ポイント）は専用セクションで先頭表示するため分離
// それ以外はカテゴリごとにグルーピング（表示順は matchupCategoryOrder() の並びに従う）
$summary_guides   = [];
$guidesByCategory = [];
foreach ($matchup_guides as $guide) {
    if ($guide['category'] === 'summary') {
        $summary_guides[] = $guide;
    } else {
        $guidesByCategory[$guide['category']][] = $guide;
    }
}

// 確定反撃リスト用：matchup_guides の category='punish' を move_slug で逆引きするマップ
// （frame テーブルの確反候補技 1件ごとに、対応する解説テキストがあれば紐付けて表示するため）
$punishGuideBySlug = [];
foreach (($guidesByCategory['punish'] ?? []) as $punishGuide) {
    if (!empty($punishGuide['move_slug'])) {
        $punishGuideBySlug[$punishGuide['move_slug']] = $punishGuide;
    }
}

// 5. Head部分の読み込み
include 'includes/head.php';
?>

<!-- 6. ヘッダー読み込み -->
<?php include 'includes/header.php'; ?>

<!-- 7. メインレイアウト領域 -->
<div class="main-wrapper">

  <!-- 左サイドバー読み込み -->
  <?php include 'includes/char-sidebar.php'; ?>

  <!-- 右メインコンテンツ領域 -->
  <main class="content-area">

    <div class="page-header">
      <div class="breadcrumb">ホーム &gt; キャラ攻略 &gt; <?php echo h($selected_char); ?></div>
      <h1 class="page-title">3. <?php echo h($selected_char); ?> 攻略まとめ</h1>
      <p class="page-desc"><?php echo h($character['name_jp']); ?>のコンボ・確定反撃・フレームデータの統合ガイド</p>
    </div>

    <!-- タブナビゲーション -->
    <div class="tab-navigation">
      <button class="tab-btn active" type="button" data-tab-target="tab-combos">【自キャラ用】コンボ集</button>
      <button class="tab-btn" type="button" data-tab-target="tab-matchup">【対策用】キャラ対策・確反</button>
      <button class="tab-btn" type="button" data-tab-target="tab-framedata">【データ】フレーム表</button>
    </div>

    <!-- ヒーローヘッダー（キャラ概要：どのタブでも共通の情報のため、タブの外に配置） -->
    <div class="hero-header">
      <h1 class="hero-header-title">🔰 <?php echo h($selected_char); ?> 概要</h1>
      <p class="hero-header-desc">
        <?php echo renderProfileText($character['profile_text'] ?? 'キャラクター紹介文は準備中です。'); ?>
      </p>
    </div>

    <!-- ============================================================ -->
    <!-- ①【自キャラ用】コンボ集 -->
    <!-- ============================================================ -->
    <div class="tab-content active" id="tab-combos">
      <?php if (empty($combos)): ?>
        <div class="alert-box">
          <div class="alert-title">💡 Notice</div>
          <div class="alert-content">現在、<?php echo h($selected_char); ?> のコンボデータは登録されていません。</div>
        </div>
      <?php else: ?>
        <?php foreach (comboCategoryOrder() as $categoryKey): ?>
          <?php if (empty($combosByCategory[$categoryKey])): continue; endif; ?>
          <h3 class="glossary-block-title" style="font-size:1.05rem; margin-top:20px;">
            <?php echo h(comboCategoryLabel($categoryKey)); ?>
            <span style="color:var(--text-secondary); font-weight:normal; font-size:0.8rem;">
              （<?php echo count($combosByCategory[$categoryKey]); ?>件）
            </span>
          </h3>
          <div class="card-grid" id="combo-<?php echo h($categoryKey); ?>">
            <?php foreach ($combosByCategory[$categoryKey] as $combo): ?>
              <div class="combo-card">
                <div class="combo-header">
                  <span class="combo-title">
                    <?php echo h(buildComboSituationLabel($combo)); ?>
                    <?php if (!empty($combo['is_recommended'])): ?>
                      <span class="combo-badge" style="margin-left:6px;">おすすめ</span>
                    <?php endif; ?>
                  </span>
                  <span class="combo-badge">難易度：<?php echo h(translateDifficulty($combo['difficulty'])); ?></span>
                </div>

                <div class="combo-command">
                  <?php echo convertCommandToIcons($combo['recipe']); ?>
                </div>

                <div class="combo-meta" style="display:flex; gap:16px; margin-bottom:8px; font-size:0.85rem; color:var(--text-secondary);">
                  <span>ダメージ：<strong style="color:var(--text-primary);"><?php echo (int)$combo['damage']; ?></strong></span>
                  <span>消費ドライブ：<strong style="color:var(--text-primary);"><?php echo (int)$combo['drive_gauge']; ?></strong></span>
                  <?php if (!empty($combo['sa_gauge'])): ?>
                    <span>消費SA：<strong style="color:var(--text-primary);"><?php echo (int)$combo['sa_gauge']; ?></strong></span>
                  <?php endif; ?>
                </div>

                <?php if (!empty($combo['memo'])): ?>
                  <div class="combo-note"><?php echo renderComboMemo($combo['memo']); ?></div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- ============================================================ -->
    <!-- ②【対策用】キャラ対策・確反 -->
    <!-- ============================================================ -->
    <div class="tab-content" id="tab-matchup">

      <!-- 対策総評（matchup） -->
      <?php // 対策総評・コラムが未登録の場合は「準備中」を案内する。
      //（確定反撃リストはフレームデータから自動算出されるため、それだけ表示されて唐突に終わって見えるのを防ぐ） ?>
      <?php if ($matchup === null && empty($matchup_guides)): ?>
        <div class="alert-box">
          <div class="alert-title">🚧 準備中</div>
          <div class="alert-content">
            <?php echo h($selected_char); ?> の対策総評・立ち回り解説は現在準備中です。
            <?php if (!empty($punish_frames)): ?>下の確定反撃リストはフレームデータから自動で算出しています。<?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

      <?php if ($matchup !== null || !empty($matchup_guides) || !empty($punish_frames)): ?>

        <?php if ($matchup !== null): ?>
          <div class="hero-header">
            <h1 class="hero-header-title">
              🛡 <?php echo h($selected_char); ?> 対策総評
              <span class="combo-badge" style="margin-left:8px;">
                対策難易度：<?php echo str_repeat('★', max(0, (int)$matchup['matchup_difficulty'])); ?>
              </span>
            </h1>

            <div style="display:flex; flex-wrap:wrap; gap:6px; margin:10px 0;">
              <?php if (!empty($matchup['has_reversal'])): ?>
                <span class="combo-badge">⚡ リバーサル技あり</span>
              <?php endif; ?>
              <?php if (!empty($matchup['has_projectile'])): ?>
                <span class="combo-badge">🌀 飛び道具あり</span>
              <?php endif; ?>
              <?php if (!empty($matchup['has_command_grab'])): ?>
                <span class="combo-badge">🤼 コマンド投げあり</span>
              <?php endif; ?>
              <?php if (!empty($matchup['has_install'])): ?>
                <span class="combo-badge">🔧 インストール技あり</span>
              <?php endif; ?>
            </div>

            <?php if (!empty($matchup['overview'])): ?>
              <p class="hero-header-desc"><?php echo renderMatchupMultiline($matchup['overview']); ?></p>
            <?php endif; ?>

            <?php if (!empty($matchup['strengths']) || !empty($matchup['weaknesses'])): ?>
              <div class="combo-note" style="margin-top:10px;">
                <?php if (!empty($matchup['strengths'])): ?>
                  <strong class="training-block-heading">■強み</strong><br>
                  <?php echo renderMatchupMultiline($matchup['strengths']); ?>
                <?php endif; ?>
                <?php if (!empty($matchup['weaknesses'])): ?>
                  <div style="<?php echo !empty($matchup['strengths']) ? 'margin-top:8px;' : ''; ?>">
                    <strong class="training-block-heading">■弱み</strong><br>
                    <?php echo renderMatchupMultiline($matchup['weaknesses']); ?>
                  </div>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($matchup['key_points'])): ?>
              <div class="combo-note" style="margin-top:10px;">
                <strong class="training-block-heading">■対策のキーポイント</strong><br>
                <?php echo renderMatchupMultiline($matchup['key_points']); ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <!-- クイックサマリー（category = 'summary'：試合前の3大重要ポイント。目立つ形で表示） -->
        <?php if (!empty($summary_guides)): ?>
          <div class="alert-box" style="margin-top:14px;">
            <div class="alert-title">🎯 試合前に意識すること</div>
            <div class="alert-content">
              <ol style="margin:6px 0 0; padding-left:1.2em;">
                <?php foreach ($summary_guides as $guide): ?>
                  <li style="margin-bottom:6px;">
                    <strong><?php echo h($guide['title']); ?></strong>
                    <?php if (!empty($guide['content'])): ?>
                      <br><span style="font-size:0.9rem;"><?php echo renderMatchupMultiline($guide['content']); ?></span>
                    <?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ol>
            </div>
          </div>
        <?php endif; ?>

        <!-- 確定反撃リスト（frame連携：guard_adv < 0 の技 + matchup_guides(punish)の解説を move_slug で紐付け） -->
        <?php if (!empty($punish_frames)): ?>
          <div class="table-container" id="anti-air" style="margin-top:14px;">
            <div class="glossary-block-title">🥊 確定反撃リスト</div>
            <table class="data-table">
              <thead>
                <tr>
                  <th>技名</th>
                  <th>発生(F)</th>
                  <th>ガード時硬直差</th>
                  <th>解説・おすすめ反撃</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($punish_frames as $frame): ?>
                  <?php $punishGuide = $punishGuideBySlug[$frame['move_slug']] ?? null; ?>
                  <tr>
                    <td><?php echo h($frame['move_name_jp']); ?></td>
                    <td><?php echo h($frame['startup']); ?></td>
                    <td class="<?php echo frameAdvClass($frame['guard_adv']); ?>">
                      <strong><?php echo h($frame['guard_adv']); ?></strong>
                    </td>
                    <td>
                      <?php if ($punishGuide !== null && !empty($punishGuide['content'])): ?>
                        <?php echo renderMatchupMultiline($punishGuide['content']); ?>
                      <?php else: ?>
                        <?php
                          // matchup_guides に対応する解説が無い場合のフォールバック表示
                          // guard_adv は VARCHAR（'-3' 等の数値表記）。(int)キャストは先頭の数値部分のみを解釈する。
                          $guardAdv = (int)$frame['guard_adv'];
                          echo $guardAdv <= -4 ? '確定反撃あり' : '状況次第';
                        ?>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <!-- おすすめの反撃例（combos.hit_type = Punish のコンボを流用） -->
          <?php if (!empty($punish_combos)): ?>
            <div class="table-container" style="margin-top:10px;">
              <div class="glossary-block-title">🥊 おすすめの確定反撃コンボ</div>
              <?php foreach ($punish_combos as $combo): ?>
                <div class="combo-card">
                  <div class="combo-header">
                    <span class="combo-title"><?php echo h(buildComboSituationLabel($combo)); ?></span>
                    <span class="combo-badge">難易度：<?php echo h(translateDifficulty($combo['difficulty'])); ?></span>
                  </div>
                  <div class="combo-command">
                    <?php echo convertCommandToIcons($combo['recipe']); ?>
                  </div>
                  <?php if (!empty($combo['memo'])): ?>
                    <div class="combo-note"><?php echo renderComboMemo($combo['memo']); ?></div>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        <?php endif; ?>

        <!-- カテゴリ別 対策コラム（matchup_guides） -->
        <?php foreach (matchupCategoryOrder() as $categoryKey): ?>
          <?php if (empty($guidesByCategory[$categoryKey])): continue; endif; ?>
          <div id="matchup-<?php echo h($categoryKey); ?>" style="margin-top:14px;">
            <div class="glossary-block-title">📌 <?php echo h(matchupCategoryLabel($categoryKey)); ?></div>
            <?php foreach ($guidesByCategory[$categoryKey] as $guide): ?>
              <?php
                // move_slug が指定されている場合、frame テーブルの該当技を逆引きして関連フレームデータを併記する
                $relatedMove = (!empty($guide['move_slug']) && isset($framesBySlug[$guide['move_slug']]))
                    ? $framesBySlug[$guide['move_slug']]
                    : null;
              ?>
              <details class="accordion-item">
                <summary class="accordion-title">
                  <?php echo h($guide['title']); ?>
                  <?php if (!empty($guide['condition_tag'])): ?>
                    <span class="combo-badge" style="margin-left:8px; font-size:0.7rem;"><?php echo h(matchupConditionTagLabel($guide['condition_tag'])); ?></span>
                  <?php endif; ?>
                </summary>
                <div class="accordion-content">
                  <?php if (!empty($guide['content'])): ?>
                    <p><?php echo renderMatchupMultiline($guide['content']); ?></p>
                  <?php endif; ?>

                  <?php if ($relatedMove !== null): ?>
                    <div class="combo-note" style="margin-top:10px;">
                      <strong>関連技：</strong><?php echo h($relatedMove['move_name_jp']); ?>
                      （発生<?php echo h($relatedMove['startup']); ?>F ／
                      ガード時<span class="<?php echo frameAdvClass($relatedMove['guard_adv']); ?>"><?php echo h($relatedMove['guard_adv']); ?></span>）
                    </div>
                  <?php endif; ?>
                </div>
              </details>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>

      <?php endif; ?>
    </div>

    <!-- ============================================================ -->
    <!-- ③【データ】フレーム表 -->
    <!-- ============================================================ -->
    <div class="tab-content" id="tab-framedata">
      <?php if (empty($all_frames)): ?>
        <div class="alert-box">
          <div class="alert-title">💡 Notice</div>
          <div class="alert-content">現在、<?php echo h($selected_char); ?> のフレームデータは登録されていません。</div>
        </div>
      <?php else: ?>
        <div class="table-container" id="frame-data">
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
    </div>

    <!-- ポイント注記（どのタブでも共通のため、タブの外に配置） -->
    <div class="alert-box">
      <div class="alert-title">💡 Point</div>
      <div class="alert-content">
        モダン操作の場合、簡易コマンドで使用すると威力が80%に補正されます。状況に応じてコマンド入力と使い分けるのがおすすめです。
      </div>
    </div>

  </main>
</div>

<!-- タブ切り替えJS -->
<script>
  (function () {
    var tabButtons  = document.querySelectorAll('.tab-btn[data-tab-target]');
    var tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var targetId = btn.dataset.tabTarget;

        tabButtons.forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');

        tabContents.forEach(function (content) {
          content.classList.toggle('active', content.id === targetId);
        });
      });
    });
  })();
</script>

<!-- 8. フッター読み込み -->
<?php include 'includes/footer.php'; ?>