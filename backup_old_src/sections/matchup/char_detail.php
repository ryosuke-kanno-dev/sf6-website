<?php
/**
 * キャラ対策 - 個別対策ページ
 *
 * matchup.php で定義済みの変数:
 *   $character, $matchupData, $guides, $punishList, $reversalList, $parsedown
 */

// 硬直差ラベル（色分け）
function punishLabel(string $adv): array {
    $v = (int)$adv;
    if ($v <= -10) return ['大技確定', 'danger'];
    if ($v <= -6)  return ['中攻撃確定', 'warning'];
    return ['小パン確定', 'caution'];
}

// 特性バッジ定義
$traitBadges = [
    'has_reversal'     => ['無敵技あり',        'reversal'],
    'has_projectile'   => ['飛び道具あり',       'projectile'],
    'has_command_grab' => ['コマンド投げあり',    'cmdgrab'],
    'has_install'      => ['強化インストールあり', 'install'],
];

// カテゴリラベル
$categoryLabels = [
    'neutral'        => '立ち回り',
    'pressure'       => '連係・崩し対策',
    'oki'            => '起き攻め対策',
    'char_condition' => '固有能力対策',
    'gap'            => '連係の隙間',
];

// punish guides をslugでインデックス化
$punishGuides = [];
foreach ($guides['punish'] ?? [] as $g) {
    if ($g['move_slug']) {
        $punishGuides[$g['move_slug']][] = $g;
    }
}
// reversal guides をslugでインデックス化
$reversalGuides = [];
foreach ($guides['reversal'] ?? [] as $g) {
    if ($g['move_slug']) {
        $reversalGuides[$g['move_slug']][] = $g;
    }
}
?>

<!-- 戻るリンク -->
<a href="matchup" class="p-matchup__back-link">
    ← キャラクター選択に戻る
</a>

<!-- ========== キャラヘッダー ========== -->
<div class="p-matchup__char-header">
    <div class="p-matchup__char-header-icon">
        <img src="img/character/<?php echo h($character['char_slug']); ?>_ss02.jpg"
             alt="<?php echo h($character['name_jp']); ?>"
             class="p-matchup__char-header-img"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
        <div class="p-matchup__char-header-placeholder" style="display:none">🥊</div>
    </div>
    <div class="p-matchup__char-header-info">
        <h1 class="p-matchup__char-name-jp"><?php echo h($character['name_jp']); ?></h1>
        <p class="p-matchup__char-name-en"><?php echo h($character['name_en']); ?></p>
        <!-- 特性バッジ -->
        <?php if ($matchupData): ?>
            <div class="p-matchup__trait-badges">
                <?php foreach ($traitBadges as $col => [$label, $mod]): ?>
                    <?php if (!empty($matchupData[$col])): ?>
                        <span class="p-matchup__trait-badge p-matchup__trait-badge--<?php echo h($mod); ?>">
                            <?php echo h($label); ?>
                        </span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ========== セクション① クイックサマリー ========== -->
<div class="p-matchup__section">
    <h2 class="p-matchup__section-title">📋 クイックサマリー</h2>

    <?php if (!$matchupData): ?>
        <div class="c-card p-matchup__pending">準備中です。</div>
    <?php else: ?>
        <div class="p-matchup__summary-grid">
            <!-- 難易度 -->
            <div class="c-card p-matchup__difficulty-card">
                <div class="p-matchup__difficulty-label">対策難易度</div>
                <div class="p-matchup__difficulty-stars">
                    <?php
                    $diff = (int)($matchupData['matchup_difficulty'] ?? 3);
                    for ($i = 1; $i <= 5; $i++):
                    ?>
                        <span class="p-matchup__star <?php echo $i <= $diff ? 'p-matchup__star--on' : 'p-matchup__star--off'; ?>">★</span>
                    <?php endfor; ?>
                </div>
                <div class="p-matchup__difficulty-num"><?php echo $diff; ?> / 5</div>
            </div>

            <!-- key_points -->
            <?php if (!empty($matchupData['key_points'])): ?>
                <div class="c-card p-matchup__keypoints">
                    <h3 class="p-matchup__card-heading">⚡ 対戦前の3大ポイント</h3>
                    <div class="p-matchup__markdown">
                        <?php echo parseMarkdown($matchupData['key_points'], $parsedown); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- overview -->
            <?php if (!empty($matchupData['overview'])): ?>
                <div class="c-card p-matchup__overview" style="grid-column: 1 / -1;">
                    <h3 class="p-matchup__card-heading">📖 キャラ傾向</h3>
                    <div class="p-matchup__markdown">
                        <?php echo parseMarkdown($matchupData['overview'], $parsedown); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<!-- ========== セクション② 確定反撃リスト ========== -->
