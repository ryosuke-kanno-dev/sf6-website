<?php
// データベース接続設定
$host = 'localhost';
$dbname = 'sf6'; // 旧仕様書で指定されていたDB名
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
    // 開発時はエラーを表示し、接続確認を行う
    die('データベース接続エラー: ' . $e->getMessage());
}