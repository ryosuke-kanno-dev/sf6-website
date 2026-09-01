<?php
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
function getPunishableFramesByCharId($pdo, $char_id) {
    $stmt = $pdo->prepare("SELECT * FROM frame WHERE character_id = ? AND on_block < 0 ORDER BY on_block ASC");
    $stmt->execute([$char_id]);
    return $stmt->fetchAll();
}