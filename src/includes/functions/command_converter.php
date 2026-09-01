<?php
/**
 * コマンド表記アイコン変換ユーティリティ v4.1
 *
 * 方式: 単一パス正規表現（プレースホルダー不要）
 *   全トークンを一つの正規表現で順次マッチし、HTML に変換する。
 *
 * 変更点 v4.1:
 *   - j.  → テキストバッジ「ジャンプ中に」
 *   - [J] → テキストバッジ「ジャスト」
 *   - [H] → hold.png のみ（HP画像を削除）
 *   - 方向数字＋ボタンの間に「+」スパンを自動挿入
 *   - or  → テキストバッジ「or」として変換
 *
 * @updated 2026-03-25
 */

// ルートからの画像パス（combo.php が new-sf6-page/ 直下にある前提）
if (!defined('CMD_IMG_BASE')) {
    define('CMD_IMG_BASE', 'img/command/');
}

// ======================================================================
// ヘルパー
// ======================================================================

/**
 * コマンド用 <img> タグを生成する
 */
function cmdImg(string $file, string $alt, string $addClass = ''): string {
    $class = 'c-cmd-img' . ($addClass ? ' ' . $addClass : '');
    return '<img src="' . CMD_IMG_BASE . h($file) . '" alt="' . h($alt) . '" class="' . $class . '">';
}

/**
 * コマンド用テキストバッジ <span> を生成する
 */
function cmdBadge(string $text, string $mod = ''): string {
    $class = 'c-cmd-badge' . ($mod ? ' c-cmd-badge--' . $mod : '');
    return '<span class="' . $class . '">' . h($text) . '</span>';
}

// ======================================================================
// 方向アイコン
// ======================================================================

/**
 * 数字列を通常の方向矢印画像に変換する
 * 対応: 1,2,3,4,6,7,8,9（5は使わない）
 */
function convertDirections(string $numStr): string {
    $html = '';
    for ($i = 0; $i < strlen($numStr); $i++) {
        $d = $numStr[$i];
        if (in_array($d, ['1','2','3','4','6','7','8','9'], true)) {
            $html .= cmdImg('arrow' . $d . '.png', $d, 'c-cmd-img--dir');
        }
    }
    return $html;
}

/**
 * 数字列を溜め方向矢印画像に変換する
 * 対応: 2,4,6 のみ。それ以外は通常矢印で代替。
 */
function convertChargeDirections(string $numStr): string {
    static $chargeMap = [
        '2' => 'charge_arrow2.png',
        '4' => 'charge_arrow4.png',
        '6' => 'charge_arrow6.png',
    ];
    $html = '';
    for ($i = 0; $i < strlen($numStr); $i++) {
        $d = $numStr[$i];
        if (isset($chargeMap[$d])) {
            $html .= cmdImg($chargeMap[$d], '溜め' . $d, 'c-cmd-img--charge');
        } else {
            $html .= convertDirections($d);
        }
    }
    return $html;
}

// ======================================================================
// ボタンアイコン
// ======================================================================

/**
 * ボタン文字列を画像アイコンに変換する
 * SA1/SA2/SA3 は削除（空文字列を返す）
 */
function convertButtons(string $btnStr): string {
    static $btnMap = [
        'LPLK' => ['lp.png', 'lk.png'],
        'HPHK' => ['hp.png', 'hk.png'],
        'MPMK' => ['mp.png', 'hk.png'],
        'PP'   => ['p.png',  'p.png'],
        'KK'   => ['k.png',  'k.png'],
        'LP'   => ['lp.png'],
        'MP'   => ['mp.png'],
        'HP'   => ['hp.png'],
        'LK'   => ['lk.png'],
        'MK'   => ['hk.png'],
        'HK'   => ['hk.png'],
        'P'    => ['p.png'],
        'K'    => ['k.png'],
        'SA1'  => [],
        'SA2'  => [],
        'SA3'  => [],
    ];

    if (isset($btnMap[$btnStr])) {
        $html = '';
        foreach ($btnMap[$btnStr] as $img) {
            $html .= cmdImg($img, $btnStr, 'c-cmd-img--btn');
        }
        return $html;
    }

    return cmdBadge($btnStr, 'unknown');
}

/**
 * 方向数字＋ボタンをまとめて変換し、間に「+」を自動挿入する
 */
function convertDirAndButton(string $numStr, string $btnStr): string {
    $html = convertDirections($numStr);
    if ($btnStr !== '') {
        $html .= cmdImg('plus.png', '+', 'c-cmd-img--sym');
        $html .= convertButtons($btnStr);
    }
    return $html;
}

