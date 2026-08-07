<?php
/**
 * SF6攻略サイト 設定ファイル
 */

// サイト基本情報
define('SITE_NAME', 'SF6攻略ガイド');
define('SITE_DESCRIPTION', '初心者がマスターを目指し、特定のキャラ（豪鬼）を極めるまでの成長を支援する、データ駆動型攻略サイト');
define('SITE_URL', 'http://localhost/SF6_WebSite');
define('SITE_VERSION', '2.0.0');

// パス設定
define('BASE_PATH', __DIR__ . '/../..');
define('DATA_PATH', BASE_PATH . '/src/data');
define('INCLUDES_PATH', BASE_PATH . '/src/includes');

// データファイルパス
define('SITE_INFO_JSON', DATA_PATH . '/site_info.json');
define('CHARACTERS_JSON', DATA_PATH . '/characters.json');
define('UPDATES_JSON', DATA_PATH . '/updates.json');

// デフォルト設定
define('DEFAULT_THEME', 'dark'); // 'light' or 'dark'
define('POSTS_PER_PAGE', 10);

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

/**
 * JSONファイルを読み込む
 * @param string $filepath ファイルパス
 * @return array|null 配列またはnull
 */
function loadJsonFile($filepath) {
    if (!file_exists($filepath)) {
        error_log("JSON file not found: {$filepath}");
        return null;
    }
    
    $content = file_get_contents($filepath);
    $data = json_decode($content, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON decode error: " . json_last_error_msg());
        return null;
    }
    
    return $data;
}

/**
 * HTMLエスケープ
 * @param string $text テキスト
 * @return string エスケープされたテキスト
 */
function h($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// ==================== DB接続（PDO） ====================
define('DB_HOST',    'localhost');
define('DB_NAME',    'sf6');
define('DB_USER',    'root');
define('DB_PASS',    '');
define('DB_CHARSET', 'utf8mb4');

/**
 * PDO接続を取得する（シングルトン）
 * @return PDO
 */
function getPdo(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }
    return $pdo;
}
?>
