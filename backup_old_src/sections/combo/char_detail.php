<?php
/**
 * コンボ集 - キャラクター詳細
 * 変数 $character, $combos, $moveList, $profileHtml, $parsedown が
 * combo.php で定義済みであることを前提とする。
 */

// ---- move_type ラベル ----
$moveTypeLabels = [
    'special_moves'  => '必殺技',
    'super_arts'     => 'スーパーアーツ',
    'unique_attacks' => '特殊技',
    'throws'         => '通常投げ',
    'common_moves'   => '共通システム',
    'normal_moves'   => '通常技',
];

// 表示順（ユーザー指定）
$typeOrder = ['special_moves', 'super_arts', 'unique_attacks', 'throws', 'common_moves', 'normal_moves'];

// movelistをグループ化（親技→派生技）
$moveGroups  = [];
$parentMoves = [];
$childMoves  = [];
foreach ($moveList as $move) {
    $type = $move['move_type'] ?? 'other';
    if (empty($move['parent_slug'])) {
        $parentMoves[$type][$move['move_slug']] = $move;
    } else {
        $childMoves[$type][$move['parent_slug']][] = $move;
    }
}
foreach ($typeOrder as $type) {
    $moveGroups[$type] = [];
    foreach ($parentMoves[$type] ?? [] as $slug => $parentMove) {
        $moveGroups[$type][] = ['move' => $parentMove, 'children' => $childMoves[$type][$slug] ?? []];
    }
}

// 難易度ラベル
$diffLabel = [
    'Beginner'     => '初級',
    'Intermediate' => '中級',
    'Advanced'     => '上級',
];
$diffBadgeMod = [
    'Beginner'     => 'beginner',
    'Intermediate' => 'intermediate',
    'Advanced'     => 'advanced',
];

// position・hit_type の日本語ラベル
$posLabel   = ['Any' => '全', 'Mid' => '中央', 'Corner' => '端'];
$hitLabel   = ['Normal' => '通常', 'Counter' => 'CH', 'Punish' => 'パニカン'];
$stateLabel = ['None' => '', 'WallSplat' => '壁やられ', 'Stun' => 'スタン'];

// キャラクタースラッグ（画像・動画パス生成用）
$charId   = $character['id'] ?? '';
$charSlug = $character['char_slug'] ?? '';

// 変数を波括弧 {} で囲むと境界がはっきりして安全です
$charSlugForPath = h("{$charId}_{$charSlug}");
?>

<!-- 戻るリンク -->
<a href="combo" class="p-combo__back-link">
    ← キャラクター選択に戻る
</a>

<!-- キャラヘッダー -->
<div class="p-combo__char-header">
    <img src="img/character/<?php echo h($character['char_slug']); ?>_ss02.jpg"
         alt="<?php echo h($character['name_jp']); ?>"
         class="p-combo__char-header-img"
         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
    <div class="p-combo__char-header-placeholder" aria-hidden="true" style="display:none">🥊</div>
    <div class="p-combo__char-header-info">
        <h1 class="p-combo__char-name-jp"><?php echo h($character['name_jp']); ?></h1>
        <p class="p-combo__char-name-en"><?php echo h($character['name_en']); ?></p>
        <div class="p-combo__stat-grid">
            <div class="p-combo__stat-item">
                <span class="p-combo__stat-label">体力</span>
                <span class="p-combo__stat-value"><?php echo number_format((int)($character['vitality'] ?? 10000)); ?></span>
            </div>
            <div class="p-combo__stat-item">
                <span class="p-combo__stat-label">タイプ</span>
                <span class="p-combo__stat-value"><?php echo h($character['battle_type'] ?? '-'); ?></span>
            </div>
            <div class="p-combo__stat-item">
                <span class="p-combo__stat-label">間合い</span>
                <span class="p-combo__stat-value"><?php echo h($character['range_type'] ?? '-'); ?></span>
            </div>
            <div class="p-combo__stat-item">
                <span class="p-combo__stat-label">難易度</span>
                <span class="p-combo__stat-value"><?php echo h($character['difficulty'] ?? '-'); ?></span>
            </div>
        </div>
    </div>
