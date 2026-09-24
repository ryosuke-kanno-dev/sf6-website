<?php
// training.php からのみ読み込まれる想定。$drills / $categoryOptions / $difficultyOptions が
// 未定義の場合（誤って他ページから読み込まれた場合等）は空配列にして安全に倒す。
$drills            = isset($drills) ? $drills : [];
$categoryOptions   = isset($categoryOptions) ? $categoryOptions : [];
$difficultyOptions = isset($difficultyOptions) ? $difficultyOptions : [];

// カテゴリごとにグルーピング（$categoryOptions の順序に統一。データの出現順には依存しない）
$drillsByCategory = [];
foreach ($categoryOptions as $cat) {
    $drillsByCategory[$cat] = [];
}
foreach ($drills as $d) {
    $cat = $d['category'] ?? '';
    if (!isset($drillsByCategory[$cat])) {
        $drillsByCategory[$cat] = [];
    }
    $drillsByCategory[$cat][] = $d;
}

/**
 * 難易度文字列 → サイドバーのドット色クラス。
 */
if (!function_exists('difficultyDotClass')) {
    function difficultyDotClass(string $difficulty): string {
        $map = ['初級' => 'diff-dot-easy', '中級' => 'diff-dot-mid', '上級' => 'diff-dot-hard'];
        return $map[$difficulty] ?? 'diff-dot-unknown';
    }
}
?>
<aside class="sidebar" id="sidebar">

  <!-- ① 使い方ガイドへのジャンプ -->
  <div class="sidebar-section">
    <div class="sidebar-title">使い方ガイド</div>
    <ul class="sidebar-menu">
      <li><a href="#guide-reference">① 設定項目リファレンス</a></li>
      <li><a href="#guide-level">② レベル別・上達の指針</a></li>
    </ul>
  </div>

  <!-- ② 検索・絞り込み（コンテンツエリア側の検索・フィルターと状態を同期） -->
  <div class="sidebar-section">
    <div class="sidebar-title">練習項目を絞り込む</div>

    <input type="text" id="trainingSearchInputSidebar" class="filter-input sidebar-search-input"
           placeholder="練習項目を検索...">

    <div class="sidebar-filter-label">目的から探す</div>
    <div class="filter-btn-group sidebar-filter-btn-group" data-filter-group="category" data-filter-scope="sidebar">
      <button class="filter-btn active" type="button" data-filter="all">すべて</button>
      <?php foreach ($categoryOptions as $cat): ?>
        <button class="filter-btn" type="button" data-filter="<?php echo h($cat); ?>"><?php echo h($cat); ?></button>
      <?php endforeach; ?>
    </div>

    <div class="sidebar-filter-label">難易度から探す</div>
    <div class="filter-btn-group sidebar-filter-btn-group" data-filter-group="difficulty" data-filter-scope="sidebar">
      <button class="filter-btn active" type="button" data-filter="all">すべて</button>
      <?php foreach ($difficultyOptions as $diff): ?>
        <button class="filter-btn" type="button" data-filter="<?php echo h($diff); ?>"><?php echo h($diff); ?></button>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- ③ カテゴリ→ドリル名の階層メニュー（難易度は色ドットで表示） -->
  <div class="sidebar-section">
    <div class="sidebar-title">練習メニュー一覧</div>
    <ul class="sidebar-menu" id="trainingSidebarIndex">
      <?php foreach ($categoryOptions as $cat): ?>
        <?php if (empty($drillsByCategory[$cat])): continue; endif; ?>
        <li class="sidebar-index-category" data-category="<?php echo h($cat); ?>"><?php echo h($cat); ?></li>
        <?php foreach ($drillsByCategory[$cat] as $d): ?>
          <?php $diff = $d['difficulty'] ?? ''; ?>
          <li class="sidebar-submenu sidebar-index-item" data-category="<?php echo h($cat); ?>" data-difficulty="<?php echo h($diff); ?>">
            <a href="#<?php echo h($d['id'] ?? ''); ?>" title="難易度：<?php echo h($diff); ?>">
              <span class="diff-dot <?php echo difficultyDotClass($diff); ?>"></span><?php echo h($d['name'] ?? ''); ?>
            </a>
          </li>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </ul>
    <div class="sidebar-index-count" id="trainingSidebarCount"><?php echo count($drills); ?>件を表示中</div>
  </div>

</aside>
