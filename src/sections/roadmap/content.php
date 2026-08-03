<?php
/**
 * 上達ロードマップ メインコンテンツ
 * ランク別にMarkdown本文・目標・推奨練習メニューをループ出力する。
 * 変数 $roadmapData, $roadmapHtml, $trainingMenusById が roadmap.php で定義済みであることを前提とする。
 */
?>

<div class="p-roadmap__timeline">
    <?php foreach ($roadmapData as $rank): ?>

        <section
            class="p-roadmap__section"
            id="<?php echo h($rank['id']); ?>"
            data-rank="<?php echo h($rank['id']); ?>"
            data-icon="<?php echo $rank['icon']; ?>"
            aria-labelledby="rank-title-<?php echo h($rank['id']); ?>"
        >
            <!-- セクションヘッダー -->
            <div class="p-roadmap__section-header">
                <h2
                    class="p-roadmap__rank-title"
                    id="rank-title-<?php echo h($rank['id']); ?>"
                >
                    <?php echo $rank['icon']; ?> <?php echo h($rank['title']); ?>
                </h2>
                <p class="p-roadmap__rank-subtitle"><?php echo h($rank['subtitle']); ?></p>
            </div>

            <!-- 目標チェックリスト -->
            <?php if (!empty($rank['goals'])): ?>
                <div class="p-roadmap__goals" aria-label="このランクの目標">
                    <?php foreach ($rank['goals'] as $goal): ?>
                        <div class="p-roadmap__goal-item">
                            <span class="p-roadmap__goal-icon">🎯</span>
                            <span><?php echo h($goal); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Markdownレンダリング本文 -->
            <?php if (!empty($roadmapHtml[$rank['id']])): ?>
                <div class="p-roadmap__md-body">
                    <?php echo $roadmapHtml[$rank['id']]; ?>
                </div>
            <?php else: ?>
                <div class="p-roadmap__not-found">
                    <p>コンテンツを読み込めませんでした。</p>
                </div>
            <?php endif; ?>

            <!-- 推奨練習メニュー -->
            <?php if (!empty($rank['recommend_training'])): ?>
                <div class="p-roadmap__training-section">
                    <h3 class="p-roadmap__training-title">
                        💪 推奨練習メニュー
                    </h3>
                    <div class="p-roadmap__training-list">
                        <?php foreach ($rank['recommend_training'] as $trainingId): ?>
                            <?php
                            $menu = $trainingMenusById[$trainingId] ?? null;
                            ?>
                            <?php if ($menu): ?>
                                <a
                                    href="training#<?php echo h($trainingId); ?>"
                                    class="c-card p-roadmap__training-card"
                                    aria-label="練習メニュー「<?php echo h($menu['title']); ?>」を開く"
                                >
                                    <div class="p-roadmap__training-card-title">
                                        <?php echo h($menu['title']); ?>
                                    </div>
                                    <div class="p-roadmap__training-card-meta">
                                        <?php echo h($menu['category_label']); ?> ・ <?php echo h($menu['duration']); ?>分
                                    </div>
                                    <p class="p-roadmap__training-card-obj">
                                        <?php echo h($menu['objective']); ?>
                                    </p>
                                    <span class="p-roadmap__training-card-link">
                                        練習を始める →
                                    </span>
                                </a>
                            <?php else: ?>
                                <!-- JSONに存在しないIDの場合のフォールバック -->
                                <div class="c-card p-roadmap__not-found">
                                    <p>メニューID「<?php echo h($trainingId); ?>」が見つかりません。</p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </section><!-- /.p-roadmap__section -->

    <?php endforeach; ?>
</div><!-- /.p-roadmap__timeline -->
