<?php
// 各ページが読み込み前に $page_toc = [['href'=>'#xxx','label'=>'...'], ...] を用意する。
// 用意されていなければ空配列にして安全に倒す（何も表示しない）。
$page_toc = isset($page_toc) ? $page_toc : [];
$toc_title = isset($toc_title) ? $toc_title : 'このページの内容';
?>
<?php if (!empty($page_toc)): ?>
<aside class="sidebar" id="sidebar">
  <div class="sidebar-section">
    <div class="sidebar-title"><?php echo htmlspecialchars($toc_title, ENT_QUOTES, 'UTF-8'); ?></div>
    <ul class="sidebar-menu">
      <?php foreach ($page_toc as $item): ?>
        <li><a href="<?php echo htmlspecialchars($item['href'] ?? '#', ENT_QUOTES, 'UTF-8'); ?>">・<?php echo htmlspecialchars($item['label'] ?? '', ENT_QUOTES, 'UTF-8'); ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</aside>
<?php endif; ?>
