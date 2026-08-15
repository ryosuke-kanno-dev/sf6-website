<?php
$page_title = isset($page_title) ? $page_title : 'SF6 PORTAL';

// ページ個別で追加CSSが指定されていない場合は、デフォルトでパターンB(2カラム)用CSSを読み込む
if (!isset($extra_css)) {
    $extra_css = ['css/layouts/pattern-b-layout.css'];
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?></title>
  
  <!-- レイアウト・配置専用CSS (動的読み込み) -->
  <?php foreach ($extra_css as $css_file): ?>
    <link rel="stylesheet" href="<?php echo $css_file; ?>">
  <?php endforeach; ?>
  
  <!-- カラーテーマ & コンポーネントCSS -->
  <link rel="stylesheet" href="css/themes/theme-dynamic.css">
  <link rel="stylesheet" href="css/components/components.css">
</head>
<body>
<div class="app-container">