<?php
/**
 * SF6攻略ガイド - 上達ロードマップ
 *
 * @description
 * ランク帯別の考え方・練習方針・推奨練習メニューを提示するページ。
 * data/roadmap/roadmap.json を読み込み、ランクごとのMarkdownを Parsedown で変換して表示する。
 *
 * @structure
 * - サイドバー: sections/roadmap/nav.php（ランク帯選択ナビ）
 * - メイン: sections/roadmap/content.php（Markdown本文 + 推奨練習カード）
 *
 * @dependencies
 * - lib/Parsedown.php
 * - data/roadmap/roadmap.json
 * - data/roadmap/{id}.md
 * - data/training_menus.json
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../lib/Parsedown.php';

// ==================== データ読込 ====================
$roadmapData    = loadJsonFile(DATA_PATH . '/roadmap/roadmap.json') ?? [];
$trainingMenus  = loadJsonFile(DATA_PATH . '/training_menus.json');

// training_menus を ID をキーにした連想配列に変換
$trainingMenusById = [];
if (isset($trainingMenus['menus']) && is_array($trainingMenus['menus'])) {
    foreach ($trainingMenus['menus'] as $menu) {
        $trainingMenusById[$menu['id']] = $menu;
    }
}

// ==================== Markdownを変換 ====================
$parsedown = new Parsedown();
$parsedown->setSafeMode(true); // XSS対策

$roadmapHtml = [];
foreach ($roadmapData as $rank) {
    $mdPath = DATA_PATH . '/roadmap/' . $rank['md_file'];
    if (file_exists($mdPath)) {
        $mdContent = file_get_contents($mdPath);
        $roadmapHtml[$rank['id']] = $parsedown->text($mdContent);
    } else {
        $roadmapHtml[$rank['id']] = '';
        error_log("Roadmap MD file not found: {$mdPath}");
    }
}

// ==================== ページメタ情報 ====================
$pageTitle       = '上達ロードマップ | ' . h(SITE_NAME);
$pageDescription = 'SF6のランク帯別（ビギナー〜マスター）に、上達のための考え方・行動・推奨練習メニューを解説。' .
                   '自分のランクに合ったロードマップで最短上達を目指そう。';
$currentPage     = 'roadmap';
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

    <!-- CSS（読込順を維持） -->
    <link rel="stylesheet" href="css/variables.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/guide.css">
    <link rel="stylesheet" href="css/roadmap.css">
    <link rel="stylesheet" href="css/ads.css">
</head>
<body>

    <!-- ヘッダー -->
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- ページ本体（guide.php と同じ p-guide レイアウトを流用） -->
    <div class="p-guide">

        <!-- サイドバー：ランク帯ナビ -->
        <aside class="p-guide__sidebar" id="roadmapSidebar">
            <h2 class="p-guide__sidebar-title">🗺️ ランク別ロードマップ</h2>

            <?php include __DIR__ . '/../sections/roadmap/nav.php'; ?>
        </aside>

        <!-- メインコンテンツ -->
        <main class="p-guide__main">
            <div class="l-container">

                <!-- ページヘッダー -->
                <div style="margin-bottom: 3rem;">
                    <h1 style="font-size: 3rem; font-weight: 900; color: var(--accent-white); text-shadow: 0 0 20px var(--accent-gold); margin-bottom: 1rem;">
                        上達ロードマップ
                    </h1>
                    <p style="font-size: var(--font-size-lg); color: var(--text-muted);">
                        自分のランク帯を選び、次のステージへの最短ルートを確認しよう。
                        考え方・行動・練習メニューをセットで提供します。
                    </p>
                </div>

                <!-- ランク別コンテンツ（content.php） -->
                <?php include __DIR__ . '/../sections/roadmap/content.php'; ?>

                <!-- フッター上広告 -->
                <div class="ad-space horizontal ad-footer-above">
                    広告スペース (728x90)
                </div>

            </div><!-- /.l-container -->
        </main>

    </div><!-- /.p-guide -->

    <!-- サイドバーオーバーレイ（モバイル用） -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- フッター -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="js/main.js"></script>
    <script src="js/roadmap.js"></script>

    <script>
    // ==================== サイドバー開閉（モバイル用） ====================
    (function () {
        const sidebar  = document.getElementById('roadmapSidebar');
        const overlay  = document.getElementById('sidebarOverlay');

        if (!sidebar || !overlay) return;

        overlay.addEventListener('click', function () {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    })();
    </script>

</body>
</html>
