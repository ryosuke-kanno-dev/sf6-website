<?php
/**
 * フロントコントローラー
 * 
 * すべてのリクエストはここを経由し、適切なページコントローラーを読み込みます。
 */

// 1. 設定ファイルの読み込み
require_once __DIR__ . '/../src/includes/config.php';

// 2. ルーティング処理
// デフォルトページは 'home' (旧 index.php)
$page = isset($_GET['p']) && $_GET['p'] !== '' ? $_GET['p'] : 'home';

// 不正なパス文字（ディレクトリトラバーサル攻撃など）を防ぐ
$page = basename($page);

$pagePath = __DIR__ . '/../src/pages/' . $page . '.php';

// 3. ページの読み込み
if (file_exists($pagePath)) {
    // 該当ページが存在すれば読み込む
    // ここで読み込まれたPHPファイル内の __DIR__ は 'src/pages' を指します
    require_once $pagePath;
} else {
    // 存在しない場合は404ページを表示するか、トップにリダイレクト
    // ここでは簡単な404エラーページを表示
    http_response_code(404);
    echo "<!DOCTYPE html>";
    echo "<html lang='ja'>";
    echo "<head><meta charset='UTF-8'><title>404 Not Found</title></head>";
    echo "<body>";
    echo "<h1>404 Not Found</h1>";
    echo "<p>お探しのページは見つかりませんでした。</p>";
    echo "<a href='" . htmlspecialchars(SITE_URL, ENT_QUOTES, 'UTF-8') . "'>トップページへ戻る</a>";
    echo "</body>";
    echo "</html>";
}
