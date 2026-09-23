<?php
require_once __DIR__ . '/includes/functions/content_blocks.php';

// ページごとの設定値
$page_title   = "2. トレモ練習メニュー | SF6 PORTAL";
$current_page = "training";

/**
 * BOM付きUTF-8 JSONファイルを安全に読み込むヘルパー。
 * 戻り値: [デコード結果(配列) or null, エラーメッセージ or null]
 */
if (!function_exists('loadJsonFile')) {
    function loadJsonFile(string $path): array {
        if (!file_exists($path)) {
            return [null, 'ファイルが見つかりません: ' . $path];
        }
        $raw = file_get_contents($path);
        if ($raw === false) {
            return [null, 'ファイルの読み込みに失敗しました: ' . $path];
        }
        $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw);
        $decoded = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [null, 'JSONの形式が不正です(' . basename($path) . '): ' . json_last_error_msg()];
        }
        return [$decoded, null];
    }
}

// 1. data/drills.json の読み込み（個々の練習メニュー）
$drills            = [];
$trainingLoadError = null;
[$drillsDecoded, $drillsErr] = loadJsonFile(__DIR__ . '/data/drills.json');
if ($drillsErr !== null) {
    $trainingLoadError = $drillsErr;
} elseif (!isset($drillsDecoded['drills']) || !is_array($drillsDecoded['drills'])) {
    $trainingLoadError = 'JSONの構造が不正です（"drills" 配列が見つかりません）。';
} else {
    $drills = $drillsDecoded['drills'];
}

// 2. data/training_guide.json の読み込み（ページ冒頭に固定表示する使い方ガイド）
$guideBlocks = [];
[$guideDecoded, $guideErr] = loadJsonFile(__DIR__ . '/data/training_guide.json');
if ($guideErr === null && isset($guideDecoded['guide']) && is_array($guideDecoded['guide'])) {
    $guideBlocks = $guideDecoded['guide'];
}

// 3. related_systems を用語集の用語名に解決するため、glossary.json も軽量に読み込む
$glossaryTermsById = [];
[$glossaryDecoded, ] = loadJsonFile(__DIR__ . '/data/glossary.json');
if (isset($glossaryDecoded['terms']) && is_array($glossaryDecoded['terms'])) {
    foreach ($glossaryDecoded['terms'] as $term) {
        if (!empty($term['id'])) {
            $glossaryTermsById[$term['id']] = $term;
        }
    }
}

// 4. フィルター用の固定カテゴリ／難易度（データの出現順に依存させない。
//    新カテゴリを追加する場合はここも更新すること）
$categoryOptions   = ['反応系', '全対応系', '精度系', 'コンボ安定化系'];
$difficultyOptions = ['初級', '中級', '上級'];

/**
 * 反撃設定(reversal_setup)の1スロットを説明文に変換する。
 * action_category が「レコード」の場合は record_ref を records[].label から解決する。
 */
if (!function_exists('renderReversalSlot')) {
    function renderReversalSlot(array $slot, array $recordsByKey): string {
        $category = $slot['action_category'] ?? '';
        if ($category === 'レコード') {
            $ref = $slot['record_ref'] ?? '';
            $label = $recordsByKey[$ref]['label'] ?? ('記録' . $ref);
            $desc = 'レコード「' . h($label) . '」';
        } else {
            $desc = h($category) . '：' . h($slot['action'] ?? '');
        }
        $delay = $slot['delay'] ?? '';
        if ($delay !== '') {
            $desc .= '（ディレイ ' . h($delay) . '）';
        }
        return $desc;
    }
}

/**
 * ドリル1件の「設定手順」全体（ダミー設定／レコード設定／反撃設定／パラメーター設定）を
 * 実際のトレモ画面のメニュー構成に合わせてHTML化する。空の区分は表示しない。
 */
