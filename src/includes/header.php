<?php
// 現在のページ判定用の変数（アクティブ表示制御）
$current_page = isset($current_page) ? $current_page : '';
?>
<header class="site-header">
  <div class="header-logo">[ロゴ] SF6 PORTAL</div>
  <nav>
    <ul class="header-nav">
      <li><a href="index.php" class="<?php echo $current_page === 'home' ? 'active' : ''; ?>">0. ホーム</a></li>
      <li><a href="guide.php" class="<?php echo $current_page === 'guide' ? 'active' : ''; ?>">1. 初期設定</a></li>
      <li><a href="training.php" class="<?php echo $current_page === 'training' ? 'active' : ''; ?>">2. トレモ練習</a></li>
      <li><a href="character.php" class="<?php echo $current_page === 'character' ? 'active' : ''; ?>">3. キャラ攻略</a></li>
      <li><a href="roadmap.php" class="<?php echo $current_page === 'roadmap' ? 'active' : ''; ?>">4. ロードマップ</a></li>
      <li><a href="glossary.php" class="<?php echo $current_page === 'glossary' ? 'active' : ''; ?>">5. 用語集</a></li>
    </ul>
  </nav>
  
  <div class="header-utility">
    <button id="theme-toggle-btn" class="theme-toggle-btn" type="button">
      ☀️ Light
    </button>
    <input type="text" placeholder="キーワード検索...">
  </div>

  <button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>
</header>