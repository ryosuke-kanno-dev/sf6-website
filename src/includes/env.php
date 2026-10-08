<?php
/**
 * 実行環境の判定。
 *
 * デフォルトは 'production'（安全側）。何も設定しなければ、常にエラー表示オフ・最小限の
 * エラーログ記録のみになる。ローカル開発中だけ env-local.php を作って 'development' に
 * 切り替える。
 *
 * 【ローカル開発時の使い方】
 * includes/env-local.php というファイルを新規作成し、以下の内容だけを書く：
 *
 *   <?php
 *   return 'development';
 *
 * このファイルは .gitignore で除外すること（admin/ と同様、開発機だけに置く）。
 */

$environment = 'production';

$envLocalFile = __DIR__ . '/env-local.php';
if (file_exists($envLocalFile)) {
    $loaded = require $envLocalFile;
    if ($loaded === 'development' || $loaded === 'production') {
        $environment = $loaded;
    }
}

if (!defined('APP_ENV')) {
    define('APP_ENV', $environment);
}

if (APP_ENV === 'development') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
    ini_set('log_errors', '1');
    // error_log の出力先を指定したい場合はここで ini_set('error_log', __DIR__ . '/../logs/php-error.log'); のように設定する
}
