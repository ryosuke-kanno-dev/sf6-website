<?php
// HTMLエスケープ用ヘルパー（他ファイルの h() と衝突しないようガード）
if (!function_exists('h')) {
    function h($str): string {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * glossary.json の content 配列内の1ブロック（type: text / list / table）をHTMLに変換する。
 * 未知の type は空文字を返す（表示崩れを防ぐ）。
 */
if (!function_exists('renderGlossaryContentBlock')) {
    function renderGlossaryContentBlock(array $block): string {
        $type = $block['type'] ?? '';

        switch ($type) {
            case 'text':
                return '<p class="glossary-block-text">' . nl2br(h($block['body'] ?? '')) . '</p>';

            case 'list':
                $html = '';
                if (!empty($block['title'])) {
                    $html .= '<div class="glossary-block-title">' . h($block['title']) . '</div>';
                }
                $html .= '<ul class="glossary-block-list">';
                foreach (($block['items'] ?? []) as $li) {
                    $html .= '<li>' . h($li) . '</li>';
                }
                $html .= '</ul>';
                return $html;

            case 'table':
                $html = '';
                if (!empty($block['title'])) {
                    $html .= '<div class="glossary-block-title">' . h($block['title']) . '</div>';
                }
                $html .= '<div class="table-container"><table class="data-table"><thead><tr>';
                foreach (($block['headers'] ?? []) as $header) {
                    $html .= '<th>' . h($header) . '</th>';
                }
                $html .= '</tr></thead><tbody>';
                foreach (($block['rows'] ?? []) as $row) {
                    $html .= '<tr>';
                    foreach ($row as $cell) {
                        $html .= '<td>' . h($cell) . '</td>';
                    }
                    $html .= '</tr>';
                }
                $html .= '</tbody></table></div>';
                return $html;

            default:
                return '';
        }
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
        } elseif (!is_array($decoded)) {
            $glossaryLoadError = 'JSONのルートが配列ではありません。';
        } else {
            $glossaryTerms = $decoded;
        }
    }
}

// 2. Head部分の読み込み
include 'includes/head.php';
?>

<?php include 'includes/header.php'; ?>

<div class="main-wrapper">

  <?php include 'includes/sidebar.php'; ?>

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
        <?php foreach ($glossaryTerms as $item): ?>
          <?php
            $term        = $item['term'] ?? '(名称未設定)';
            $kana        = $item['kana'] ?? '';
            $category    = $item['category'] ?? '';
            $description = $item['description'] ?? '';
            $content     = $item['content'] ?? [];
          ?>
          <details class="accordion-item" data-term="<?php echo h(mb_strtolower($term . ' ' . $kana, 'UTF-8')); ?>">
            <summary class="accordion-title">
              ❓ <?php echo h($term); ?>
              <?php if ($kana !== ''): ?>
                <span style="font-size:0.75rem; font-weight:normal; color:var(--text-secondary);">（<?php echo h($kana); ?>）</span>
              <?php endif; ?>
              <?php if ($category !== ''): ?>
                <span class="combo-badge" style="margin-left:8px; font-size:0.7rem;"><?php echo h($category); ?></span>
              <?php endif; ?>
            </summary>
            <div class="accordion-content">
              <?php if ($description !== ''): ?>
                <p class="glossary-desc"><?php echo nl2br(h($description)); ?></p>
              <?php endif; ?>

              <?php foreach ($content as $block): ?>
                <?php echo renderGlossaryContentBlock($block); ?>
              <?php endforeach; ?>
            </div>
          </details>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </main>
</div>

<!-- 用語検索：クライアントサイドの簡易フィルタ（用語名・かな・本文を対象） -->
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