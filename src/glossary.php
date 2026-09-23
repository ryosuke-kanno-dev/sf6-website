<?php
require_once __DIR__ . '/includes/functions/content_blocks.php';

/**
 * glossary.json の category（日本語）を、アンカーリンク用の英語スラッグに変換する。
 * 未知のカテゴリは "category-N" のような連番スラッグにフォールバックする。
 */
if (!function_exists('glossaryCategorySlug')) {
    function glossaryCategorySlug(string $category, int $fallbackIndex): string {
        $map = [
            'システム'     => 'system',
            '基礎'         => 'basic',
            '立ち回り'     => 'neutral',
            'テクニック'   => 'technique',
            '操作方式'     => 'operation',
            '表記・コマンド' => 'notation',
            'ゲームモード' => 'gamemode',
            'スラング・俗語' => 'slang',
        ];
        return $map[$category] ?? ('category-' . $fallbackIndex);
    }
}

/**
 * カテゴリの表示順序（仕様書 glossary_schema.md 4章 の並びに固定）。
 * データの出現順に依存させず、常にこの順序で表示する。
 */
if (!function_exists('glossaryCategoryOrder')) {
    function glossaryCategoryOrder(): array {
        return ['システム', '基礎', '立ち回り', 'テクニック', '操作方式', '表記・コマンド', 'ゲームモード', 'スラング・俗語'];
    }
}

// ページごとの設定値
$page_title   = "5. 格ゲー用語集 | SF6 PORTAL";
$current_page = "glossary";

// 1. glossary.json の読み込み
$glossaryJsonPath  = __DIR__ . '/data/glossary.json';
$glossaryTerms     = [];
$glossaryLoadError = null;

if (!file_exists($glossaryJsonPath)) {
    $glossaryLoadError = 'ファイルが見つかりません: ' . $glossaryJsonPath;
} else {
    $jsonRaw = file_get_contents($glossaryJsonPath);
    if ($jsonRaw === false) {
        $glossaryLoadError = 'ファイルの読み込みに失敗しました。';
    } else {
        // UTF-8 BOM（メモ帳等での保存時に付与されやすい）が先頭にあれば除去する
        $jsonRaw = preg_replace('/^\xEF\xBB\xBF/', '', $jsonRaw);

        $decoded = json_decode($jsonRaw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $glossaryLoadError = 'JSONの形式が不正です: ' . json_last_error_msg();
        } elseif (!is_array($decoded) || !isset($decoded['terms']) || !is_array($decoded['terms'])) {
            $glossaryLoadError = 'JSONの構造が不正です（"terms" 配列が見つかりません）。';
        } else {
            $glossaryTerms = $decoded['terms'];
        }
    }
}

// 2. カテゴリごとにグループ化する。表示順は glossaryCategoryOrder() の並びに固定し、
//    定義に無いカテゴリ値が紛れていた場合は末尾に回す（黙って消さない）。
$termsByCategory = [];
$termsById       = [];
if ($glossaryLoadError === null) {
    foreach (glossaryCategoryOrder() as $catName) {
        $termsByCategory[$catName] = [];
    }
    foreach ($glossaryTerms as $item) {
        $cat = $item['category'] ?? '';
        $termsByCategory[$cat][] = $item;
        if (!empty($item['id'])) {
            $termsById[$item['id']] = $item;
        }
    }
    // 中身が0件のカテゴリは目次・見出しに出さない
    $termsByCategory = array_filter($termsByCategory, fn($list) => !empty($list));
}

// 3. サイドバー用のページ内目次を組み立てる
$page_toc = [];
$tocIndex = 0;
foreach ($termsByCategory as $categoryName => $termsInCategory) {
    $tocIndex++;
    $page_toc[] = [
        'href'  => '#' . glossaryCategorySlug($categoryName, $tocIndex),
        'label' => $categoryName !== '' ? $categoryName : '未分類',
    ];
}

// 4. Head部分の読み込み
include 'includes/head.php';
?>

<?php include 'includes/header.php'; ?>

