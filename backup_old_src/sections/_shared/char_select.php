<?php
/**
 * 共通コンポーネント - キャラクター選択画面
 * 変数 $characters（全キャラ配列）と $currentPage が定義済みであることを前提とする。
 */

// ページに応じたテキスト・クラスの振り分け
if ($currentPage === 'matchup' || $currentPage === 'matchup.php') {
    $title = '🛡️ キャラ対策';
    $desc = '対戦する相手キャラクターを選択してください。<br>確定反撃・切り返し手段・状況別の対策ガイドを確認できます。';
    $linkPrefix = 'matchup?char=';
    $containerClass = 'p-matchup__select-header';
    $titleClass = 'p-matchup__select-title';
    $descClass = 'p-matchup__select-desc';
    $gridClass = 'p-matchup__char-grid';
    $cardClass = 'p-matchup__char-card';
} else {
    // デフォルト（combo 等）
    $title = 'コンボ集';
    $desc = 'サブキャラを試すならまずここから。<br>キャラを選ぶと「とりあえずこれ」コンボとコマンドリストを表示します。';
    $linkPrefix = 'combo?char=';
    $containerClass = 'p-combo__intro';
    $titleClass = 'p-combo__intro-title';
    $descClass = 'p-combo__intro-sub';
    $gridClass = 'p-combo__char-grid';
    $cardClass = 'p-combo__char-card';
}
?>

<div class="<?php echo h($containerClass); ?>">
    <h1 class="<?php echo h($titleClass); ?>"><?php echo h($title); ?></h1>
    <p class="<?php echo h($descClass); ?>"><?php echo $desc; ?></p>
</div>

<?php if (empty($characters)): ?>
    <div class="c-card" style="text-align:center; padding: var(--spacing-3xl); color: var(--text-muted);">
        <p style="font-size: 2rem; margin-bottom: var(--spacing-md);">😞</p>
        <p>キャラクターデータの取得に失敗しました。<br>DBの接続状況を確認してください。</p>
    </div>
<?php else: ?>
    <div class="<?php echo h($gridClass); ?>">
        <?php foreach ($characters as $char): ?>
            <a href="<?php echo $linkPrefix . h($char['char_slug']); ?>"
               class="<?php echo h($cardClass); ?>"
               title="<?php echo h($char['name_jp']); ?> を選択">
               
                <?php if ($currentPage === 'matchup' || $currentPage === 'matchup.php'): ?>
                    <div class="p-matchup__char-icon">
                        <img src="img/character/<?php echo h($char['char_slug']); ?>_ss02.jpg"
                             alt="<?php echo h($char['name_jp']); ?>"
                             class="p-matchup__char-icon-img"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="p-matchup__char-icon-placeholder" style="display:none;">🥊</div>
                    </div>
                    <div class="p-matchup__char-name-jp"><?php echo h($char['name_jp']); ?></div>
                    <div class="p-matchup__char-name-en"><?php echo h($char['name_en']); ?></div>
                <?php else: ?>
                    <img src="img/character/<?php echo h($char['char_slug']); ?>_ss02.jpg"
                         alt="<?php echo h($char['name_jp']); ?>"
                         class="p-combo__char-img"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                    <div class="p-combo__char-img-placeholder" aria-hidden="true" style="display:none">🥊</div>
                    <span class="p-combo__char-name"><?php echo h($char['name_jp']); ?></span>
                    <span class="p-combo__char-type"><?php echo h($char['battle_type']); ?></span>
                <?php endif; ?>
                
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
