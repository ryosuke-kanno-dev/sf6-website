<?php
/**
 * ホーム - 最新情報セクション
 */
?>
<?php if (!empty($featuredUpdates)): ?>
<section class="section section-dark">
    <div class="l-container">
        <div class="c-section-header">
            <h2 class="c-section-header__title">最新情報</h2>
            <p class="c-section-header__subtitle">新着コンテンツとアップデート</p>
        </div>
        
        <div class="updates-grid">
            <?php foreach ($featuredUpdates as $update): ?>
                <a href="<?php echo h($update['url'] ?? '#'); ?>" class="update-card">
                    <div class="update-header">
                        <span class="update-date"><?php echo h($update['date'] ?? ''); ?></span>
                        <span class="update-category"><?php echo h($update['category'] ?? ''); ?></span>
                    </div>
                    <div class="update-content">
                        <h3 class="update-title"><?php echo h($update['title'] ?? ''); ?></h3>
                        <p class="update-excerpt"><?php echo h($update['excerpt'] ?? ''); ?></p>
                        <span class="update-link">続きを読む →</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
