<?php
/**
 * 上達ロードマップ ランク帯ナビゲーション
 * サイドバー内に表示するランク選択UI。
 * 変数 $roadmapData（ランク配列）が roadmap.php で定義済みであることを前提とする。
 */
?>
<div class="p-roadmap__rank-nav" role="navigation" aria-label="ランク帯ナビゲーション">
    <?php foreach ($roadmapData as $rank): ?>
        <button
            type="button"
            class="p-roadmap__rank-btn"
            data-rank="<?php echo h($rank['id']); ?>"
            id="rankBtn-<?php echo h($rank['id']); ?>"
            aria-label="<?php echo h($rank['title']); ?>セクションへ移動"
        >
            <span class="p-roadmap__rank-btn-icon"><?php echo $rank['icon']; ?></span>
            <span class="p-roadmap__rank-btn-info">
                <span class="p-roadmap__rank-btn-title"><?php echo h($rank['title']); ?></span>
                <span class="p-roadmap__rank-btn-sub"><?php echo h($rank['subtitle']); ?></span>
            </span>
        </button>
    <?php endforeach; ?>
</div>

<!-- 現在地の補足 -->
<div style="margin-top: var(--spacing-lg); padding: var(--spacing-md); background: var(--bg-card); border-radius: var(--radius-md); border: 1px solid var(--border-color);">
    <p style="font-size: var(--font-size-sm); color: var(--text-muted); margin: 0; line-height: var(--line-height-loose);">
        📍 自分のランク帯をクリックすると、<strong style="color: var(--accent-gold);">そのセクション</strong>に移動します。
    </p>
</div>