</div>

<!-- プロフィールテキスト -->
<?php if (!empty($profileHtml)): ?>
    <div class="p-combo__profile c-card" style="margin-bottom: var(--spacing-2xl);">
        <?php echo $profileHtml; ?>
    </div>
<?php endif; ?>

<!-- ==================== 格ゲー記法ガイド ==================== -->
<div class="p-combo__section">
    <h2 class="p-combo__section-title">📖 格ゲー記法ガイド</h2>
    <div class="p-combo__notation-grid">

        <!-- テンキー方向 -->
        <div class="c-card">
            <h3 class="p-combo__guide-heading">テンキー表記（方向入力）</h3>
            <p class="p-combo__guide-desc">キャラクターが右向きの場合の方向アイコンです。左向き時は左右が反転します。</p>
            <div class="p-combo__numpad">
                <?php
                $numpadLayout = [7, 8, 9, 4, 5, 6, 1, 2, 3];
                foreach ($numpadLayout as $n):
                    if ($n === 5): ?>
                        <div class="p-combo__numpad-cell p-combo__numpad-cell--neutral">
                            <span class="p-combo__numpad-num">5</span>
                            <span class="p-combo__numpad-label">ニュートラル</span>
                        </div>
                    <?php else: ?>
                        <div class="p-combo__numpad-cell">
                            <img src="img/command/arrow<?php echo $n; ?>.png"
                                 alt="<?php echo $n; ?>"
                                 class="p-combo__numpad-img">
                            <span class="p-combo__numpad-num"><?php echo $n; ?></span>
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>
        </div>

        <!-- 画像の意味早見表 -->
        <div class="c-card">
            <h3 class="p-combo__guide-heading">アイコン早見表</h3>
            <div class="p-combo__icon-guide">

                <div class="p-combo__icon-guide-section">
                    <div class="p-combo__icon-guide-title">攻撃ボタン</div>
                    <?php
                    $btnGuide = [
                        ['lp.png', 'LP', '弱パンチ（Light Punch）'],
                        ['mp.png', 'MP', '中パンチ（Medium Punch）'],
                        ['hp.png', 'HP', '強パンチ（Heavy Punch）'],
                        ['lk.png', 'LK', '弱キック（Light Kick）'],
                        ['hk.png', 'MK', '中キック（Medium Kick）'],
                        ['hk.png', 'HK', '強キック（Heavy Kick）'],
                        ['p.png',  'P',  'パンチ（任意の強度）'],
                        ['k.png',  'K',  'キック（任意の強度）'],
                    ];
                    foreach ($btnGuide as [$img, $label, $desc]): ?>
                        <div class="p-combo__icon-guide-row">
                            <div class="p-combo__icon-guide-icon">
                                <img src="img/command/<?php echo h($img); ?>" alt="<?php echo h($label); ?>" class="c-cmd-img c-cmd-img--btn">
                            </div>
                            <div class="p-combo__icon-guide-label"><?php echo h($label); ?></div>
                            <div class="p-combo__icon-guide-desc"><?php echo h($desc); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="p-combo__icon-guide-section">
                    <div class="p-combo__icon-guide-title">テキストバッジ</div>
                    <?php
                    $badgeGuide = [
                        ['OD',                    'od',    'OD版の技（ドライブゲージ×2消費）'],
                        ['生ラッシュ',              'nr',    '生ドライブラッシュからの始動'],
                        ['キャンセルドライブラッシュ', 'cr',    'キャンセルドライブラッシュ'],
                        ['ジャスト',               'jump',  'ジャスト入力（特定フレームで入力）'],
                        ['ジャンプ中に',             'jump',  'ジャンプ中に入力（j.表記）'],
                        ['歩き',                   'walk',  '微歩きしてから'],
                        ['バックジャンプ',           'bj',    'バックジャンプで距離を取る'],
                        ['バックステップ',           'bs',    'バックステップで距離を取る'],
                        ['ディレイ',               'delay', '少し遅らせて入力'],
                        ['自動派生（入力不要）',     'auto',  '自動で派生するため入力不要'],
                        ['or',                    'or',    '選択肢（どちらでもよい）'],
                    ];
                    foreach ($badgeGuide as [$text, $mod, $desc]): ?>
                        <div class="p-combo__icon-guide-row">
                            <div class="p-combo__icon-guide-icon">
                                <span class="c-cmd-badge c-cmd-badge--<?php echo h($mod); ?>"><?php echo h($text); ?></span>
                            </div>
                            <div class="p-combo__icon-guide-desc"><?php echo h($desc); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="p-combo__icon-guide-section">
                    <div class="p-combo__icon-guide-title">区切り・操作</div>
                    <?php
                    $sepGuide = [
                        ['→', 'c-cmd-sep', '次の技へ（ -> ）'],
                        ['⇒', 'c-cmd-sep c-cmd-sep--derive', '派生入力（ > ）'],
                        ['next.png', 'c-cmd-img c-cmd-img--sym', '連続入力（~）'],
                        ['plus.png', 'c-cmd-img c-cmd-img--sym', '同時押し・方向+ボタン'],
                        ['×N〜M', 'c-cmd-repeat', 'N〜M回繰り返し'],
                    ];
                    foreach ($sepGuide as [$sym, $cls, $desc]): ?>
                        <div class="p-combo__icon-guide-row">
                            <div class="p-combo__icon-guide-icon">
                                <?php if (str_ends_with($sym, '.png')): ?>
                                    <img src="img/command/<?php echo h($sym); ?>" class="<?php echo h($cls); ?>" alt="icon">
                                <?php else: ?>
                                    <span class="<?php echo h($cls); ?>"><?php echo h($sym); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="p-combo__icon-guide-desc"><?php echo h($desc); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ==================== コマンドリスト ==================== -->
