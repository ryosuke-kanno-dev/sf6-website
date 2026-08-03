<?php
/**
 * ホーム - クイックナビゲーションセクション
 */
?>
<section class="section section-dark">
    <div class="l-container">
        <div class="c-section-header">
            <h2 class="c-section-header__title">あなたの目的から始める</h2>
            <p class="c-section-header__subtitle">迷わず、すぐに必要な情報にたどり着けます</p>
        </div>
        
        <div class="quick-nav-grid">
            <?php if (!empty($siteInfo['quickNav'])): ?>
                <?php foreach ($siteInfo['quickNav'] as $nav): ?>
                    <a href="<?php echo h($nav['url'] ?? '#'); ?>" class="c-card c-card--hoverable">
                        <div class="c-card__icon"><?php echo h($nav['icon'] ?? '📚'); ?></div>
                        <h3 class="c-card__title"><?php echo h($nav['title'] ?? ''); ?></h3>
                        <p class="c-card__desc"><?php echo h($nav['description'] ?? ''); ?></p>
                        <?php if (!empty($nav['tags'])): ?>
                            <div class="c-tags">
                                <?php foreach ($nav['tags'] as $tag): ?>
                                    <span class="c-tag"><?php echo h($tag); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- デフォルトのクイックナビゲーション -->
                <a href="guide" class="c-card c-card--hoverable">
                    <div class="c-card__icon">🎮</div>
                    <h3 class="c-card__title">スタートガイド</h3>
                    <p class="c-card__desc">SF6を始める準備はここから。デバイス選び、操作設定、チュートリアルまで完全ガイド</p>
                    <div class="c-tags">
                        <span class="c-tag">初心者向け</span>
                        <span class="c-tag">デバイス</span>
                        <span class="c-tag">設定方法</span>
                    </div>
                </a>
                <a href="training" class="c-card c-card--hoverable">
                    <div class="c-card__icon">🎯</div>
                    <h3 class="c-card__title">トレモ実践</h3>
                    <p class="c-card__desc">具体的なレコード設定で効率よく練習。実践動画付きで分かりやすい</p>
                    <div class="c-tags">
                        <span class="c-tag">練習メニュー</span>
                        <span class="c-tag">動画解説</span>
                        <span class="c-tag">レコード設定</span>
                    </div>
                </a>
                <a href="combo" class="c-card c-card--hoverable">
                    <div class="c-card__icon">📚</div>
                    <h3 class="c-card__title">コンボ集</h3>
                    <p class="c-card__desc">全キャラクターのコンボを網羅。難易度・始動別で簡単検索</p>
                    <div class="c-tags">
                        <span class="c-tag">コンボDB</span>
                        <span class="c-tag">全キャラ対応</span>
                        <span class="c-tag">難易度別</span>
                    </div>
                </a>
                <a href="matchup" class="c-card c-card--hoverable">
                    <div class="c-card__icon">⚔️</div>
                    <h3 class="c-card__title">キャラ対策</h3>
                    <p class="c-card__desc">相手キャラの技データ、立ち回り、連携崩し方法を完全網羅</p>
                    <div class="c-tags">
                        <span class="c-tag">フレーム表</span>
                        <span class="c-tag">対策方法</span>
                        <span class="c-tag">確定反撃</span>
                    </div>
                </a>
                <a href="roadmap" class="c-card c-card--hoverable">
                    <div class="c-card__icon">📈</div>
                    <h3 class="c-card__title">上達法</h3>
                    <p class="c-card__desc">ランク帯別の考え方、行動、練習方法。あなたの次のステップを提示</p>
                    <div class="c-tags">
                        <span class="c-tag">ランク別</span>
                        <span class="c-tag">上達ガイド</span>
                        <span class="c-tag">練習法</span>
                    </div>
                </a>
                <a href="glossary" class="c-card c-card--hoverable">
                    <div class="c-card__icon">📖</div>
                    <h3 class="c-card__title">用語集</h3>
                    <p class="c-card__desc">格ゲー用語、システム用語を50音順で解説。初心者も安心</p>
                    <div class="c-tags">
                        <span class="c-tag">用語解説</span>
                        <span class="c-tag">50音順</span>
                        <span class="c-tag">検索可能</span>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
