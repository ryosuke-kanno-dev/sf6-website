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