<div class="p-combo__section">
    <h2 class="p-combo__section-title">📋 コマンドリスト</h2>

    <?php
    $hasAnyMoves = false;
    foreach ($typeOrder as $type) {
        if (!empty($moveGroups[$type])) { $hasAnyMoves = true; break; }
    }
    ?>

    <?php if (!$hasAnyMoves): ?>
        <div class="c-card" style="text-align:center; padding: var(--spacing-2xl); color: var(--text-muted);">
            コマンドリストは準備中です。
        </div>
    <?php else: ?>
        <?php foreach ($typeOrder as $type):
            if (empty($moveGroups[$type])) continue;
            $typeLabel = $moveTypeLabels[$type] ?? $type;
        ?>
            <div class="p-combo__move-type-group">
                <div class="p-combo__move-type-title"><?php echo h($typeLabel); ?></div>

                <?php foreach ($moveGroups[$type] as $entry):
                    $move     = $entry['move'];
                    $children = $entry['children'];
                    $slug     = h($move['move_slug'] ?? '');
                    $imgPath  = 'img/move/' . $charSlugForPath . '/' . $slug . '.jpg';
                    $vidPath  = 'videos/move/' . $charSlugForPath . '/' . $slug . '.mp4';
                    $uid      = 'move-' . $slug . '-' . uniqid();
                ?>
                    <!-- 親技カード -->
                    <div class="p-combo__move-card" id="<?php echo h($uid); ?>">
                        <!-- 技画像 -->
                        <div class="p-combo__move-img-wrap">
                            <img src="<?php echo h($imgPath); ?>"
                                 alt="<?php echo h($move['name_jp'] ?? ''); ?>"
                                 class="p-combo__move-img"
                                 onerror="this.style.display='none'">
                        </div>

                        <!-- 技情報メイン -->
                        <div class="p-combo__move-body">
                            <div class="p-combo__move-header">
                                <div>
                                    <div class="p-combo__move-name"><?php echo h($move['name_jp'] ?? ''); ?></div>
                                    <?php if (!empty($move['name_en'])): ?>
                                        <div class="p-combo__move-name-sub"><?php echo h($move['name_en']); ?></div>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($move['overview'])): ?>
                                    <button class="p-combo__move-toggle"
                                            aria-expanded="false"
                                            data-target="detail-<?php echo h($uid); ?>">
                                        詳細 ▼
                                    </button>
                                <?php endif; ?>
                            </div>

                            <!-- コマンド -->
                            <div class="p-combo__move-command">
                                <?php echo convertCommandToIcons($move['command'] ?? ''); ?>
                            </div>

                            <!-- 使用条件 -->
                            <?php if (!empty($move['condition'])): ?>
                                <div class="p-combo__move-condition">
                                    <?php echo convertConditionIcons(h($move['condition'])); ?>
                                </div>
                            <?php endif; ?>

                            <!-- アコーディオン：概要 + 動画 -->
                            <?php if (!empty($move['overview'])): ?>
                                <div class="p-combo__move-detail" id="detail-<?php echo h($uid); ?>" hidden>
                                    <p class="p-combo__move-overview"><?php echo h($move['overview']); ?></p>
                                    <video class="p-combo__move-video"
                                           src="<?php echo h($vidPath); ?>"
                                           controls
                                           preload="none"
                                           muted
                                           playsinline
                                           onerror="this.style.display='none'">
                                    </video>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- 派生技カード -->
                    <?php foreach ($children as $child):
                        $cSlug    = h($child['move_slug'] ?? '');
                        $cImgPath = 'img/move/' . $charSlugForPath . '/' . $cSlug . '.jpg';
                        $cVidPath = 'videos/move/' . $charSlugForPath . '/' . $cSlug . '.mp4';
                        $cUid     = 'move-' . $cSlug . '-' . uniqid();
                    ?>
                        <div class="p-combo__move-card p-combo__move-card--child">
                            <div class="p-combo__move-child-marker" aria-hidden="true">┗</div>

                            <div class="p-combo__move-img-wrap">
                                <img src="<?php echo h($cImgPath); ?>"
                                     alt="<?php echo h($child['name_jp'] ?? ''); ?>"
                                     class="p-combo__move-img"
                                     onerror="this.style.display='none'">
                            </div>

                            <div class="p-combo__move-body">
                                <div class="p-combo__move-header">
                                    <div>
                                        <div class="p-combo__move-name"><?php echo h($child['name_jp'] ?? ''); ?></div>
                                        <?php if (!empty($child['name_en'])): ?>
                                            <div class="p-combo__move-name-sub"><?php echo h($child['name_en']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($child['overview'])): ?>
                                        <button class="p-combo__move-toggle"
                                                aria-expanded="false"
                                                data-target="detail-<?php echo h($cUid); ?>">
                                            詳細 ▼
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <div class="p-combo__move-command">
                                    <?php echo convertCommandToIcons($child['command'] ?? ''); ?>
                                </div>

                                <?php if (!empty($child['condition'])): ?>
                                    <div class="p-combo__move-condition">
                                        <?php echo convertConditionIcons(h($child['condition'])); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($child['overview'])): ?>
                                    <div class="p-combo__move-detail" id="detail-<?php echo h($cUid); ?>" hidden>
                                        <p class="p-combo__move-overview"><?php echo h($child['overview']); ?></p>
                                        <video class="p-combo__move-video"
                                               src="<?php echo h($cVidPath); ?>"
                                               controls
                                               preload="none"
                                               muted
                                               playsinline
                                               onerror="this.style.display='none'">
                                        </video>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- ==================== コンボ集（全一覧） ==================== -->