// ======================================================================
// 特殊トークン変換
// ======================================================================

/**
 * トークン文字列を HTML に変換する（内部ヘルパー）
 */
function convertToken(string $token): string {
    switch ($token) {
        // ── 特殊アイコン（[タグ] 形式） ──────────────────────────────
        case '[J/H]':
            // ジャスト or ホールド
            return cmdBadge('ジャスト', 'jump')
                 . '/'
                 . cmdImg('hold.png', 'HOLD', 'c-cmd-img--mod');

        case '[AUTO]':
            return cmdBadge('自動派生（入力不要）', 'auto');

        case '[360360]':
            return cmdImg('360360.png', '二回転', 'c-cmd-img--special');

        case '[360]':
            return cmdImg('360.png', '一回転', 'c-cmd-img--special');

        case '[OD]':
            return cmdBadge('OD', 'od');

        case '[NR]':
            return cmdBadge('生ラッシュ', 'nr');

        case '[CR]':
            return cmdBadge('キャンセルドライブラッシュ', 'cr');

        case '[IM]':
            // ドライブインパクト = HP+HK
            return cmdImg('hp.png', 'HP', 'c-cmd-img--btn')
                 . cmdImg('hk.png', 'HK', 'c-cmd-img--btn');

        case '[W]':
            return cmdBadge('歩き', 'walk');

        case '[BJ]':
            return cmdBadge('バックジャンプ', 'bj');

        case '[BS]':
            return cmdBadge('バックステップ', 'bs');

        case '[D]':
            return cmdBadge('ディレイ', 'delay');

        case '[J]':
            // ジャスト入力
            return cmdBadge('ジャスト', 'jump');

        case '[H]':
            // ホールド入力（hold.pngのみ）
            return cmdImg('hold.png', 'HOLD', 'c-cmd-img--mod');

        // ── 区切り記号 ────────────────────────────────────────────────
        case ' -> ':
            return '<span class="c-cmd-sep" title="次の技へ">→</span>';

        case ' > ':
            return '<span class="c-cmd-sep c-cmd-sep--derive" title="派生入力">⇒</span>';

        case '~':
            return cmdImg('next.png', '~', 'c-cmd-img--sym');

        case '+':
            return cmdImg('plus.png', '+', 'c-cmd-img--sym');

        case 'j.':
            // ジャンプ中に
            return cmdBadge('ジャンプ中に', 'jump');

        case 'or':
            return cmdImg('or.png', 'or', 'c-cmd-img--sym');

        case 'N':
            // ニュートラル
            return cmdImg('neutral.png', 'N', 'c-cmd-img--dir');

        // ── SA技は削除 ─────────────────────────────────────────────
        case 'SA1': case 'SA2': case 'SA3':
            return '';

        // ── ボタン ────────────────────────────────────────────────────
        case 'LPLK': case 'HPHK': case 'MPMK':
        case 'PP':   case 'KK':
        case 'LP':   case 'MP':   case 'HP':
        case 'LK':   case 'MK':   case 'HK':
        case 'P':    case 'K':
            return convertButtons($token);

        default:
            // 溜め方向 [数字列]
            if (preg_match('/^\[([1-9]+)\]$/', $token, $m)) {
                return convertChargeDirections($m[1]);
            }
            // 繰り返し (xN-M)
            if (preg_match('/^\(x(\d+)-(\d+)\)$/', $token, $m)) {
                return '<span class="c-cmd-repeat">×' . $m[1] . '〜' . $m[2] . '</span>';
            }
            // 方向数字（ボタンなし）
            if (preg_match('/^[1-9]+$/', $token)) {
                return convertDirections($token);
            }
            return cmdBadge($token, 'unknown');
    }
}

// ======================================================================
// メイン関数
// ======================================================================

/**
 * コマンド文字列を HTML アイコンに変換する
 *
 * 単一パス正規表現方式 + 方向＋ボタン間に「+」自動挿入
 */
