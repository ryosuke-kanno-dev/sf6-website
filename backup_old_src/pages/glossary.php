<?php
/**
 * SF6攻略ガイド - 用語集
 *
 * @description
 * SF6の格闘ゲーム用語を50音順で検索・閲覧できるページ。
 * data/glossary.json を読み込み、かな順ソートと50音グループ化をPHPで処理する。
 *
 * @structure
 * - サイドバー: sections/glossary/nav.php（検索窓・50音インデックス）
 * - メイン: sections/glossary/main.php（用語カード一覧）
 */

require_once __DIR__ . '/../includes/config.php';

// ==================== JSONデータ読込 ====================
$glossaryData = loadJsonFile(DATA_PATH . '/glossary.json');
if (!is_array($glossaryData)) {
    $glossaryData = [];
}

// ==================== かな順ソート ====================
usort($glossaryData, function ($a, $b) {
    return strcmp($a['kana'], $b['kana']);
});

// ==================== 50音グループ定義 ====================
// 清音・濁音・半濁音を同じ行にまとめる
$glossaryRows = [
    'あ行' => ['あ', 'い', 'う', 'え', 'お'],
    'か行' => ['か', 'き', 'く', 'け', 'こ', 'が', 'ぎ', 'ぐ', 'げ', 'ご'],
    'さ行' => ['さ', 'し', 'す', 'せ', 'そ', 'ざ', 'じ', 'ず', 'ぜ', 'ぞ'],
    'た行' => ['た', 'ち', 'つ', 'て', 'と', 'だ', 'ぢ', 'づ', 'で', 'ど'],
    'な行' => ['な', 'に', 'ぬ', 'ね', 'の'],
    'は行' => ['は', 'ひ', 'ふ', 'へ', 'ほ', 'ば', 'び', 'ぶ', 'べ', 'ぼ', 'ぱ', 'ぴ', 'ぷ', 'ぺ', 'ぽ'],
    'ま行' => ['ま', 'み', 'む', 'め', 'も'],
    'や行' => ['や', 'ゆ', 'よ'],
    'ら行' => ['ら', 'り', 'る', 'れ', 'ろ'],
    'わ行' => ['わ', 'を', 'ん'],
];

// ==================== グループ化 ====================
$glossaryGrouped = [];

foreach ($glossaryData as $entry) {
    if (empty($entry['kana'])) continue;

    // 先頭かな1文字を取得（ー等の長音符は直前の行に属させるため最大2文字まで探索）
    $firstChar = mb_substr($entry['kana'], 0, 1, 'UTF-8');

    $placed = false;
    foreach ($glossaryRows as $rowLabel => $chars) {
        if (in_array($firstChar, $chars, true)) {
            $glossaryGrouped[$rowLabel][] = $entry;
            $placed = true;
            break;
        }
    }

    // どの行にも属さない場合（英字・記号など）は「その他」へ
    if (!$placed) {
        $glossaryGrouped['その他'][] = $entry;
    }
}

// ==================== ページメタ情報 ====================
$totalTerms   = count($glossaryData);
$pageTitle    = '用語集 | ' . h(SITE_NAME);
$pageDescription = 'ストリートファイター6（SF6）の格闘ゲーム用語を50音順で解説。' .
                   'フレーム・システム用語・テクニック用語など' . $totalTerms . '語を収録。';
$currentPage  = 'glossary';
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

    <!-- CSS（読込順を維持）-->
    <link rel="stylesheet" href="css/variables.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/guide.css">
    <link rel="stylesheet" href="css/glossary.css">
    <link rel="stylesheet" href="css/ads.css">
</head>
<body>

    <!-- ヘッダー -->
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- ページ本体（guide.phpと同じ p-guide レイアウトを流用） -->
    <div class="p-guide">

        <!-- サイドバー：50音インデックス + 検索窓 -->
        <aside class="p-guide__sidebar" id="glossarySidebar">
            <h2 class="p-guide__sidebar-title">📖 用語集</h2>

            <!-- nav.phpに $glossaryRows / $glossaryGrouped を共有して描画 -->
            <?php include __DIR__ . '/../sections/glossary/nav.php'; ?>

            <!-- 用語数の統計 -->
            <div style="margin-top: var(--spacing-xl); padding: var(--spacing-md); background: var(--bg-card); border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                <p style="font-size: var(--font-size-sm); color: var(--text-muted); margin: 0;">
                    📊 収録用語数：<strong style="color: var(--accent-gold);"><?php echo $totalTerms; ?></strong> 語
                </p>
            </div>
        </aside>

        <!-- メインコンテンツ -->
        <main class="p-guide__main">
            <div class="l-container">

                <!-- ページヘッダー -->
                <div style="margin-bottom: 3rem;">
                    <h1 style="font-size: 3rem; font-weight: 900; color: var(--accent-white); text-shadow: 0 0 20px var(--accent-gold); margin-bottom: 1rem;">
                        用語集
                    </h1>
                    <p style="font-size: var(--font-size-lg); color: var(--text-muted);">
                        SF6でよく使われるゲーム用語を50音順で解説。
                        検索または行インデックスから探せます。
                    </p>
                </div>

                <!-- 用語カード一覧（main.php） -->
                <?php include __DIR__ . '/../sections/glossary/main.php'; ?>

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
    <script src="js/glossary.js"></script>

    <script>
    // ==================== サイドバー開閉（guide.phpと同じロジック） ====================
    (function () {
        const sidebar  = document.getElementById('glossarySidebar');
        const overlay  = document.getElementById('sidebarOverlay');
        const navLinks = document.querySelectorAll('.p-guide__nav-link');

        if (!sidebar || !overlay) return;

        // モバイル: オーバーレイをクリックで閉じる
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        // ナビリンクをクリックしたらモバイルでサイドバーを閉じる
        navLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 1024) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            });
        });
    })();
    </script>

</body>
</html>