<div class="main-wrapper">

  <?php include 'includes/toc-sidebar.php'; ?>

  <main class="content-area">

    <div class="page-header">
      <div class="breadcrumb">ホーム &gt; 用語集</div>
      <h1 class="page-title">5. 格ゲー用語・システム辞書</h1>
      <p class="page-desc">ストリートファイター6のシステムや、格ゲー界隈で使われる用語の解説。</p>
    </div>

    <!-- 検索バー -->
    <div class="filter-bar">
      <input type="text" id="glossarySearchInput" class="filter-input" placeholder="用語名で検索 (例: キャンセル, 確反)...">
    </div>

    <!-- アコーディオン形式の用語一覧（JSON連携） -->
    <?php if ($glossaryLoadError !== null): ?>
      <div class="alert-box warning">
        <div class="alert-title">⚠️ 用語データの読み込みエラー</div>
        <div class="alert-content"><?php echo h($glossaryLoadError); ?></div>
      </div>
    <?php elseif (empty($glossaryTerms)): ?>
      <div class="alert-box">
        <div class="alert-title">💡 Notice</div>
        <div class="alert-content">現在、登録されている用語がありません。</div>
      </div>
    <?php else: ?>
      <div id="glossaryList">
        <?php $categoryIndex = 0; ?>
        <?php foreach ($termsByCategory as $categoryName => $termsInCategory): ?>
          <?php $categoryIndex++; ?>
          <h2 class="glossary-block-title" id="<?php echo h(glossaryCategorySlug($categoryName, $categoryIndex)); ?>" style="font-size:1.05rem; margin-top:20px;">
            <?php echo $categoryName !== '' ? h($categoryName) : '未分類'; ?>
          </h2>
          <?php foreach ($termsInCategory as $item): ?>
            <?php
              $termId       = $item['id'] ?? '';
              $term         = $item['term'] ?? '(名称未設定)';
              $reading      = $item['reading'] ?? '';
              $abbreviation = $item['abbreviation'] ?? '';
              $category     = $item['category'] ?? '';
              $description  = $item['description'] ?? '';
              $content      = $item['content'] ?? [];
              $isCore       = ($item['tier'] ?? 'quick') === 'core';
              $relatedTerms = $item['related_terms'] ?? [];
            ?>
            <details class="accordion-item<?php echo $isCore ? ' is-core' : ''; ?>" id="<?php echo h($termId); ?>">
              <summary class="accordion-title">
                ❓ <?php echo h($term); ?>
                <?php if ($reading !== ''): ?>
                  <span style="font-size:0.75rem; font-weight:normal; color:var(--text-secondary);">（<?php echo h($reading); ?>）</span>
                <?php endif; ?>
                <?php if ($abbreviation !== ''): ?>
                  <span class="abbr-tag"><?php echo h($abbreviation); ?></span>
                <?php endif; ?>
                <?php if ($category !== ''): ?>
                  <span class="combo-badge" style="margin-left:8px; font-size:0.7rem;"><?php echo h($category); ?></span>
                <?php endif; ?>
                <?php if ($isCore): ?>
                  <span class="core-term-badge">主要用語</span>
                <?php endif; ?>
              </summary>
              <div class="accordion-content">
                <?php if ($description !== ''): ?>
                  <p class="glossary-desc"><?php echo nl2br(h($description)); ?></p>
                <?php endif; ?>

                <?php foreach ($content as $block): ?>
                  <?php echo renderGlossaryContentBlock($block); ?>
                <?php endforeach; ?>

                <?php if (!empty($relatedTerms)): ?>
                  <div class="related-terms-box">
                    <span class="related-label">関連用語:</span>
                    <?php foreach ($relatedTerms as $relId): ?>
                      <?php if (isset($termsById[$relId])): ?>
                        <a href="#<?php echo h($relId); ?>"><?php echo h($termsById[$relId]['term'] ?? $relId); ?></a>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>
            </details>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </main>
</div>

<!-- 用語検索：クライアントサイドの簡易フィルタ（表示テキスト全体＝用語名・かな・略称・本文・関連用語を対象） -->
<script>
  (function () {
    var input = document.getElementById('glossarySearchInput');
    if (!input) return;
    input.addEventListener('input', function (e) {
      var keyword = e.target.value.trim().toLowerCase();
      document.querySelectorAll('#glossaryList .accordion-item').forEach(function (item) {
        var text = item.textContent.toLowerCase();
        item.style.display = text.includes(keyword) ? '' : 'none';
      });
    });
  })();
</script>

<?php include 'includes/footer.php'; ?>