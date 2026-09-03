<?php
/**
 * HTMLエスケープ用ヘルパー
 * command_converter.php 内で使用されているが未定義だったため、ここで定義する。
 * （既に他所で定義されている場合はそちらを優先し、二重定義エラーを防ぐ）
 */
if (!function_exists('h')) {
    function h($str): string {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }
}

// Parsedown（Markdownパーサー）の読み込み
require_once __DIR__ . '/Parsedown.php';

/**
 * DB内のMarkdown/プレーンテキスト（combos.memo, matchup.overview 等）を安全にHTML変換する共通関数。
 * - setSafeMode(true)   : 本文中の生HTMLタグをエスケープする（XSS対策）
 * - setBreaksEnabled(true): 空行を挟まない単一の改行（実改行コード）も <br> に変換する
 * - Parsedownに渡す前に、DBに実改行ではなく文字列としての "\n"（バックスラッシュ+n）が
 *   保存されているケースを実改行に正規化する（CSVインポート等でエスケープシーケンスが
 *   文字としてそのまま登録されてしまうケースへの対処）。
 */
if (!function_exists('renderMarkdown')) {
    function renderMarkdown(?string $text): string {
        if ($text === null || $text === '') {
            return '';
        }

        // 文字列としての "\r\n" / "\n" / "\r"（バックスラッシュ+文字）を実改行に正規化
        $normalized = str_replace(['\\r\\n', '\\n', '\\r'], "\n", $text);

        $parsedown = Parsedown::instance();
        $parsedown->setSafeMode(true);
        $parsedown->setBreaksEnabled(true);
        return $parsedown->text($normalized);
    }
}

// 1. 全キャラクター一覧の取得
function getAllCharacters($pdo) {
    $stmt = $pdo->query("SELECT * FROM characters ORDER BY sort_order ASC");
    return $stmt->fetchAll();
}

// 2. スラッグ指定によるキャラクター単体情報の取得（例: 'luke', 'akuma'）
function getCharacterBySlug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT * FROM characters WHERE char_slug = ?");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

// 3. キャラクターID指定によるコンボ一覧の取得
function getCombosByCharId($pdo, $char_id) {
    $stmt = $pdo->prepare("SELECT * FROM combos WHERE character_id = ? ORDER BY id ASC");
    $stmt->execute([$char_id]);
    return $stmt->fetchAll();
}

// 4. ガード時硬直差がマイナスの技（確定反撃候補）を取得
//    frame.guard_adv は VARCHAR（'-3' 等の数値のほか 'D'（ダウン）や '—'（該当なし）を含む）のため、
//    CAST(... AS SIGNED) で数値変換した上で比較・ソートする。
//    'D' や '—' は数値変換すると 0 になるため、この条件では自然に除外される。
//    ASC ソートにより、マイナスが大きい（＝確定反撃が取りやすい）技から順に並ぶ（例: -12, -8, -3...）。
function getPunishableFramesByCharId($pdo, $char_id) {
    $stmt = $pdo->prepare(
        "SELECT * FROM frame
         WHERE character_id = ?
           AND CAST(guard_adv AS SIGNED) < 0
         ORDER BY CAST(guard_adv AS SIGNED) ASC"
    );
    $stmt->execute([$char_id]);
    return $stmt->fetchAll();
}

// 5. 指定キャラクターの全技フレームデータを取得（通常技・特殊技・必殺技・SA すべて）
//    frame.sort_order は「100きざみ推奨」の表示順カラム（frame テーブル定義書より）のため、これで整列する。
function getFrameDataByCharId($pdo, $char_id) {
    $stmt = $pdo->prepare("SELECT * FROM frame WHERE character_id = ? ORDER BY sort_order ASC");
    $stmt->execute([$char_id]);
    return $stmt->fetchAll();
}

// 6. キャラクターの対策総評（matchup）を取得（character_id につき1行）
function getMatchupByCharId($pdo, $char_id) {
    $stmt = $pdo->prepare("SELECT * FROM matchup WHERE character_id = ?");
    $stmt->execute([$char_id]);
    $result = $stmt->fetch();
    return $result !== false ? $result : null;
}

// 7. キャラクターに対する対策コラム一覧（matchup_guides）を取得
//    opponent_char_id ＝「このガイドが対策として書かれている対象キャラ」のID。
//    sort_order で整列（同カラム内での表示順もこれに従う想定）。
function getMatchupGuidesByCharId($pdo, $char_id) {
    $stmt = $pdo->prepare("SELECT * FROM matchup_guides WHERE opponent_char_id = ? ORDER BY sort_order ASC");
    $stmt->execute([$char_id]);
    return $stmt->fetchAll();
}

// 8. 上記2つ（総評＋コラム一覧）をまとめて取得するオーケストレーター関数
//    ['matchup' => 総評データ（無ければ null）, 'guides' => コラム配列]
function getMatchupGuideByCharId($pdo, $char_id) {
    return [
        'matchup' => getMatchupByCharId($pdo, $char_id),
        'guides'  => getMatchupGuidesByCharId($pdo, $char_id),
    ];
}