<div class="p-combo__section">
    <h2 class="p-combo__section-title">⚡ コンボ集 <span style="font-size: var(--font-size-sm); font-weight: 400; color: var(--text-muted);">（初心者・サブキャラ向け汎用）</span></h2>

    <?php if (empty($combos)): ?>
        <div class="c-card" style="text-align:center; padding: var(--spacing-2xl); color: var(--text-muted);">
            コンボデータがまだ登録されていません。
        </div>
    <?php else: ?>
        <table class="p-combo__combo-table">
            <thead>
                <tr>
                    <th style="width: 40px;">★</th>
                    <th style="width: 6em;">難易度</th>
                    <th>タイトル / レシピ</th>
                    <th>状況</th>
                    <th>ダメージ</th>
                    <th>Dゲージ</th>
                    <th>SA</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($combos as $combo):
                    $diff    = $combo['difficulty'] ?? 'Beginner';
                    $badgeMod = $diffBadgeMod[$diff] ?? '';
                    $badgeTxt = $diffLabel[$diff] ?? $diff;
                ?>
                    <tr class="<?php echo $combo['is_recommended'] ? 'is-recommended' : ''; ?>">
                        <!-- おすすめフラグ -->
                        <td style="text-align:center;">
                            <?php if ($combo['is_recommended']): ?>
                                <span class="p-combo__recommended-badge" title="おすすめコンボ">★</span>
                            <?php endif; ?>
                        </td>

                        <!-- 難易度バッジ -->
                        <td>
                            <span class="p-combo__difficulty-badge p-combo__difficulty-badge--<?php echo h($badgeMod); ?>">
                                <?php echo h($badgeTxt); ?>
                            </span>
                        </td>

                        <!-- タイトル + レシピ -->
                        <td>
                            <?php if (!empty($combo['title'])): ?>
                                <div style="font-weight: 700; color: var(--text-primary); margin-bottom: var(--spacing-xs);">
                                    <?php echo h($combo['title']); ?>
                                </div>
                            <?php endif; ?>
                            <div><?php echo convertCommandToIcons($combo['recipe'] ?? ''); ?></div>
                            <?php if (!empty($combo['memo'])): ?>
                                <div class="p-combo__memo">
                                    <?php
                                    $memoText = str_replace('\\n', "\n", $combo['memo']);
                                    echo $parsedown->text($memoText);
                                    ?>
                                </div>
                            <?php endif; ?>
                        </td>

                        <!-- 状況 -->
                        <td>
                            <span class="p-combo__position-badge">
                                <?php echo h($posLabel[$combo['position'] ?? 'Any'] ?? ($combo['position'] ?? '')); ?>
                            </span>
                            <?php if (($combo['hit_type'] ?? 'Normal') !== 'Normal'): ?>
                                <br><span class="p-combo__position-badge" style="margin-top: 2px;">
                                    <?php echo h($hitLabel[$combo['hit_type']] ?? $combo['hit_type']); ?>
                                </span>
                            <?php endif; ?>
                            <?php if (!empty($combo['special_state']) && $combo['special_state'] !== 'None'): ?>
                                <br><span class="p-combo__position-badge" style="margin-top: 2px;">
                                    <?php echo h($stateLabel[$combo['special_state']] ?? $combo['special_state']); ?>
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- ダメージ -->
                        <td style="font-weight: 700; color: var(--accent-gold); white-space: nowrap;">
                            <?php echo $combo['damage'] ? number_format((int)$combo['damage']) : '—'; ?>
                        </td>

                        <!-- Dゲージ -->
                        <td style="text-align: center;">
                            <?php
                            $dg = (int)($combo['drive_gauge'] ?? 0);
                            echo $dg > 0 ? h((string)$dg) : '<span style="color:var(--text-muted)">0</span>';
                            ?>
                        </td>

                        <!-- SAゲージ -->
                        <td style="text-align: center;">
                            <?php
                            $sa = (int)($combo['sa_gauge'] ?? 0);
                            echo $sa > 0 ? h((string)$sa) : '<span style="color:var(--text-muted)">0</span>';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- ==================== JS: コマンドリスト アコーディオン ==================== -->
<script>
(function () {
    document.querySelectorAll('.p-combo__move-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var targetId  = btn.getAttribute('data-target');
            var detail    = document.getElementById(targetId);
            var expanded  = btn.getAttribute('aria-expanded') === 'true';

            if (!detail) return;

            if (expanded) {
                detail.hidden = true;
                btn.setAttribute('aria-expanded', 'false');
                btn.textContent = '詳細 ▼';
                // 動画を停止
                var vid = detail.querySelector('video');
                if (vid) { vid.pause(); vid.currentTime = 0; }
            } else {
                detail.hidden = false;
                btn.setAttribute('aria-expanded', 'true');
                btn.textContent = '閉じる ▲';
            }
        });
    });
})();
</script>