if (!function_exists('renderDrillSetup')) {
    function renderDrillSetup(array $drill): string {
        $html = '';

        // --- ダミー設定 ---
        if (!empty($drill['dummy_setting'])) {
            $html .= '<div class="setup-screen-tag">🎮 ダミー設定</div><ul class="setup-step-list">';
            foreach ($drill['dummy_setting'] as $s) {
                $html .= '<li>' . h($s['item'] ?? '') . '：<strong>' . h($s['value'] ?? '') . '</strong></li>';
            }
            $html .= '</ul>';
        }

        // --- レコード設定 ---
        $recordsByKey = [];
        if (!empty($drill['records'])) {
            foreach ($drill['records'] as $r) {
                if (!empty($r['key'])) {
                    $recordsByKey[$r['key']] = $r;
                }
            }
            $html .= '<div class="setup-screen-tag">⏺ レコード設定</div><ul class="setup-step-list">';
            foreach ($drill['records'] as $r) {
                $html .= '<li>記録「' . h($r['key'] ?? '') . '」：' . h($r['label'] ?? '') . '</li>';
            }
            $html .= '</ul>';
        }

        // --- 反撃設定（tabごとにグルーピングし、スロット番号を振る） ---
        if (!empty($drill['reversal_setup'])) {
            foreach ($drill['reversal_setup'] as $group) {
                $tab = $group['tab'] ?? '';
                $html .= '<div class="setup-screen-tag">🛡 反撃設定<span class="setup-screen-tab">' . h($tab) . '</span></div><ul class="setup-step-list">';
                $slotNum = 0;
                foreach (($group['slots'] ?? []) as $slot) {
                    $slotNum++;
                    $html .= '<li>スロット' . $slotNum . '：' . renderReversalSlot($slot, $recordsByKey) . '</li>';
                }
                $html .= '</ul>';
            }
        }

        // --- パラメーター設定 ---
        if (!empty($drill['parameter_setting'])) {
            $html .= '<div class="setup-screen-tag">📊 パラメーター設定</div><ul class="setup-step-list">';
            foreach ($drill['parameter_setting'] as $s) {
                $html .= '<li>' . h($s['item'] ?? '') . '：<strong>' . h($s['value'] ?? '') . '</strong></li>';
            }
            $html .= '</ul>';
        }

        return $html;
    }
}

// 5. Head部分の読み込み
include 'includes/head.php';
?>

<?php include 'includes/header.php'; ?>

