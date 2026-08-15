<?php
// 変数が未定義の場合は空文字をセットする（エラー回避処理）
$current_page = isset($current_page) ? $current_page : '';
$selected_char = isset($selected_char) ? $selected_char : 'ルーク (LUKE)';
$selected_char_icon = isset($selected_char_icon) ? $selected_char_icon : 'L';
?>
<aside class="sidebar" id="sidebar">
  <!-- ① メニューディレクトリ -->
  <div class="sidebar-section">
    <div class="sidebar-title">メニュー</div>
    <ul class="sidebar-menu">
      <li><a href="guide.php" class="<?php echo $current_page === 'guide' ? 'active' : ''; ?>">1. 初期設定・環境</a></li>
      <li><a href="training.php" class="<?php echo $current_page === 'training' ? 'active' : ''; ?>">2. トレモ練習メニュー</a></li>
      <li><a href="character.php" class="<?php echo $current_page === 'character' ? 'active' : ''; ?>">3. キャラクター攻略</a></li>
      <li><a href="roadmap.php" class="<?php echo $current_page === 'roadmap' ? 'active' : ''; ?>">4. 上達ロードマップ</a></li>
      <li><a href="glossary.php" class="<?php echo $current_page === 'glossary' ? 'active' : ''; ?>">5. 格ゲー用語集</a></li>
    </ul>
  </div>

  <!-- ② 選択中キャラクター & 全画面選択ボタン -->
  <div class="sidebar-section">
    <div class="sidebar-title">選択中のキャラクター</div>
    
    <div class="current-char-card">
      <div>
        <div class="char-selected-label">SELECTED</div>
        <div class="char-selected-name"><?php echo htmlspecialchars($selected_char, ENT_QUOTES, 'UTF-8'); ?></div>
      </div>
      <div class="char-icon-small"><?php echo htmlspecialchars($selected_char_icon, ENT_QUOTES, 'UTF-8'); ?></div>
    </div>

    <button class="char-open-btn" onclick="toggleCharModal(true)">
      全30+キャラから変更する 🔍
    </button>
  </div>

  <!-- ③ ページ内目次 -->
  <div class="sidebar-section">
    <div class="sidebar-title">ページ内目次</div>
    <ul class="sidebar-menu">
      <li><a href="#combo">・基本コンボレシピ</a></li>
      <li><a href="#punish">・パニカン確定ルート</a></li>
      <li><a href="#anti-air">・対空・確定反撃</a></li>
    </ul>
  </div>
</aside>