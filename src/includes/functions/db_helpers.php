<?php
/**
 * DB関連のヘルパー関数群
 * 複数ページで共通して利用するデータベース操作をまとめる
 */

/**
 * 全キャラクターの一覧を取得する
 * 
 * @param PDO $pdo
 * @return array
 */
function getAllCharacters(PDO $pdo): array {
    try {
        $stmt = $pdo->query('SELECT * FROM characters ORDER BY sort_order ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('getAllCharacters error: ' . $e->getMessage());
        return [];
    }
}

/**
 * スラッグ（char_slug）からキャラクター情報を1件取得する
 * 
 * @param PDO $pdo
 * @param string $slug
 * @return array|null
 */
function getCharacterBySlug(PDO $pdo, string $slug): ?array {
    try {
        $stmt = $pdo->prepare('SELECT * FROM characters WHERE char_slug = ? LIMIT 1');
        $stmt->execute([$slug]);
        $char = $stmt->fetch(PDO::FETCH_ASSOC);
        return $char ?: null;
    } catch (PDOException $e) {
        error_log('getCharacterBySlug error: ' . $e->getMessage());
        return null;
    }
}