<div class="main-wrapper">

  <?php
    // このページは章立てされた構成ではなく単一の一覧のため、目次は用意しない
    $page_toc = [];
    include 'includes/toc-sidebar.php';
  ?>

  <main class="content-area">

    <div class="page-header">
      <div class="breadcrumb">ホーム &gt; トレモ練習</div>
      <h1 class="page-title">2. トレモ練習メニュー</h1>
      <p class="page-desc">レベルに応じたトレーニングモードの活用法と、効率的な反復練習メニュー。</p>
    </div>

    <!-- トレモの使い方ガイド（固定表示・検索/フィルタ対象外） -->
    <?php if (!empty($guideBlocks)): ?>
      <div class="alert-box" style="margin-bottom:24px; padding:18px 20px;">
        <div class="alert-title" style="margin-bottom:10px;">📘 トレモの使い方・設定ガイド</div>
        <?php foreach ($guideBlocks as $block): ?>
          <?php echo renderContentBlock($block); ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- 検索・フィルターバー（カテゴリ×難易度の2軸） -->
    <div class="filter-bar" style="flex-direction:column; align-items:stretch; gap:10px;">
      <input type="text" id="trainingSearchInput" class="filter-input" placeholder="練習項目を検索...">

      <div>
        <div style="font-size:0.75rem; color:var(--text-secondary); margin-bottom:6px;">目的から探す</div>
        <div class="filter-btn-group" data-filter-group="category">
          <button class="filter-btn active" type="button" data-filter="all">すべて</button>
          <?php foreach ($categoryOptions as $cat): ?>
            <button class="filter-btn" type="button" data-filter="<?php echo h($cat); ?>"><?php echo h($cat); ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <div>
        <div style="font-size:0.75rem; color:var(--text-secondary); margin-bottom:6px;">難易度から探す</div>
        <div class="filter-btn-group" data-filter-group="difficulty">
          <button class="filter-btn active" type="button" data-filter="all">すべて</button>
          <?php foreach ($difficultyOptions as $diff): ?>
            <button class="filter-btn" type="button" data-filter="<?php echo h($diff); ?>"><?php echo h($diff); ?></button>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- ドリルカード（JSON連携） -->
    <?php if ($trainingLoadError !== null): ?>
      <div class="alert-box warning">
        <div class="alert-title">⚠️ 練習メニューの読み込みエラー</div>
        <div class="alert-content"><?php echo h($trainingLoadError); ?></div>
      </div>
    <?php elseif (empty($drills)): ?>
      <div class="alert-box">
        <div class="alert-title">💡 Notice</div>
        <div class="alert-content">現在、登録されている練習メニューがありません。</div>
      </div>
    <?php else: ?>
      <div class="card-grid" id="trainingCardGrid" style="margin-top:18px;">
        <?php foreach ($drills as $item): ?>
          <?php
            $name          = $item['name'] ?? '(名称未設定)';
            $purpose       = $item['purpose'] ?? '';
            $category      = $item['category'] ?? '';
            $difficulty    = $item['difficulty'] ?? '';
            $recommendedOp = $item['recommended_opponent'] ?? '';
            $relatedSys    = $item['related_systems'] ?? [];
            $successCrit   = $item['success_criteria'] ?? '';
            $tips          = $item['tips'] ?? '';
            $setupHtml     = renderDrillSetup($item);
          ?>
          <div class="grid-card" id="<?php echo h($item['id'] ?? ''); ?>" data-category="<?php echo h($category); ?>" data-difficulty="<?php echo h($difficulty); ?>">
            <div class="grid-card-title">
              <span>🎯</span> <?php echo h($name); ?>
            </div>

            <div style="display:flex; flex-wrap:wrap; gap:4px; margin-bottom:8px;">
              <?php if ($category !== ''): ?>
                <span class="combo-badge" style="font-size:0.7rem;"><?php echo h($category); ?></span>
              <?php endif; ?>
              <?php if ($difficulty !== ''): ?>
                <span class="combo-badge" style="font-size:0.7rem;">難易度：<?php echo h($difficulty); ?></span>
              <?php endif; ?>
              <?php if ($recommendedOp !== '' && $recommendedOp !== '任意'): ?>
                <span class="combo-badge" style="font-size:0.7rem;">推奨対戦相手：<?php echo h($recommendedOp); ?></span>
              <?php endif; ?>
            </div>

            <?php if ($purpose !== ''): ?>
              <div class="grid-card-desc"><?php echo nl2br(h($purpose)); ?></div>
            <?php endif; ?>

            <?php if ($setupHtml !== ''): ?>
              <div class="combo-note setup-note" style="margin-top:10px;">
                <?php echo $setupHtml; ?>
              </div>
            <?php endif; ?>

            <?php if ($successCrit !== ''): ?>
              <div class="combo-note" style="margin-top:10px;">
                <strong class="training-block-heading">■習得の目安</strong><br>
                <?php echo nl2br(h($successCrit)); ?>
              </div>
            <?php endif; ?>

            <?php if ($tips !== ''): ?>
              <div class="combo-note" style="margin-top:10px;">
                <strong class="training-block-heading">■ワンポイント</strong><br>
                <?php echo nl2br(h($tips)); ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($relatedSys)): ?>
              <div class="related-terms-box">
                <span class="related-label">関連用語:</span>
                <?php foreach ($relatedSys as $relId): ?>
                  <?php if (isset($glossaryTermsById[$relId])): ?>
                    <a href="glossary.php#<?php echo h($relId); ?>"><?php echo h($glossaryTermsById[$relId]['term'] ?? $relId); ?></a>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- ポイント解説 -->
    <div class="alert-box" style="margin-top:20px;">
      <div class="alert-title">💡 効率的な練習のコツ</div>
      <div class="alert-content">
        長時間の練習よりも、毎日15分〜30分の「トレモルーティン」を継続する方が定着率が高まります。
      </div>
    </div>

  </main>
</div>

<!-- 検索・カテゴリ／難易度フィルターの簡易JS（2軸のANDフィルタ＋キーワード検索） -->
<script>
  (function () {
    var searchInput = document.getElementById('trainingSearchInput');
    var cards        = document.querySelectorAll('#trainingCardGrid .grid-card');
    var filterGroups = document.querySelectorAll('[data-filter-group]');
    var currentFilters = { category: 'all', difficulty: 'all' };

    function applyFilters() {
      var keyword = (searchInput ? searchInput.value : '').trim().toLowerCase();
      cards.forEach(function (card) {
        var matchesCategory   = currentFilters.category === 'all' || card.dataset.category === currentFilters.category;
        var matchesDifficulty = currentFilters.difficulty === 'all' || card.dataset.difficulty === currentFilters.difficulty;
        var matchesKeyword    = card.textContent.toLowerCase().includes(keyword);
        card.style.display = (matchesCategory && matchesDifficulty && matchesKeyword) ? '' : 'none';
      });
    }

    filterGroups.forEach(function (group) {
      var groupName = group.dataset.filterGroup;
      group.querySelectorAll('.filter-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          group.querySelectorAll('.filter-btn').forEach(function (b) { b.classList.remove('active'); });
          btn.classList.add('active');
          currentFilters[groupName] = btn.dataset.filter;
          applyFilters();
        });
      });
    });

    if (searchInput) {
      searchInput.addEventListener('input', applyFilters);
    }
  })();
</script>

<?php include 'includes/footer.php'; ?>
