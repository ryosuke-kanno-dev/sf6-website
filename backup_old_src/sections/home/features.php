<?php
/**
 * ホーム - 特徴セクション
 */
?>
<section class="section section-darker">
    <div class="l-container">
        <div class="c-section-header">
            <h2 class="c-section-header__title">このサイトの特徴</h2>
            <p class="c-section-header__subtitle">データ駆動で確実に強くなる</p>
        </div>
        
        <div class="p-home-features">
            <?php if (!empty($siteInfo['features'])): ?>
                <?php foreach ($siteInfo['features'] as $feature): ?>
                    <div class="c-card c-card--feature">
                        <div class="c-card__number"><?php echo h($feature['number'] ?? ''); ?></div>
                        <div class="c-card__icon"><?php echo h($feature['icon'] ?? '⭐'); ?></div>
                        <h3 class="c-card__title"><?php echo h($feature['title'] ?? ''); ?></h3>
                        <p class="c-card__desc"><?php echo h($feature['description'] ?? ''); ?></p>
                        <?php if (!empty($feature['points'])): ?>
                            <ul class="c-card__list">
                                <?php foreach ($feature['points'] as $point): ?>
                                    <li><?php echo h($point); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- デフォルトの特徴 -->
                <div class="c-card c-card--feature">
                    <div class="c-card__number">01</div>
                    <div class="c-card__icon">🎯</div>
                    <h3 class="c-card__title">目的別設計</h3>
                    <p class="c-card__desc">「上達したい」「練習したい」「調べたい」という目的から逆算。迷わず必要な情報にたどり着けます。</p>
                    <ul class="c-card__list">
                        <li>直感的なナビゲーション</li>
                        <li>目的別カテゴリ分け</li>
                        <li>検索不要のUI設計</li>
                    </ul>
                </div>
                <div class="c-card c-card--feature">
                    <div class="c-card__number">02</div>
                    <div class="c-card__icon">🔄</div>
                    <h3 class="c-card__title">回遊設計</h3>
                    <p class="c-card__desc">練習→コンボ→対策が自然につながる設計。「次に何をすべきか」が必ず提示されます。</p>
                    <ul class="c-card__list">
                        <li>関連コンテンツ自動表示</li>
                        <li>学習フロー最適化</li>
                        <li>迷わない導線設計</li>
                    </ul>
                </div>
                <div class="c-card c-card--feature">
                    <div class="c-card__number">03</div>
                    <div class="c-card__icon">⚡</div>
                    <h3 class="c-card__title">実践重視</h3>
                    <p class="c-card__desc">全ての情報は「実戦で使える」ことを最優先。トレモで完結せず、勝利に直結する内容だけを厳選。</p>
                    <ul class="c-card__list">
                        <li>実戦データベース</li>
                        <li>プロ選手監修コンテンツ</li>
                        <li>成功条件の明確化</li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
