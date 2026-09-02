<?php
// HTMLエスケープ用ヘルパー（他ファイルの h() と衝突しないようガード）
if (!function_exists('h')) {
    function h($str): string {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * JSONデコード結果が「配列(リスト)」ならそのまま返し、
 * {"menus": [...]} のようなラッパーオブジェクトだった場合は中の配列を探して返す。
 */
if (!function_exists('extractJsonList')) {
    function extractJsonList($decoded): array {
        if (!is_array($decoded)) {
            return [];
        }
        if (array_keys($decoded) === range(0, count($decoded) - 1)) {
            return $decoded;
        }
        foreach ($decoded as $value) {
            if (is_array($value) && array_keys($value) === range(0, count($value) - 1)) {
                return $value;
            }
        }
        return [];
    }
}

/**
 * dummy_setting / tips 内の "■見出し" 行を <strong> にし、改行を <br> に変換して出力する。
 * 通常行はそのままエスケープして表示する。
 */
if (!function_exists('renderTrainingMultiline')) {
    function renderTrainingMultiline(string $text): string {
        $lines = explode("\n", $text);
        $html  = [];
        foreach ($lines as $line) {
            $escaped = h($line);
            if (mb_substr($line, 0, 1, 'UTF-8') === '■') {
                $html[] = '<strong class="training-block-heading">' . $escaped . '</strong>';
            } else {
                $html[] = $escaped;
            }
        }
        return implode('<br>', $html);
    }
}

// ページごとの設定値
$page_title   = "2. トレモ練習メニュー | SF6 PORTAL";
$current_page = "training";

// 1. training_menus.json の読み込み
$trainingJsonPath  = __DIR__ . '/data/training_menus.json';
$trainingMenus     = [];
$trainingLoadError = null;

if (!file_exists($trainingJsonPath)) {
    $trainingLoadError = 'ファイルが見つかりません: ' . $trainingJsonPath;
} else {
    $jsonRaw = file_get_contents($trainingJsonPath);
    if ($jsonRaw === false) {
        $trainingLoadError = 'ファイルの読み込みに失敗しました。';
    } else {
        // UTF-8 BOM（メモ帳等での保存時に付与されやすい）が先頭にあれば除去する
        $jsonRaw = preg_replace('/^\xEF\xBB\xBF/', '', $jsonRaw);

        $decoded = json_decode($jsonRaw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $trainingLoadError = 'JSONの形式が不正です: ' . json_last_error_msg();
        } else {
            $trainingMenus = extractJsonList($decoded);
        }
    }
}

// 2. ランク帯フィルターボタンをデータから動的生成（rank -> rank_label の対応表）
$rankOptions = [];
foreach ($trainingMenus as $item) {
    $rank      = $item['rank'] ?? '';
    $rankLabel = $item['rank_label'] ?? $rank;
    if ($rank !== '' && !isset($rankOptions[$rank])) {
        $rankOptions[$rank] = $rankLabel;
    }
}

// 3. Head部分の読み込み
include 'includes/head.php';
?>

<?php include 'includes/header.php'; ?>

<div class="main-wrapper">

  <?php include 'includes/sidebar.php'; ?>

  <main class="content-area">

    <div class="page-header">
      <div class="breadcrumb">ホーム &gt; トレモ練習</div>
      <h1 class="page-title">2. トレモ練習メニュー</h1>
      <p class="page-desc">レベルに応じたトレーニングモードの活用法と、効率的な練習メニュー。</p>
    </div>

    <!-- 検索・フィルターバー -->
    <div class="filter-bar">
      <input type="text" id="trainingSearchInput" class="filter-input" placeholder="練習項目を検索...">
      <?php if (!empty($rankOptions)): ?>
        <div class="filter-btn-group" id="trainingFilterBtns">
          <button class="filter-btn active" type="button" data-filter="all">すべて</button>
          <?php foreach ($rankOptions as $rankSlug => $rankLabel): ?>
            <button class="filter-btn" type="button" data-filter="<?php echo h($rankSlug); ?>"><?php echo h($rankLabel); ?></button>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- 練習項目カード（JSON連携） -->
    <?php if ($trainingLoadError !== null): ?>
      <div class="alert-box warning">
        <div class="alert-title">⚠️ 練習メニューの読み込みエラー</div>
        <div class="alert-content"><?php echo h($trainingLoadError); ?></div>
      </div>
    <?php elseif (empty($trainingMenus)): ?>
      <div class="alert-box">
        <div class="alert-title">💡 Notice</div>
        <div class="alert-content">現在、登録されている練習メニューがありません。</div>
      </div>
    <?php else: ?>
      <div class="card-grid" id="trainingCardGrid">
        <?php foreach ($trainingMenus as $item): ?>
          <?php
            $title         = $item['title'] ?? '(名称未設定)';
            $categoryLabel = $item['category_label'] ?? $item['category'] ?? '';
            $rank          = $item['rank'] ?? '';
            $rankLabel     = $item['rank_label'] ?? $rank;
            $duration      = $item['duration'] ?? null;
            $objective     = $item['objective'] ?? '';
            $dummySetting  = $item['dummy_setting'] ?? '';
            $tips          = $item['tips'] ?? '';
            $tags          = $item['tags'] ?? [];
            $difficulty    = $item['difficulty'] ?? null;

            // related_matchup（例: "matchup?focus=anti-air"）に .php 拡張子を付与
            $relatedUrl = $item['related_matchup'] ?? '';
            if ($relatedUrl !== '' && !preg_match('/\.php(\?|$)/', $relatedUrl)) {
                $relatedUrl = preg_replace('/^([^?]+)/', '$1.php', $relatedUrl, 1);
            }
          ?>
          <div class="grid-card" data-difficulty="<?php echo h($rank); ?>">
            <div class="grid-card-title">
              <span>🎯</span> <?php echo h($title); ?>
            </div>

            <div style="display:flex; flex-wrap:wrap; gap:4px; margin-bottom:8px;">
              <?php if ($categoryLabel !== ''): ?>
                <span class="combo-badge" style="font-size:0.7rem;"><?php echo h($categoryLabel); ?></span>
              <?php endif; ?>
              <?php if ($rankLabel !== ''): ?>
                <span class="combo-badge" style="font-size:0.7rem;"><?php echo h($rankLabel); ?></span>
              <?php endif; ?>
              <?php if ($duration !== null): ?>
                <span class="combo-badge" style="font-size:0.7rem;">⏱ <?php echo (int)$duration; ?>分</span>
              <?php endif; ?>
              <?php if ($difficulty !== null): ?>
                <span class="combo-badge" style="font-size:0.7rem;">難易度：<?php echo str_repeat('★', max(0, (int)$difficulty)); ?></span>
              <?php endif; ?>
            </div>

            <?php if ($objective !== ''): ?>
              <div class="grid-card-desc"><?php echo nl2br(h($objective)); ?></div>
            <?php endif; ?>

            <?php if ($dummySetting !== ''): ?>
              <div class="combo-note" style="margin-top:10px;">
                <?php echo renderTrainingMultiline($dummySetting); ?>
              </div>
            <?php endif; ?>

            <?php if ($tips !== ''): ?>
              <div class="combo-note" style="margin-top:10px;">
                <strong class="training-block-heading">■ワンポイント</strong><br>
                <?php echo renderTrainingMultiline($tips); ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($tags)): ?>
              <div style="margin-top:10px; display:flex; flex-wrap:wrap; gap:4px;">
                <?php foreach ($tags as $tag): ?>
                  <span class="filter-btn" style="cursor:default; padding:2px 10px; font-size:0.75rem;"><?php echo h($tag); ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <?php if ($relatedUrl !== ''): ?>
              <p style="margin-top:10px;">
                <a href="<?php echo h($relatedUrl); ?>" class="next-step-btn" style="display:inline-block; padding:6px 14px; font-size:0.8rem;">
                  → 関連するキャラ対策を見る
                </a>
              </p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- ポイント解説 -->
    <div class="alert-box">
      <div class="alert-title">💡 効率的な練習のコツ</div>
      <div class="alert-content">
        長時間の練習よりも、毎日15分〜30分の「トレモルーティン」を継続する方が定着率が高まります。
      </div>
    </div>

  </main>
</div>

<!-- 検索・ランク帯フィルターの簡易JS -->
<script>
  (function () {
    var searchInput = document.getElementById('trainingSearchInput');
    var filterBtns   = document.querySelectorAll('#trainingFilterBtns .filter-btn');
    var cards        = document.querySelectorAll('#trainingCardGrid .grid-card');
    var currentFilter = 'all';

    function applyFilters() {
      var keyword = (searchInput ? searchInput.value : '').trim().toLowerCase();
      cards.forEach(function (card) {
        var matchesFilter  = currentFilter === 'all' || card.dataset.difficulty === currentFilter;
        var matchesKeyword = card.textContent.toLowerCase().includes(keyword);
        card.style.display = (matchesFilter && matchesKeyword) ? '' : 'none';
      });
    }

    filterBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        filterBtns.forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');
        currentFilter = btn.dataset.filter;
        applyFilters();
      });
    });

    if (searchInput) {
      searchInput.addEventListener('input', applyFilters);
    }
  })();
</script>

<?php include 'includes/footer.php'; ?>