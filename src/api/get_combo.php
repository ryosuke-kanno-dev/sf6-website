<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/db_connect.php';

// -------------------------------------------------------------
// パラメータ取得
// -------------------------------------------------------------
$charSlug = $_GET['char_slug'] ?? '';
$mode = $_GET['mode'] ?? 'move'; // 'move' or 'combo'

if (!$charSlug) {
    echo json_encode(['error' => 'char_slug is required']);
    exit;
}

try {
    // ---------------------------------------------------------
    // 【モード1】技データ（move_detailsテーブル）
    // ---------------------------------------------------------
    if ($mode === 'move') {
        $sql = "SELECT * FROM move_details
                WHERE char_slug = :char_slug
                AND move_type IN ('special_moves', 'super_arts')
                ORDER BY sort_order ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':char_slug', $charSlug, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $specialMoves = [];
        $superArts = [];

        foreach ($rows as $r) {
            $move = [
                'jp' => $r['technique_name_jp'],
                'en' => $r['technique_name_en'],
                'img' => $r['technique_img'],
                'command' => $r['command'],
                'supplement' => $r['supplement'],
                'derivative' => $r['derivative'],
                'slug' => $r['technique_slug']
            ];

            if (empty($r['derivative'])) {
                if ($r['move_type'] === 'special_moves') {
                    $specialMoves[$r['technique_slug']] = $move;
                } elseif ($r['move_type'] === 'super_arts') {
                    $superArts[$r['technique_slug']] = $move;
                }
            } else {
                if (isset($specialMoves[$r['derivative']])) {
                    $specialMoves[$r['derivative']]['derivatives'][] = $move;
                } elseif (isset($superArts[$r['derivative']])) {
                    $superArts[$r['derivative']]['derivatives'][] = $move;
                }
            }
        }

        echo json_encode([
            'special_moves' => array_values($specialMoves),
            'super_arts' => array_values($superArts)
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    // ---------------------------------------------------------
    // 【モード2】コンボデータ（combosテーブル）
    // ---------------------------------------------------------
    elseif ($mode === 'combo') {
        $sql = "SELECT * FROM combos
                WHERE char_slug = :char_slug
                ORDER BY sort_order ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':char_slug', $charSlug, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $combos = [];
        foreach ($rows as $r) {
            $combos[] = [
                'slug' => $r['slug'],
                'char_slug' => $r['char_slug'],
                'type' => $r['type'],
                'moves' => $r['moves'],
                'text' => $r['text'],
                'damage' => $r['damage'] ?? '',
                'continuation' => $r['continuation'] ?? '',

            ];
        }

        echo json_encode($combos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    // ---------------------------------------------------------
    // その他モード（未指定）
    // ---------------------------------------------------------
    else {
        echo json_encode(['error' => 'invalid mode']);
        exit;
    }

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
?>
