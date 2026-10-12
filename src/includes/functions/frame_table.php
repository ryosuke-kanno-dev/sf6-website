<?php
/**
 * フレームデータ表の共通部品（character.php の「フレーム表」タブ / akuma.php の「データ」タブ で共用）
 *
 * - DBにある全項目（コマンド・発生・持続・硬直・ヒット/ガード硬直差・キャンセル・ダメージ・コンボ補正・属性・備考・
 *   ドライブゲージ増減・SAゲージ増加）を出力しておき、チェックボックスで「必要な項目だけ」を表示できる。
 * - 技種別ごとに見出し行で区切り、技種別の絞り込み・キーワード検索ができる。
 * - 表示項目の選択は、ブラウザに保存して次回以降も引き継ぐ（js/frame-table.js）。
 * 列の見せ方は公式サイトのフレームデータ表を参考にしているが、データは自サイトのDBのものを使う。
 */
if (!function_exists('frameTableColumns')) {
    /**
     * key => ['label' => 見出し, 'sub' => 見出しの補足（2行目）, 'group' => チェックボックスのグループ名,
     *         'default' => 初期表示, 'field' => frame テーブルのカラム名]
     */
    function frameTableColumns(): array {
        return [
            'command'            => ['label' => 'コマンド',     'sub' => '',         'group' => '基本',   'default' => true,  'field' => 'command'],
            'startup'            => ['label' => '発生',         'sub' => 'F',        'group' => '基本',   'default' => true,  'field' => 'startup'],
            'active'             => ['label' => '持続',         'sub' => '',         'group' => '基本',   'default' => true,  'field' => 'active'],
            'recovery'           => ['label' => '硬直',         'sub' => '',         'group' => '基本',   'default' => true,  'field' => 'recovery'],
            'hit_adv'            => ['label' => 'ヒット',       'sub' => '硬直差',   'group' => '基本',   'default' => true,  'field' => 'hit_adv'],
            'guard_adv'          => ['label' => 'ガード',       'sub' => '硬直差',   'group' => '基本',   'default' => true,  'field' => 'guard_adv'],
            'damage'             => ['label' => 'ダメージ',     'sub' => '',         'group' => '詳細',   'default' => true,  'field' => 'damage'],
            'hit_level'          => ['label' => '属性',         'sub' => '',         'group' => '詳細',   'default' => true,  'field' => 'hit_level'],
            'cancel'             => ['label' => 'キャンセル',   'sub' => '',         'group' => '詳細',   'default' => false, 'field' => 'cancel'],
            'combo_scaling'      => ['label' => 'コンボ補正',   'sub' => '',         'group' => '詳細',   'default' => false, 'field' => 'combo_scaling'],
            'misc'               => ['label' => '備考',         'sub' => '',         'group' => '詳細',   'default' => false, 'field' => 'miscellaneous'],
            'dg_increase_hit'    => ['label' => 'Dゲージ増加',  'sub' => 'ヒット',   'group' => 'ゲージ', 'default' => false, 'field' => 'dg_increase_hit'],
            'dg_decrease_block'  => ['label' => 'Dゲージ減少',  'sub' => 'ガード',   'group' => 'ゲージ', 'default' => false, 'field' => 'dg_decrease_block'],
            'dg_decrease_punish' => ['label' => 'Dゲージ減少',  'sub' => 'パニカン', 'group' => 'ゲージ', 'default' => false, 'field' => 'dg_decrease_punish'],
            'sa_gauge_increase'  => ['label' => 'SAゲージ増加', 'sub' => '',         'group' => 'ゲージ', 'default' => false, 'field' => 'sa_gauge_increase'],
        ];
    }
}

