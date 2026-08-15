<?php
/**
 * ホーム - ヒーローセクション
 */
?>
<section class="p-home-hero">
    <div class="p-home-hero__shape"></div>
    <div class="p-home-hero__shape"></div>
    <div class="p-home-hero__shape"></div>
    
    <div class="p-home-hero__content">
        <div class="p-home-hero__badge"><?php echo h($siteInfo['hero']['badge'] ?? 'Street Fighter 6'); ?></div>
        <h1 class="p-home-hero__title">
            <?php 
            // タイトルをそのまま出力（.highlightクラスは使用しない）
            echo $siteInfo['hero']['title'] ?? '最速で上達する<br>SF6完全攻略';
            ?>
        </h1>
        <p class="p-home-hero__subtitle"><?php echo nl2br(h($siteInfo['hero']['subtitle'] ?? '初心者から上級者まで、あなたのランクに合わせた最適な練習法を提供')); ?></p>
        <div class="p-home-hero__cta">
            <a href="<?php echo h($siteInfo['hero']['primaryCta']['url'] ?? '#'); ?>" class="c-btn c-btn--primary">
                <span><?php echo h($siteInfo['hero']['primaryCta']['text'] ?? 'ランク診断を始める'); ?></span>
                <span>→</span>
            </a>
            <a href="<?php echo h($siteInfo['hero']['secondaryCta']['url'] ?? '#'); ?>" class="c-btn c-btn--secondary">
                <span><?php echo h($siteInfo['hero']['secondaryCta']['text'] ?? '練習メニューを見る'); ?></span>
                <span>→</span>
            </a>
        </div>
    </div>
</section>
