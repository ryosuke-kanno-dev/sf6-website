<?php
// DB接続・ヘルパー関数の読み込み
// footer.php はどのページからも読み込まれるため（character.php 以外は db.php 未読込）、
// require_once でここでも安全に読み込む（character.php では二重読込にならない）。
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions/db_helpers.php';

// 現在選択中のキャラクタースラッグ（character.php 以外のページでは未定義なので安全にフォールバック）
$current_char_slug = isset($char_slug) ? $char_slug : null;

$allCharacters = getAllCharacters($pdo);
?>
<div class="char-modal-overlay" id="charModal" onclick="if (event.target === this) { toggleCharModal(false); }">
  <div class="char-modal-content">
    <div class="modal-header">
      <div>
        <h2 class="modal-title">CHARACTER SELECT</h2>
        <p class="modal-desc">攻略情報を表示したいキャラクターを選択してください（全<?php echo count($allCharacters); ?>キャラ対応）</p>
      </div>
      <button class="modal-close-btn" type="button" onclick="toggleCharModal(false)">✕</button>
    </div>

    <div class="modal-char-grid">
      <?php if (empty($allCharacters)): ?>
        <p style="color:var(--text-secondary); grid-column:1/-1;">キャラクターデータを読み込めませんでした。</p>
      <?php else: ?>
        <?php foreach ($allCharacters as $char): ?>
          <?php
            $slug   = $char['char_slug'] ?? '';
            $nameJp = $char['name_jp'] ?? '(名称未設定)';
            $nameEn = $char['name_en'] ?? '';
            $iconSource = $nameEn !== '' ? $nameEn : $nameJp;
            $icon   = mb_strtoupper(mb_substr($iconSource, 0, 1, 'UTF-8'), 'UTF-8');
            $isActive = ($current_char_slug !== null && $slug !== '' && $slug === $current_char_slug);

            // サムネイル画像（例: img/character/aki_ss02.jpg）。
            // 存在しない場合はイニシャルアイコンに自動フォールバックする。
            $thumbRelPath = 'img/character/' . $slug . '_ss02.jpg';
            $thumbFsPath  = __DIR__ . '/../img/character/' . $slug . '_ss02.jpg';
            $hasThumbnail = ($slug !== '' && file_exists($thumbFsPath));
          ?>
          <a class="modal-char-card<?php echo $isActive ? ' selected' : ''; ?>"
             href="character.php?char=<?php echo urlencode($slug); ?>">
            <?php if ($hasThumbnail): ?>
              <img class="char-thumb-placeholder" src="<?php echo h($thumbRelPath); ?>" alt="<?php echo h($nameJp); ?>">
            <?php else: ?>
              <div class="char-icon-placeholder"><?php echo h($icon); ?></div>
            <?php endif; ?>
            <?php echo h($nameJp); ?>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>