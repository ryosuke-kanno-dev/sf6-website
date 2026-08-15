<?php
/**
 * SF6攻略ガイド - ホームページ
 * 新しいバージョン
 */

// 設定ファイルの読み込み
require_once __DIR__ . '/../includes/config.php';

// JSONデータの読み込み
$siteInfo = loadJsonFile(SITE_INFO_JSON);
$characters = loadJsonFile(CHARACTERS_JSON);
$updates = loadJsonFile(UPDATES_JSON);

// データが読み込めない場合のフォールバック
if (!$siteInfo) {
    $siteInfo = [
        'siteName' => 'SF6攻略ガイド',
        'siteDescription' => 'Street Fighter 6の総合攻略サイト',
        'hero' => [
            'badge' => 'Street Fighter 6',
            'title' => '最速で上達する<br>SF6完全攻略',
            'subtitle' => '初心者から上級者まで、あなたのランクに合わせた最適な練習法を提供',
            'primaryCta' => ['text' => 'ランク診断を始める', 'url' => '/roadmap.php'],
            'secondaryCta' => ['text' => '練習メニューを見る', 'url' => '/training.php']
        ],
        'features' => [],
        'quickNav' => []
    ];
}

// 最新の3件のみ表示
$featuredUpdates = array_filter($updates ?? [], function($update) {
    return isset($update['featured']) && $update['featured'] === true;
});
$featuredUpdates = array_slice($featuredUpdates, 0, 3);

// ページ情報
$pageTitle = h($siteInfo['siteName'] ?? 'SF6攻略ガイド');
$pageDescription = h($siteInfo['siteDescription'] ?? 'Street Fighter 6の総合攻略サイト');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <base href="<?php echo htmlspecialchars(SITE_URL, ENT_QUOTES, 'UTF-8'); ?>/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $pageDescription; ?>">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/variables.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/ads.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
    <!-- ヘッダー -->
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- ヒーローセクション -->
    <?php include __DIR__ . '/../sections/home/hero.php'; ?>

    <!-- ヒーロー下広告 -->
    <div class="ad-space horizontal ad-header-below" style="margin: var(--spacing-2xl) auto;">
        広告スペース (728x90)
    </div>

    <!-- クイックナビゲーション -->
    <?php include __DIR__ . '/../sections/home/quick_nav.php'; ?>

    <!-- 特徴セクション -->
    <?php include __DIR__ . '/../sections/home/features.php'; ?>

    <!-- コンテンツ間広告 -->
    <div class="ad-space rectangle ad-between-content" style="margin: var(--spacing-3xl) auto;">
        広告スペース (336x280)
    </div>

    <!-- 最新情報 -->
    <?php include __DIR__ . '/../sections/home/updates.php'; ?>

    <!-- CTA -->
    <?php include __DIR__ . '/../sections/home/cta.php'; ?>

    <!-- フッター -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="js/main.js"></script>
</body>
</html>