<div class="p-matchup__section">
    <h2 class="p-matchup__section-title">💥 確定反撃リスト</h2>
    <p class="p-matchup__section-desc">ガード時硬直差が −4F 以下の技一覧です。フレームの有利不利を利用して反撃を狙いましょう。</p>

    <?php if (empty($punishList)): ?>
        <div class="c-card p-matchup__pending">フレームデータがありません。</div>
    <?php else: ?>
        <div class="p-matchup__table-wrap">
            <table class="p-matchup__frame-table">
                <thead>
                    <tr>
                        <th>技名</th>
                        <th>コマンド</th>
                        <th>発生</th>
                        <th>ガード差</th>
                        <th>硬直差ラベル</th>
                        <th>ダメージ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($punishList as $row):
                        $cmd = $row['frame_command'] ?: ($row['movelist_command'] ?? '');
                        [$plabel, $pmod] = punishLabel($row['guard_adv'] ?? '0');
                        $slugForGuide = $row['move_slug'] ?? '';
                    ?>
                        <tr>
                            <td>
                                <div class="p-matchup__move-name"><?php echo h($row['move_name_jp'] ?? ''); ?></div>
                                <?php if (!empty($row['move_variant'])): ?>
                                    <div class="p-matchup__move-variant"><?php echo h($row['move_variant']); ?></div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo convertCommandToIcons($cmd); ?></td>
                            <td class="p-matchup__frame-num"><?php echo h($row['startup'] ?? '—'); ?></td>
                            <td class="p-matchup__guard-adv p-matchup__guard-adv--minus">
                                <?php echo h($row['guard_adv'] ?? '—'); ?>
                            </td>
                            <td>
                                <span class="p-matchup__punish-badge p-matchup__punish-badge--<?php echo h($pmod); ?>">
                                    <?php echo h($plabel); ?>
                                </span>
                            </td>
                            <td class="p-matchup__frame-num"><?php echo h($row['damage'] ?? '—'); ?></td>
                        </tr>
                        <?php if (!empty($punishGuides[$slugForGuide])): ?>
                            <tr class="p-matchup__guide-row">
                                <td colspan="6">
                                    <?php foreach ($punishGuides[$slugForGuide] as $g): ?>
                                        <div class="p-matchup__guide-note">
                                            <span class="p-matchup__guide-icon">💡</span>
                                            <?php if (!empty($g['content'])): ?>
                                                <div class="p-matchup__markdown"><?php echo parseMarkdown($g['content'], $parsedown); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- ========== セクション③ 切り返し手段 ========== -->
<div class="p-matchup__section">
    <h2 class="p-matchup__section-title">↩️ 切り返し手段</h2>
    <p class="p-matchup__section-desc">相手の連携を無敵技・アーマー技で切り返す際の情報です。</p>

    <?php if (empty($reversalList)): ?>
        <div class="c-card p-matchup__pending">フレームデータがありません。</div>
    <?php else: ?>
        <div class="p-matchup__reversal-list">
            <?php foreach ($reversalList as $row):
                $slugForGuide = $row['move_slug'] ?? '';
            ?>
                <div class="p-matchup__reversal-card c-card">
                    <div class="p-matchup__reversal-header">
                        <div>
                            <div class="p-matchup__move-name"><?php echo h($row['move_name_jp'] ?? ''); ?></div>
                            <?php if (!empty($row['move_variant'])): ?>
                                <div class="p-matchup__move-variant"><?php echo h($row['move_variant']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="p-matchup__reversal-meta">
                            <?php echo convertCommandToIcons($row['command'] ?? ''); ?>
                            <?php if (!empty($row['startup'])): ?>
                                <span class="p-matchup__frame-badge">発生 <?php echo h($row['startup']); ?>F</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($row['miscellaneous'])): ?>
                        <div class="p-matchup__reversal-misc">
                            <?php echo nl2br(h($row['miscellaneous'])); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($reversalGuides[$slugForGuide])): ?>
                        <div class="p-matchup__reversal-guides">
                            <?php foreach ($reversalGuides[$slugForGuide] as $g): ?>
                                <div class="p-matchup__guide-note">
                                    <span class="p-matchup__guide-icon">🛡️</span>
                                    <div class="p-matchup__guide-title"><?php echo h($g['title']); ?></div>
                                    <?php if (!empty($g['content'])): ?>
                                        <div class="p-matchup__markdown"><?php echo parseMarkdown($g['content'], $parsedown); ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- ========== セクション④ 状況別戦術解説 ========== -->
<div class="p-matchup__section">
    <h2 class="p-matchup__section-title">📚 状況別戦術解説</h2>

    <?php
    $hasTacticsData = false;
    foreach (array_keys($categoryLabels) as $cat) {
        if (!empty($guides[$cat])) { $hasTacticsData = true; break; }
    }
    ?>

    <?php if (!$hasTacticsData): ?>
        <div class="c-card p-matchup__pending">準備中です。</div>
    <?php else: ?>
        <div class="p-matchup__tactics-list">
            <?php foreach ($categoryLabels as $cat => $catLabel):
                if (empty($guides[$cat])) continue;
                $panelId = 'tactics-' . h($cat);
            ?>
                <div class="p-matchup__acc-item">
                    <button class="p-matchup__acc-trigger"
                            aria-expanded="false"
                            aria-controls="<?php echo $panelId; ?>"
                            id="trigger-<?php echo h($cat); ?>">
                        <span class="p-matchup__acc-label"><?php echo h($catLabel); ?></span>
                        <span class="p-matchup__acc-count"><?php echo count($guides[$cat]); ?>件</span>
                        <span class="p-matchup__acc-arrow">▼</span>
                    </button>
                    <div class="p-matchup__acc-panel"
                         id="<?php echo $panelId; ?>"
                         role="region"
                         aria-labelledby="trigger-<?php echo h($cat); ?>"
                         hidden>
                        <?php foreach ($guides[$cat] as $guide): ?>
                            <div class="p-matchup__guide-item">
                                <div class="p-matchup__guide-item-header">
                                    <div class="p-matchup__guide-item-title"><?php echo h($guide['title']); ?></div>
                                    <?php if (!empty($guide['condition_tag'])): ?>
                                        <span class="p-matchup__condition-tag"><?php echo h($guide['condition_tag']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($guide['move_slug'])): ?>
                                    <div class="p-matchup__guide-cmd">
                                        <?php 
                                            // move_slugから実際のコマンド文字列を取得して変換
                                            $cmdString = $moveCommandMap[$guide['move_slug']] ?? $guide['move_slug']; 
                                            echo convertCommandToIcons($cmdString); 
                                        ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($guide['content'])): ?>
                                    <div class="p-matchup__markdown p-matchup__guide-content">
                                        <?php echo parseMarkdown($guide['content'], $parsedown); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
