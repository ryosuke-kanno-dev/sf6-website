<?php
/**
 * SF6攻略ガイド - 練習する
 * トレーニングメニューと実践ガイド
 */

// 設定ファイルの読み込み
require_once __DIR__ . '/../includes/config.php';

// JSONデータの読み込み
$trainMenus = loadJsonFile(DATA_PATH . '/training_menus.json');

// ページ情報
$pageTitle = '練習する | ' . h(SITE_NAME);
$pageDescription = 'SF6の効果的な練習メニュー。ランク別・目的別の練習方法、トレーニングモードの使い方、毎日のルーティーンを紹介';
$currentPage = 'training';
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
    <link rel="stylesheet" href="css/guide.css">
    <link rel="stylesheet" href="css/training.css">
    <link rel="stylesheet" href="css/ads.css">
</head>
<body>
    <!-- ヘッダー -->
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="p-guide p-training">
        <!-- サイドバーナビゲーション -->
        <aside class="p-guide__sidebar" id="guideSidebar">
            <h2 class="p-guide__sidebar-title">📖 目次</h2>
            <nav>
                <ul class="p-guide__nav">
                    <li class="p-guide__nav-item">
                        <a href="#knowledge" class="p-guide__nav-link active" data-section="knowledge">
                            📚 基礎知識
                        </a>
                    </li>
                    <li class="p-guide__nav-item">
                        <a href="#navigation" class="p-guide__nav-link" data-section="navigation">
                            🎯 メニューを探す
                        </a>
                    </li>
                    <li class="p-guide__nav-item">
                        <a href="#menu" class="p-guide__nav-link" data-section="menu">
                            💪 練習メニュー
                        </a>
                    </li>
                    <li class="p-guide__nav-item">
                        <a href="#routine" class="p-guide__nav-link" data-section="routine">
                            📅 ルーティーン
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- メインコンテンツ -->
        <main class="p-guide__main">
            <div class="l-container">
                <!-- ページヘッダー -->
                <div class="training-header" style="margin-bottom: 3rem;">
                    <h1 style="font-size: 3rem; font-weight: 900; color: var(--accent-white); text-shadow: 0 0 20px var(--accent-gold); margin-bottom: 1rem;">
                        💪 練習する
                    </h1>
                    <p class="text-secondary" style="font-size: var(--font-size-lg);">
                        効率的な練習で確実に上達。あなたのランク・悩み・時間に合わせた最適な練習メニューを見つけましょう。
                    </p>
                </div>

                <!-- 知識セクション -->
                <?php include __DIR__ . '/../sections/training/knowledge.php'; ?>

                <!-- ナビゲーションセクション -->
                <?php include __DIR__ . '/../sections/training/navigation.php'; ?>

                <!-- 練習メニューセクション -->
                <?php include __DIR__ . '/../sections/training/menu.php'; ?>

                <!-- ルーティーンセクション -->
                <?php include __DIR__ . '/../sections/training/routine.php'; ?>

                <!-- CTAセクション -->
                <section class="section" style="padding: 3rem 0;">
                    <div class="cta-section">
                        <div class="cta-content">
                            <h2 class="cta-title">練習したら実戦で試そう！</h2>
                            <p class="cta-subtitle">キャラ別の対策を見て、ランクマッチで腕試し</p>
                            <a href="matchup" class="cta-btn-large">
                                <span>キャラ対策を見る</span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- サイドバーオーバーレイ（モバイル用） -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- フッター -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="js/main.js"></script>
    <script src="js/training.js"></script>
</body>
</html>
