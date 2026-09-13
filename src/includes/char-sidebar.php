<?php
// 変数が未定義の場合は空文字をセットする（エラー回避処理）
$current_page = isset($current_page) ? $current_page : '';
$selected_char = isset($selected_char) ? $selected_char : 'ルーク (LUKE)';
$selected_char_icon = isset($selected_char_icon) ? $selected_char_icon : 'L';

// character.php 側で計算済みなら、実際に存在するカテゴリだけをTOCに出す。
// 未定義の場合（他ページから誤って読み込まれた場合等）は空配列にして安全に倒す。
$combosByCategory  = isset($combosByCategory) ? $combosByCategory : [];
$guidesByCategory   = isset($guidesByCategory) ? $guidesByCategory : [];
?>
<aside class="sidebar" id="sidebar">

  <!-- 選択中キャラクター & 全画面選択ボタン -->
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

  <!-- ページ内目次（① コンボ集 / ② キャラ対策・確反 / ③ フレーム表、それぞれの中身も階層表示） -->
  <div class="sidebar-section">
    <div class="sidebar-title">ページ内目次</div>
    <ul class="sidebar-menu">
      <li><a href="#tab-combos" onclick="document.querySelector('.tab-btn[data-tab-target=tab-combos]')?.click();">① コンボ集</a></li>
      <?php if (!empty($combosByCategory)): ?>
        <?php foreach (comboCategoryOrder() as $categoryKey): ?>
          <?php if (empty($combosByCategory[$categoryKey])): continue; endif; ?>
          <li class="sidebar-submenu">
            <a href="#combo-<?php echo h($categoryKey); ?>" onclick="document.querySelector('.tab-btn[data-tab-target=tab-combos]')?.click();">
              ・<?php echo h(comboCategoryLabel($categoryKey)); ?>
            </a>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>

      <li><a href="#tab-matchup" onclick="document.querySelector('.tab-btn[data-tab-target=tab-matchup]')?.click();">② キャラ対策・確反</a></li>
      <?php if (!empty($guidesByCategory)): ?>
        <?php foreach (matchupCategoryOrder() as $categoryKey): ?>
          <?php if (empty($guidesByCategory[$categoryKey])): continue; endif; ?>
          <li class="sidebar-submenu">
            <a href="#matchup-<?php echo h($categoryKey); ?>" onclick="document.querySelector('.tab-btn[data-tab-target=tab-matchup]')?.click();">
              ・<?php echo h(matchupCategoryLabel($categoryKey)); ?>
            </a>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>

      <li><a href="#tab-framedata" onclick="document.querySelector('.tab-btn[data-tab-target=tab-framedata]')?.click();">③ フレーム表</a></li>
    </ul>
  </div>
</aside>
