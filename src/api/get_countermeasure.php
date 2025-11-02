<?php
header('Content-Type: application/json; charset=UTF-8');
require_once '../config/db_connect.php';

// 互換性を持たせて slug か char_slug のどちらでも受け取れるようにする
$charSlug = $_GET['char_slug'] ?? $_GET['slug'] ?? '';

if (!$charSlug) {
    echo json_encode(['error' => 'char_slug is required']);
    exit;
}

// 必要なカラムを取得。並び順は sort_order に従う
$sql = "SELECT slug, char_slug, technique_slug, move_name_jp, move_name_en, command, move_type, startup, active, recovery, hit_adv, guard_adv, cancel, properies, miscellaneous, sort_order
        FROM moves
        WHERE char_slug = ?
        ORDER BY sort_order ASC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$charSlug]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    // エラーはJSONで返す（デバッグ用）
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