if (!function_exists('renderFrameTable')) {
    /**
     * @param array  $frames フレームデータ（frame テーブルの行。sort_order 順を想定）
     * @param string $wrapId 外枠の id（ページ内で一意に。ページ内目次のアンカーにも使える）
     */
    function renderFrameTable(array $frames, string $wrapId): string {
        if (empty($frames)) {
            return '';
        }
        $cols = frameTableColumns();

        // 技種別ごとにまとめる（見出し行を出すため）。表示順は固定し、未知の種別は最後に回す
        $byType = [];
        foreach ($frames as $f) {
            $byType[$f['move_type']][] = $f;
        }
        $typeOrder = ['normal_moves', 'unique_attacks', 'special_moves', 'super_arts', 'throws', 'common_moves'];
        $types = array_merge(array_values(array_intersect($typeOrder, array_keys($byType))),
                             array_values(array_diff(array_keys($byType), $typeOrder)));

        $defaultKeys  = array_keys(array_filter($cols, fn($c) => $c['default']));
        $initialSpan  = 1 + count($defaultKeys);
        $groups       = [];
        foreach ($cols as $key => $c) { $groups[$c['group']][$key] = $c; }

        $html  = '<div class="frame-table-wrap" id="' . h($wrapId) . '" data-ft>';

        // ---- ツールバー：検索 / 技種別 / 表示項目 ----
        $html .= '<div class="frame-toolbar">';
        $html .= '<div class="frame-toolbar-row">';
        $html .= '<input type="search" class="frame-search" placeholder="技名・コマンドで検索" aria-label="技名・コマンドで検索">';
        $html .= '<span class="frame-count" aria-live="polite"></span>';
        $html .= '</div>';

        $html .= '<div class="frame-toolbar-row frame-types">';
        $html .= '<span class="frame-toolbar-label">技種別</span>';
        foreach ($types as $type) {
            $html .= '<label class="frame-chip"><input type="checkbox" class="ft-type-toggle" value="' . h($type) . '" checked> '
                   . h(translateMoveType((string)$type)) . '<small>' . count($byType[$type]) . '</small></label>';
        }
        $html .= '</div>';

        $html .= '<details class="frame-cols">';
        $html .= '<summary>表示する項目を選ぶ <span class="ft-cols-count"></span></summary>';
        $html .= '<div class="frame-cols-body">';
        $html .= '<div class="frame-presets"><span class="frame-toolbar-label">プリセット</span>'
               . '<button type="button" class="filter-btn ft-preset" data-preset="basic">基本のみ</button>'
               . '<button type="button" class="filter-btn ft-preset" data-preset="standard">標準</button>'
               . '<button type="button" class="filter-btn ft-preset" data-preset="all">すべて</button></div>';
        foreach ($groups as $groupLabel => $groupCols) {
            $html .= '<div class="frame-col-group"><span class="frame-toolbar-label">' . h($groupLabel) . '</span>';
            foreach ($groupCols as $key => $c) {
                $label = $c['label'] . ($c['sub'] !== '' && $c['sub'] !== 'F' ? '（' . $c['sub'] . '）' : '');
                $html .= '<label class="frame-chip"><input type="checkbox" class="ft-col-toggle" value="' . h($key) . '" data-default="' . ($c['default'] ? '1' : '0')
                       . '"' . ($c['default'] ? ' checked' : '') . '> ' . h($label) . '</label>';
            }
            $html .= '</div>';
        }
        $html .= '</div></details>';
        $html .= '</div>'; // .frame-toolbar

        // ---- 表 ----
        $html .= '<div class="frame-table-scroll"><table class="data-table frame-table"><thead><tr>';
        $html .= '<th class="ft-col-name">技名</th>';
        foreach ($cols as $key => $c) {
            $html .= '<th data-col="' . h($key) . '">' . h($c['label']) . ($c['sub'] !== '' ? '<small>' . h($c['sub']) . '</small>' : '') . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach ($types as $type) {
            $html .= '<tr class="frame-group-row" data-type="' . h($type) . '"><th colspan="' . $initialSpan . '">'
                   . h(translateMoveType((string)$type)) . '<small>' . count($byType[$type]) . '技</small></th></tr>';
            foreach ($byType[$type] as $f) {
                $variantText = moveVariantLabel($f['move_variant'] ?? null);
                $search = mb_strtolower(($f['move_name_jp'] ?? '') . ' ' . ($f['move_name_en'] ?? '') . ' ' . $variantText . ' ' . ($f['command'] ?? ''), 'UTF-8');

                $html .= '<tr class="frame-row" data-type="' . h($type) . '" data-search="' . h($search) . '">';
                $html .= '<td class="ft-col-name">' . h($f['move_name_jp'] ?? '');
                if ($variantText !== '') {
                    $html .= '<span class="ft-variant">（' . h($variantText) . '）</span>';
                }
                $html .= '</td>';

                foreach ($cols as $key => $c) {
                    $val = trim((string)($f[$c['field']] ?? ''));
                    $cls = '';
                    $inner = h($val);
                    if ($key === 'hit_adv' || $key === 'guard_adv') {
                        $cls = ' class="' . frameAdvClass($val) . '"';
                    } elseif ($key === 'command' && $val !== '') {
                        $inner = '<code class="ft-cmd">' . h($val) . '</code>';
                    } elseif ($key === 'hit_level' && $val !== '') {
                        $inner = '<span class="ft-attr">' . h($val) . '</span>';
                    } elseif ($key === 'misc' && $val !== '') {
                        $inner = '<div class="ft-misc">' . nl2br(h($val)) . '</div>';
                    }
                    $html .= '<td data-col="' . h($key) . '"' . $cls . '>' . $inner . '</td>';
                }
                $html .= '</tr>';
            }
        }
        $html .= '</tbody></table></div>';
        $html .= '<p class="frame-note">「D」はダウン、「—」は該当なしを表します。表示項目の選択はこのブラウザに保存されます。</p>';
        $html .= '</div>'; // .frame-table-wrap
        return $html;
    }
}