function convertCommandToIcons(string $command): string {
    if (empty(trim($command))) return '';

    $btnP = 'LPLK|HPHK|MPMK|LP|MP|HP|LK|MK|HK|PP|KK|SA[123]|P(?![PH])|K(?!K)';

    // トークンパターン（長い順に並べることで最長マッチを優先する）
    $pattern = implode('|', [
        '\[J\/H\]',            // [J/H]
        '\[360360\]',          // [360360] 二回転
        '\[AUTO\]',            // [AUTO]
        '\[360\]',             // [360] 一回転
        '\[OD\]','\[NR\]','\[CR\]','\[IM\]', // 特殊[]
        '\[W\]','\[BJ\]','\[BS\]','\[D\]',   // 移動系[]
        '\[J\]','\[H\]',                       // 修飾子[]
        '\[[1-9]+\]',          // 溜め方向 [数字]
        ' -> ',                // 技区切り（スペース込み）
        ' > ',                 // 派生区切り（スペース込み）
        '\(x\d+-\d+\)',        // 繰り返し (xN-M)  ← (丸括弧グループより先にマッチさせる)
        '\([^)]+\)',           // 丸括弧グループ（内部は数字を素通し、他の記法は変換）
        '~',                   // 連続入力
        'j\.',                 // ジャンプ修飾子
        'or',                  // or
        'N',                   // N（ニュートラル）
        'LPLK','HPHK','MPMK', // 多ボタン（長い順）
        'LP','MP','HP','LK','MK','HK','PP','KK', // 2文字ボタン
        'SA[123]',             // SA技（削除対象）
        'P(?![PH])',           // 単体P
        'K(?!K)',              // 単体K
        '[1-9]+(?:' . $btnP . ')?', // 方向数字（オプションでボタンあり）
        '\+',                  // +記号（単独 → plus.png）
    ]);

    $html = preg_replace_callback(
        '/' . $pattern . '/',
        static function (array $m) use ($btnP): string {
            $token = $m[0];

            // ── 丸括弧グループ (xN-M) の繰り返し記法 → convertToken に委譲 ──
            if (preg_match('/^\(x\d+-\d+\)$/', $token)) {
                return convertToken($token);
            }

            // ── 丸括弧グループ (...) ─────────────────────────────────────────
            // 内部の数字（1〜9 単体）はテキストのまま表示。
            // ボタン名・方向+ボタン・[数字]溜め表記などその他の記法は通常変換する。
            if (preg_match('/^\(([^)]+)\)$/', $token, $pm)) {
                $inner = $pm[1];

                // () 内専用パターン: bare [1-9]+ を意図的に除外
                $innerPattern = implode('|', [
                    '\[J\/H\]', '\[360360\]', '\[AUTO\]', '\[360\]',
                    '\[OD\]', '\[NR\]', '\[CR\]', '\[IM\]',
                    '\[W\]', '\[BJ\]', '\[BS\]', '\[D\]',
                    '\[J\]', '\[H\]',
                    '\[[1-9]+\]',          // 溜め方向 [数字] は変換
                    ' -> ', ' > ',
                    '~', 'j\.', 'or', 'N',
                    'LPLK', 'HPHK', 'MPMK',
                    'LP', 'MP', 'HP', 'LK', 'MK', 'HK', 'PP', 'KK',
                    'SA[123]',
                    'P(?![PH])', 'K(?!K)',
                    '[1-9]+(?:' . $btnP . ')',  // 方向+ボタン（ボタン必須）のみ変換
                    '\+',
                    // bare [1-9]+ は含めない → 数字単体はテキストのまま
                ]);

                $innerHtml = preg_replace_callback(
                    '/' . $innerPattern . '/',
                    static function (array $im) use ($btnP): string {
                        $tok = $im[0];
                        if (preg_match('/^([1-9]+)(' . $btnP . ')$/', $tok, $pts)) {
                            return convertDirAndButton($pts[1], $pts[2]);
                        }
                        return convertToken($tok);
                    },
                    $inner
                );

                return '<span class="c-cmd-text">(</span>'
                     . $innerHtml
                     . '<span class="c-cmd-text">)</span>';
            }

            // ── 方向数字+ボタン: 方向と最後のボタンを分離して「+」を挿入 ──
            if (preg_match('/^([1-9]+)(' . $btnP . ')$/', $token, $parts)) {
                return convertDirAndButton($parts[1], $parts[2]);
            }

            // ── 方向数字のみ ──
            if (preg_match('/^[1-9]+$/', $token)) {
                return convertDirections($token);
            }

            return convertToken($token);
        },
        $command
    );

    return '<span class="p-combo__recipe-icons">' . $html . '</span>';
}

/**
 * condition 文字列内の {数字} を方向アイコンに変換する
 * movelist テーブルの condition カラム専用
 */
function convertConditionIcons(string $condition): string {
    if (empty(trim($condition))) return '';

    return preg_replace_callback(
        '/\{([1-9]+)\}/',
        static function (array $m): string {
            return convertDirections($m[1]);
        },
        $condition
    );
}