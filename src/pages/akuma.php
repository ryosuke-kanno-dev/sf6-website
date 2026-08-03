<?php
/**
 * SF6攻略ガイド - 豪鬼特設ページ
 *
 * @description
 * 豪鬼（AKUMA）専用の深掘り攻略ページ。
 * 強み・弱み、立ち回り、リーサル判断、コンボ集、
 * 起き攻め、セットアップ、キャラ対策、フレームデータを掲載。
 *
 * @dependencies
 * - includes/config.php（getPdo() 関数を含む）
 * - lib/Parsedown.php
 * - includes/functions/command_converter.php
 * - data tables: characters, combos, movelist
 * - sections/akuma/*.php
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../lib/Parsedown.php';
require_once __DIR__ . '/../includes/functions/command_converter.php';
require_once __DIR__ . '/../includes/functions/db_helpers.php';

// ==================== 初期化 ====================
$parsedown = new Parsedown();
$parsedown->setSafeMode(true);

$character  = null;
$combos     = [];
$moveList   = [];
$dbError    = false;
$dbMessage  = '';

const AKUMA_SLUG = 'gouki';

// ==================== DB接続 & データ取得 ====================
try {
    $pdo = getPdo();

    // 豪鬼の基本情報取得
    $character = getCharacterBySlug($pdo, 'gouki');

    if ($character) {
        $charId = $character['id'];

        // コンボ取得（is_recommended -> sort_order 順）
        try {
            $stmt = $pdo->prepare(
                "SELECT * FROM combos
                 WHERE character_id = ? AND page_type = 'general'
                 ORDER BY is_recommended DESC, sort_order ASC"
            );
            $stmt->execute([$charId]);
            $combos = $stmt->fetchAll();
        } catch (PDOException $e) {
            $combos = [];
            error_log('akuma.php combos error: ' . $e->getMessage());
        }

        // movelistを取得
        try {
            $stmt = $pdo->prepare(
                'SELECT id, move_slug, move_type, name_jp, name_en,
                        command, parent_slug, drive_gauge, sa_level,
                        `condition`, overview, sort_order
                 FROM movelist
                 WHERE character_id = ?
                 ORDER BY sort_order ASC'
            );
            $stmt->execute([$charId]);
            $moveList = $stmt->fetchAll();
        } catch (PDOException $e) {
            $moveList = [];
            error_log('akuma.php movelist error: ' . $e->getMessage());
        }
    }

} catch (PDOException $e) {
    $dbError   = true;
    $dbMessage = 'DB接続失敗: ' . $e->getMessage();
    error_log('akuma.php DB connection error: ' . $e->getMessage());
}

// ==================== データ整形 ====================

// 難易度ラベル
$diffLabel  = ['Beginner' => '初級', 'Intermediate' => '中級', 'Advanced' => '上級'];
$diffModMap = ['Beginner' => 'beginner', 'Intermediate' => 'intermediate', 'Advanced' => 'advanced'];

// 位置ラベル
$posLabel = ['Any' => '全', 'Mid' => '中央', 'Corner' => '端'];

// move_type ラベル・表示順
$moveTypeLbl  = [
    'special_moves'  => '必殺技',
    'super_arts'     => 'スーパーアーツ',
    'unique_attacks' => '特殊技',
    'throws'         => '投げ',
    'common_moves'   => '共通システム',
    'normal_moves'   => '通常技',
];
$moveTypeOrder = ['special_moves', 'super_arts', 'unique_attacks', 'throws', 'common_moves', 'normal_moves'];

// moveListを move_type 別にグループ化（親技のみ）
$moveGroups = [];
foreach ($moveList as $move) {
    $type = $move['move_type'] ?? 'other';
    if (!empty($move['parent_slug'])) continue;
    $moveGroups[$type][] = $move;
}

// 仮のキャラ対策データ（DB連携は後で実装）
$matchupData = [
    ['slug' => 'ryu',     'name_jp' => 'リュウ',     'score' => '5-5',     'type' => 'even'],
    ['slug' => 'ken',     'name_jp' => 'ケン',        'score' => '5-5',     'type' => 'even'],
    ['slug' => 'luke',    'name_jp' => 'ルーク',      'score' => '4-6',     'type' => 'disadv'],
    ['slug' => 'guile',   'name_jp' => 'ガイル',      'score' => '4-6',     'type' => 'disadv'],
    ['slug' => 'juri',    'name_jp' => 'ジュリ',      'score' => '5-5',     'type' => 'even'],
    ['slug' => 'cammy',   'name_jp' => 'キャミィ',    'score' => '6-4',     'type' => 'adv'],
    ['slug' => 'chunli',  'name_jp' => '春麗',         'score' => '5-5',     'type' => 'even'],
    ['slug' => 'zangief', 'name_jp' => 'ザンギエフ',  'score' => '6-4',     'type' => 'adv'],
    ['slug' => 'marisa',  'name_jp' => 'マリーザ',    'score' => '5-5',     'type' => 'even'],
    ['slug' => 'jamie',   'name_jp' => 'ジェイミー',  'score' => '5.5-4.5', 'type' => 'adv'],
    ['slug' => 'manon',   'name_jp' => 'マノン',       'score' => '6-4',     'type' => 'adv'],
    ['slug' => 'blanka',  'name_jp' => 'ブランカ',    'score' => '5-5',     'type' => 'even'],
    ['slug' => 'dhalsim', 'name_jp' => 'ダルシム',    'score' => '4-6',     'type' => 'disadv'],
    ['slug' => 'ehonda',  'name_jp' => 'E.本田',       'score' => '5-5',     'type' => 'even'],
    ['slug' => 'kimberly','name_jp' => 'キンバリー',  'score' => '5.5-4.5', 'type' => 'adv'],
];

// ==================== ページメタ ====================
$pageTitle       = '豪鬼（AKUMA）特設ページ | ' . h(SITE_NAME);
$pageDescription = '豪鬼の強み・弱み、立ち回り、コンボ、起き攻め、セットアップ、キャラ対策、フレームデータを完全解説。';
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
    <link rel="stylesheet" href="css/akuma.css">
    <link rel="stylesheet" href="css/ads.css">
</head>
<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- DBエラー表示 -->
    <?php if ($dbError): ?>
    <div class="c-card" style="border-left: 4px solid #FF3D57; margin: var(--spacing-lg) auto; max-width: var(--max-width-xl);">
        <h2 style="color:#FF3D57; margin-bottom: var(--spacing-sm);">⚠️ DBエラー</h2>
        <p style="color: var(--text-muted); font-size: var(--font-size-sm);"><?php echo h($dbMessage); ?></p>
    </div>
    <?php endif; ?>

    <!-- ヒーローヘッダー -->
    <?php include __DIR__ . '/../sections/akuma/hero.php'; ?>

    <!-- ページナビゲーション -->
    <?php include __DIR__ . '/../sections/akuma/page_nav.php'; ?>

    <main>
        <div class="l-container" style="padding-top: var(--spacing-2xl);">

            <!-- 豪鬼オーバーライドバナー -->
            <div class="p-akuma__override-banner" style="margin-bottom: var(--spacing-3xl);">
                <span class="p-akuma__override-icon">👹</span>
                <p class="p-akuma__override-text">
                    このページは<strong>豪鬼専用の攻略情報</strong>をまとめた特設ページです。
                    阿修羅閃空を使った固有の回避や、豪鬼ならではのセットアップ・リーサルラインなど、
                    他のキャラページには載っていない深い情報を掲載しています。
                </p>
            </div>

        </div><!-- /.l-container -->

        <!-- ① 強み・弱み -->
        <?php include __DIR__ . '/../sections/akuma/strength.php'; ?>

        <!-- ② 立ち回り -->
        <?php include __DIR__ . '/../sections/akuma/tactics.php'; ?>

        <!-- ③ リーサル判断 -->
        <?php include __DIR__ . '/../sections/akuma/lethal.php'; ?>

        <!-- ④ コンボ集 -->
        <?php include __DIR__ . '/../sections/akuma/combo.php'; ?>

        <!-- ⑤ 起き攻め -->
        <?php include __DIR__ . '/../sections/akuma/okizeme.php'; ?>

        <!-- ⑥ セットアップ -->
        <?php include __DIR__ . '/../sections/akuma/setup.php'; ?>

        <!-- ⑦ キャラ対策サマリー -->
        <?php include __DIR__ . '/../sections/akuma/matchup.php'; ?>

        <!-- ⑧ フレームデータ -->
        <?php include __DIR__ . '/../sections/akuma/framedata.php'; ?>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="js/main.js"></script>
    <script>
    (function () {
        // ==================== フレームデータ タブ切り替え ====================
        var tabBtns = document.querySelectorAll('.p-akuma__tab-btn');
        tabBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var target = btn.getAttribute('data-tab');
                tabBtns.forEach(function (b) { b.classList.remove('is-active'); });
                btn.classList.add('is-active');
                document.querySelectorAll('.p-akuma__tab-panel').forEach(function (panel) {
                    panel.classList.toggle('is-active', panel.getAttribute('data-panel') === target);
                });
            });
        });

        // ==================== ページナビ アクティブ追従 ====================
        var navLinks = document.querySelectorAll('.p-akuma__page-nav-link');
        var sections = document.querySelectorAll('section[id]');

        if ('IntersectionObserver' in window && navLinks.length) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        var id = entry.target.getAttribute('id');
                        navLinks.forEach(function (link) {
                            link.classList.toggle('is-active', link.getAttribute('href') === '#' + id);
                        });
                    }
                });
            }, { rootMargin: '-40% 0px -55% 0px', threshold: 0 });
            sections.forEach(function (s) { observer.observe(s); });
        }
    })();
    </script>
</body>
</html>
