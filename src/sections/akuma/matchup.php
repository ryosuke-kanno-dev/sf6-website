<?php
/**
 * 豪鬼特設ページ - キャラ対策サマリー
 * 変数 $matchupData が akuma.php で定義済みであることを前提とする。
 */
?>
<section id="matchup" class="p-akuma__section p-akuma__section--dark">
    <div class="l-container">
        <div class="p-akuma__section-header">
            <h2 class="p-akuma__section-title">キャラ対策サマリー（仮データ）</h2>
            <p class="p-akuma__section-desc">
                各キャラとの相性（有利/五分/不利）の目安。スコアは豪鬼側から見た勝率イメージです。
                詳細はキャラ対策ページを参照してください。
            </p>
        </div>

        <div class="p-akuma__override-banner" style="margin-bottom: var(--spacing-xl);">
            <span class="p-akuma__override-icon">👹</span>
            <p class="p-akuma__override-text">
                <strong>豪鬼ならではの対策</strong>として、阿修羅閃空（4 or 6KKK）での飛び道具回避、
                空中竜巻旋風脚でのめくり切り返しが独自の対策手段になります。
                各キャラの詳細はキャラ対策ページで解説予定です。（連携は開発中）
            </p>
        </div>

        <div class="p-akuma__matchup-grid">
            <?php foreach ($matchupData as $m): ?>
            <div class="p-akuma__matchup-item">
                <img src="img/character/<?php echo h($m['slug']); ?>_ss02.jpg"
                     alt="<?php echo h($m['name_jp']); ?>"
                     class="p-akuma__matchup-img"
                     onerror="this.style.display='none'">
                <span class="p-akuma__matchup-name"><?php echo h($m['name_jp']); ?></span>
                <span class="p-akuma__matchup-score p-akuma__matchup-score--<?php echo h($m['type']); ?>">
                    <?php echo h($m['score']); ?>
                </span>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
