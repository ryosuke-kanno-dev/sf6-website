<?php
/**
 * 豪鬼特設ページ - コンボ集
 * 変数 $combos, $diffLabel, $diffModMap, $posLabel, $parsedown が
 * akuma.php で定義済みであることを前提とする。
 */
?>
<section id="combo" class="p-akuma__section">
    <div class="l-container">
        <div class="p-akuma__section-header">
            <h2 class="p-akuma__section-title">コンボ集</h2>
            <p class="p-akuma__section-desc">★マークは特に習得優先度が高いおすすめコンボ。まずは初級から覚えていくこと。</p>
        </div>

        <?php if (empty($combos)): ?>
        <div class="c-card" style="text-align:center; padding: var(--spacing-2xl); color: var(--text-muted);">
            コンボデータがまだ登録されていません。
        </div>
        <?php else: ?>
        <div class="p-akuma__combo-wrap">
            <table class="p-akuma__combo-table">
                <thead>
                    <tr>
                        <th style="width:36px;">★</th>
                        <th style="width:5em;">難易度</th>
                        <th>タイトル / レシピ</th>
                        <th style="width:4em;">状況</th>
                        <th style="width:5em;">ダメージ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($combos as $combo):
                        $diff    = $combo['difficulty'] ?? 'Beginner';
                        $diffMod = $diffModMap[$diff] ?? 'beginner';
                        $diffTxt = $diffLabel[$diff] ?? $diff;
                        $pos     = $posLabel[$combo['position'] ?? 'Any'] ?? '全';
                    ?>
                    <tr class="<?php echo $combo['is_recommended'] ? 'is-recommended' : ''; ?>">
                        <td style="text-align:center;">
                            <?php if ($combo['is_recommended']): ?>
                                <span class="p-akuma__combo-star" title="おすすめ">★</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="p-akuma__diff-badge p-akuma__diff-badge--<?php echo h($diffMod); ?>">
                                <?php echo h($diffTxt); ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($combo['title'])): ?>
                                <div style="font-weight:700; color: var(--text-secondary); margin-bottom: var(--spacing-xs);">
                                    <?php echo h($combo['title']); ?>
                                </div>
                            <?php endif; ?>
                            <div><?php echo convertCommandToIcons($combo['recipe'] ?? ''); ?></div>
                            <?php if (!empty($combo['memo'])): ?>
                                <div style="font-size:11px; color:var(--text-muted); margin-top: var(--spacing-xs); line-height: var(--line-height-loose);">
                                    <?php
                                    $memo = str_replace('\\n', "\n", $combo['memo']);
                                    echo $parsedown->text($memo);
                                    ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="p-akuma__pos-badge"><?php echo h($pos); ?></span>
                        </td>
                        <td>
                            <span class="p-akuma__combo-damage">
                                <?php echo $combo['damage'] ? number_format((int)$combo['damage']) : '—'; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

    </div>
</section>
