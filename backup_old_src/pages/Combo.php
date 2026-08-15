<?php
/**
 * SF6攻略ガイド - コンボ集
 *
 * @description
 * キャラクター選択後、DBからコンボ・コマンドリストを取得して表示するページ。
 * GETパラメータ ?char=luke でキャラを指定する。
 * 未指定時はキャラ選択グリッドを表示。
 *
 * @dependencies
 * - includes/config.php（getPdo() 関数を含む）
 * - lib/Parsedown.php
 * - includes/functions/command_converter.php
 * - data tables: characters, combos, command_list
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../lib/Parsedown.php';
require_once __DIR__ . '/../includes/functions/command_converter.php';
require_once __DIR__ . '/../includes/functions/db_helpers.php';

// ==================== 初期化 ====================
$parsedown = new Parsedown();
$parsedown->setSafeMode(true);

$currentPage  = 'combo';
$charSlug     = '';
$character    = null;
$characters   = [];
$combos       = [];
$moveList     = [];  // movelistテーブルのデータ
$profileHtml  = '';
$mode         = 'select'; // 'select' or 'detail'
$dbError      = false;

// ==================== DB接続 & データ取得 ====================
$pdoAvailable = false;
try {
    $pdo = getPdo();
    $pdoAvailable = true;
} catch (PDOException $e) {
    $dbError   = true;
    $dbMessage = 'DB接続失敗: ' . $e->getMessage();
    error_log('combo.php DB connection error: ' . $e->getMessage());
}

if ($pdoAvailable) {
    // GETパラメータのサニタイズ
    $charSlug = preg_replace('/[^a-z0-9\-]/', '', strtolower($_GET['char'] ?? ''));

    if ($charSlug !== '') {
        // ── 詳細モード ──
        $mode = 'detail';

        try {
            // キャラ単体取得
            $character = getCharacterBySlug($pdo, $charSlug);

            if (!$character) {
                $mode     = 'select';
                $charSlug = '';
            } else {
                // profile_text を Parsedown 変換
                // DBに '  \n'（スペース2つ + バックスラッシュn）が文字列として格納されている場合に対応
                $rawProfileText = $character['profile_text'] ?? '';
                // バックスラッシュ+n → 実際の改行文字に変換
                $rawProfileText = str_replace('\\n', "\n", $rawProfileText);
                $profileHtml = !empty($rawProfileText)
                    ? $parsedown->text($rawProfileText)
                    : '';

                // コンボ取得
                try {
                    $stmt = $pdo->prepare(
                        "SELECT * FROM combos
                         WHERE character_id = ? AND page_type = 'general'
                         ORDER BY is_recommended DESC, sort_order ASC"
                    );
                    $stmt->execute([$character['id']]);
                    $combos = $stmt->fetchAll();
                } catch (PDOException $e) {
                    $combos = [];
                    error_log('combos query error: ' . $e->getMessage());
                }

                // movelist取得（conditionはMySQL予約語のためバッククォート必須）
                try {
                    $stmt = $pdo->prepare(
                        'SELECT id, character_id, move_slug, move_type, name_jp, name_en,
                                command, parent_slug, drive_gauge, sa_level,
                                `condition`, overview, sort_order
                         FROM movelist
                         WHERE character_id = ?
                         ORDER BY sort_order ASC'
                    );
                    $stmt->execute([$character['id']]);
                    $moveList = $stmt->fetchAll();
                } catch (PDOException $e) {
                    $moveList = [];
                    error_log('movelist query error: ' . $e->getMessage());
                }
            }
        } catch (PDOException $e) {
            $dbError   = true;
            $dbMessage = 'キャラデータ取得エラー: ' . $e->getMessage();
            error_log('combo.php detail error: ' . $e->getMessage());
        }
    }

    if ($mode === 'select') {
        $characters = getAllCharacters($pdo);
    }
}

// ==================== ページメタ ====================
$pageTitle       = 'コンボ集 | ' . h(SITE_NAME);
$pageDescription = 'SF6キャラクター別のコンボレシピ・コマンドリストを掲載。';
if ($mode === 'detail' && $character) {
    $pageTitle       = h($character['name_jp']) . ' コンボ集 | ' . h(SITE_NAME);
    $pageDescription = h($character['name_jp']) . 'のコンボレシピ・コマンドリスト。';
}
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
    <link rel="stylesheet" href="css/combo.css">
    <link rel="stylesheet" href="css/ads.css">
</head>
<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main>
        <div class="l-container" style="padding-top: var(--spacing-2xl); padding-bottom: var(--spacing-3xl);">

            <!-- DB接続エラー表示 -->
            <?php if ($dbError): ?>
                <div class="c-card" style="border-left: 4px solid #FF3D57; margin-bottom: var(--spacing-2xl);">
                    <h2 style="color:#FF3D57; margin-bottom: var(--spacing-sm);">⚠️ DBエラー</h2>
                    <p style="color: var(--text-muted); font-size: var(--font-size-sm);">
                        <?php echo h($dbMessage ?? '不明なエラー'); ?>
                    </p>
                </div>
            <?php endif; ?>

            <!-- ==================== キャラ選択モード ==================== -->
            <?php if ($mode === 'select'): ?>
                <?php include __DIR__ . '/../sections/_shared/char_select.php'; ?>

            <!-- ==================== キャラ詳細モード ==================== -->
            <?php elseif ($mode === 'detail' && $character): ?>
                <?php include __DIR__ . '/../sections/combo/char_detail.php'; ?>
            <?php endif; ?>

        </div><!-- /.l-container -->
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="js/main.js"></script>
    <script>
    // ==================== 難易度タブ ====================
    (function () {
        const tabs   = document.querySelectorAll('.p-combo__diff-tab');
        const panels = document.querySelectorAll('.p-combo__diff-panel');

        if (!tabs.length) return;

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                const target = tab.dataset.tab;

                tabs.forEach(function (t) {
                    t.classList.toggle('is-active', t.dataset.tab === target);
                    t.setAttribute('aria-selected', t.dataset.tab === target ? 'true' : 'false');
                });

                panels.forEach(function (p) {
                    p.classList.toggle('is-active', p.id === 'panel-' + target);
                });
            });
        });
    })();
    </script>

</body>
</html>
