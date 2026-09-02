<?php
// HTMLエスケープ用ヘルパー（他ファイルの h() と衝突しないようガード）
if (!function_exists('h')) {
    function h($str): string {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }
}

$page_title = isset($page_title) ? $page_title : 'SF6 PORTAL';

// ページ個別で追加CSSが指定されていない場合は、デフォルトでパターンB(2カラム)用CSSを読み込む
if (!isset($extra_css)) {
    $extra_css = ['css/layouts/pattern-b-layout.css'];
}

// --- SEO / OGP 用メタ情報 ---

// meta description（ページ個別で $page_description が未指定ならサイト共通の説明文を使用）
$default_description = 'ストリートファイター6（SF6）攻略ポータル。初期設定ガイド、トレモ練習メニュー、キャラクター別コンボ・確定反撃、上達ロードマップ、格ゲー用語集まで網羅したファンメイド攻略サイトです。';
$page_description    = isset($page_description) ? $page_description : $default_description;

// OGP: type（キャラ攻略ページ等で個別に上書き可能。未指定時は 'website'）
$og_type = isset($og_type) ? $og_type : 'website';

// OGP: image（ページ個別で $og_image が未指定ならサイト共通のデフォルト画像を使用）
// ※ img/ogp-default.jpg は仮のパスです。実際のOGP用画像を配置後、パスの確認をお願いします。
$default_og_image = 'img/ogp-default.jpg';
$og_image          = isset($og_image) ? $og_image : $default_og_image;

// 現在のURL・サイトのベースURLを動的に組み立てる
// （開発環境のサブフォルダ配置・本番環境のドメイン直下配置のどちらでも自動対応できるようにする）
$protocol      = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host          = $_SERVER['HTTP_HOST'] ?? 'localhost';
$base_path     = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
$site_root_url = $protocol . $host . $base_path;
$current_url   = $protocol . $host . ($_SERVER['REQUEST_URI'] ?? '/');

// OGP: url（ページ個別で $og_url が未指定なら現在のURLを使用）
$og_url = isset($og_url) ? $og_url : $current_url;

// OGP画像を絶対URL化（$og_image が既に http(s) から始まっている場合はそのまま使用）
$og_image_url = preg_match('#^https?://#i', $og_image)
    ? $og_image
    : $site_root_url . '/' . ltrim($og_image, '/');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo h($page_title); ?></title>

  <!-- SEO -->
  <meta name="description" content="<?php echo h($page_description); ?>">
  <link rel="canonical" href="<?php echo h($og_url); ?>">

  <!-- OGP (Open Graph Protocol) -->
  <meta property="og:title" content="<?php echo h($page_title); ?>">
  <meta property="og:description" content="<?php echo h($page_description); ?>">
  <meta property="og:type" content="<?php echo h($og_type); ?>">
  <meta property="og:url" content="<?php echo h($og_url); ?>">
  <meta property="og:image" content="<?php echo h($og_image_url); ?>">
  <meta property="og:site_name" content="SF6 PORTAL">
  <meta property="og:locale" content="ja_JP">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo h($page_title); ?>">
  <meta name="twitter:description" content="<?php echo h($page_description); ?>">
  <meta name="twitter:image" content="<?php echo h($og_image_url); ?>">

  <!-- レイアウト・配置専用CSS (動的読み込み) -->
  <?php foreach ($extra_css as $css_file): ?>
    <link rel="stylesheet" href="<?php echo h($css_file); ?>">
  <?php endforeach; ?>

  <!-- カラーテーマ & コンポーネントCSS -->
  <link rel="stylesheet" href="css/themes/theme-dynamic.css">
  <link rel="stylesheet" href="css/components/components.css">
</head>
<body>
<div class="app-container">