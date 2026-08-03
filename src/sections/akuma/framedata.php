<?php
/**
 * 豪鬼特設ページ - フレームデータ
 * 変数 $moveGroups, $moveTypeLbl, $moveTypeOrder が akuma.php で定義済みであることを前提とする。
 * convertCommandToIcons(), convertConditionIcons() が command_converter.php で定義済みであることを前提とする。
 */

$hasAny = false;
foreach ($moveTypeOrder as $t) {
    if (!empty($moveGroups[$t])) { $hasAny = true; break; }
}
?>
<section id="framedata" class="p-akuma__section">
    <div class="l-container">
        <div class="p-akuma__section-header">
            <h2 class="p-akuma__section-title">フレームデータ</h2>
            <p class="p-akuma__section-desc">DBから取得した実データ。コマンドリストの必殺技・スーパーアーツを掲載。</p>
        </div>

        <?php if (!$hasAny): ?>
        <div style="text-align:center; padding: var(--spacing-2xl); color: var(--text-muted); border: 1px dashed var(--akuma-border); border-radius: var(--radius-md);">
            技データは準備中です。
        </div>
        <?php else: ?>

        <!-- タブ切り替え -->
        <div class="p-akuma__tabs">
            <?php
            $firstTab = true;
            foreach ($moveTypeOrder as $type):
                if (empty($moveGroups[$type])) continue;
                $lbl = $moveTypeLbl[$type] ?? $type;
            ?>
            <button class="p-akuma__tab-btn <?php echo $firstTab ? 'is-active' : ''; ?>"
                    data-tab="<?php echo h($type); ?>">
                <?php echo h($lbl); ?>
            </button>
            <?php $firstTab = false; endforeach; ?>
        </div>

        <?php
        $firstPanel = true;
        foreach ($moveTypeOrder as $type):
            if (empty($moveGroups[$type])) continue;
        ?>
        <div class="p-akuma__tab-panel <?php echo $firstPanel ? 'is-active' : ''; ?>"
             data-panel="<?php echo h($type); ?>">
            <div class="p-akuma__frame-wrap">
                <table class="p-akuma__frame-table">
                    <thead>
                        <tr>
                            <th>技名</th>
                            <th>コマンド</th>
                            <th>使用条件</th>
                            <th>備考</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($moveGroups[$type] as $move): ?>
                        <tr>
                            <td style="text-align:left; font-weight:700; color:#fff;">
                                <?php echo h($move['name_jp'] ?? ''); ?>
                                <?php if (!empty($move['name_en'])): ?>
                                    <div style="font-size:10px; color:var(--text-muted); font-weight:400;">
                                        <?php echo h($move['name_en']); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td style="text-align:left;">
                                <?php echo convertCommandToIcons($move['command'] ?? ''); ?>
                            </td>
                            <td style="text-align:left; font-size:11px; color:var(--text-muted);">
                                <?php echo !empty($move['condition'])
                                    ? convertConditionIcons(h($move['condition']))
                                    : '—'; ?>
                            </td>
                            <td style="text-align:left; font-size:11px; color:var(--text-muted); line-height:var(--line-height-loose);">
                                <?php echo h($move['overview'] ?? '—'); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php $firstPanel = false; endforeach; ?>

        <?php endif; ?>

    </div>
</section>
