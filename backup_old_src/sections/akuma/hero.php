<?php
/**
 * 豪鬼特設ページ - ヒーローヘッダー
 * 変数 $character が akuma.php で定義済みであることを前提とする。
 */
?>
<section class="p-akuma__hero">
    <div class="p-akuma__hero-bg-shape"></div>
    <div class="p-akuma__hero-bg-shape"></div>

    <div class="l-container">
        <div class="p-akuma__hero-content">

            <!-- キャラ画像 -->
            <div class="p-akuma__hero-portrait">
                <img src="img/character/gouki_ss02.jpg"
                     alt="豪鬼"
                     class="p-akuma__hero-portrait-img"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                <div class="p-akuma__hero-portrait-placeholder" style="display:none">👹</div>
            </div>

            <!-- キャラ情報 -->
            <div class="p-akuma__hero-info">
                <div class="p-akuma__hero-badge">👹 豪鬼特設ページ / AKUMA SPECIALIST</div>

                <h1 class="p-akuma__hero-name-jp">
                    <?php echo h($character['name_jp'] ?? '豪鬼'); ?>
                </h1>
                <p class="p-akuma__hero-name-en">
                    <?php echo h($character['name_en'] ?? 'AKUMA'); ?> — THE MASTER OF FIST
                </p>

                <!-- ステータス -->
                <div class="p-akuma__hero-stats">
                    <div class="p-akuma__hero-stat">
                        <span class="p-akuma__hero-stat-label">体力</span>
                        <span class="p-akuma__hero-stat-value"><?php echo number_format((int)($character['vitality'] ?? 9000)); ?></span>
                    </div>
                    <div class="p-akuma__hero-stat">
                        <span class="p-akuma__hero-stat-label">バトルタイプ</span>
                        <span class="p-akuma__hero-stat-value"><?php echo h($character['battle_type'] ?? 'スタンダード'); ?></span>
                    </div>
                    <div class="p-akuma__hero-stat">
                        <span class="p-akuma__hero-stat-label">間合い</span>
                        <span class="p-akuma__hero-stat-value"><?php echo h($character['range_type'] ?? 'ミドルレンジ'); ?></span>
                    </div>
                    <div class="p-akuma__hero-stat">
                        <span class="p-akuma__hero-stat-label">難易度</span>
                        <span class="p-akuma__hero-stat-value"><?php echo h($character['difficulty'] ?? 'ノーマル'); ?></span>
                    </div>
                </div>

                <!-- 特徴タグ -->
                <div class="p-akuma__hero-tags">
                    <span class="p-akuma__hero-tag p-akuma__hero-tag--power">超低体力</span>
                    <span class="p-akuma__hero-tag p-akuma__hero-tag--rushdown">固め強力</span>
                    <span class="p-akuma__hero-tag p-akuma__hero-tag--sa3">SA3瞬獄殺</span>
                    <span class="p-akuma__hero-tag p-akuma__hero-tag--sa3">飛び道具持ち</span>
                    <span class="p-akuma__hero-tag p-akuma__hero-tag--rushdown">阿修羅閃空</span>
                </div>
            </div>

        </div>
    </div>
</section>
