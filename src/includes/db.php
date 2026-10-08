<?php
// 環境判定（開発/本番でエラー表示を切り替える）。他ファイルで読込済みでも二重実行されない
require_once __DIR__ . '/env.php';

// データベース接続設定
$host = 'localhost';
$dbname = 'sf6';
$username = 'root';
$password = '';  // XAMPP等の初期パスワード（設定に合わせて変更してください）
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    // 詳細（ホスト名・ユーザー名などを含みうる）は本番では画面に出さず、ログにだけ残す
    error_log('DB connection failed: ' . $e->getMessage());
    if (APP_ENV === 'development') {
        die('データベース接続エラー: ' . $e->getMessage());
    }
    http_response_code(503);
    die('ただいまサイトに接続できません。時間をおいて再度お試しください。');
}