<?php
/**
 * SF6攻略ガイド - キャラ対策
 *
 * GETパラメータ ?char=ryu でキャラを指定。
 * 未指定時はキャラ選択グリッドを表示。
 *
 * @dependencies
 *   includes/config.php, lib/Parsedown.php,
 *   includes/functions/command_converter.php
 *   tables: characters, matchup, matchup_guides, frame, movelist
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../lib/Parsedown.php';
require_once __DIR__ . '/../includes/functions/command_converter.php';
require_once __DIR__ . '/../includes/functions/db_helpers.php';

// ── 初期化 ─────────────────────────────────────
$parsedown = new Parsedown();
$parsedown->setSafeMode(true);

/** Markdownを安全にレンダリングして返す */
function parseMarkdown(string $text, Parsedown $pd): string {
    $text = str_replace('\\n', "\n", $text);
    return $pd->text($text);
}

$currentPage  = 'matchup';
$charSlug     = '';
$character    = null;
$characters   = [];
$matchupData  = null;   // matchup テーブル 1行
$guides       = [];     // matchup_guides を category別に格納
$punishList   = [];     // 確定反撃（frame）
$reversalList = [];     // 切り返し手段（frame）
$mode         = 'select';
$dbError      = false;
$dbMessage    = '';

// ── DB接続 ────────────────────────────────────
$pdoAvailable = false;
try {
    $pdo = getPdo();
    $pdoAvailable = true;
} catch (PDOException $e) {
    $dbError   = true;
    $dbMessage = 'DB接続失敗: ' . $e->getMessage();
    error_log('matchup.php DB error: ' . $e->getMessage());
}

// ── データ取得 ────────────────────────────────
if ($pdoAvailable) {
    $charSlug = preg_replace('/[^a-z0-9\-]/', '', strtolower($_GET['char'] ?? ''));

    if ($charSlug !== '') {
        $mode = 'detail';
        try {
            // キャラ情報
            $character = getCharacterBySlug($pdo, $charSlug);

            if (!$character) {
                $mode = 'select';
            } else {
                $charId = (int)$character['id'];

                // matchup テーブル
                try {
                    $stmt = $pdo->prepare('SELECT * FROM matchup WHERE character_id = ? LIMIT 1');
                    $stmt->execute([$charId]);
                    $matchupData = $stmt->fetch() ?: null;
                } catch (PDOException $e) {
                    error_log('matchup query: ' . $e->getMessage());
                }

                // matchup_guides
                try {
                    $stmt = $pdo->prepare(
                        'SELECT * FROM matchup_guides
                         WHERE opponent_char_id = ?
                         ORDER BY category, sort_order'
                    );
                    $stmt->execute([$charId]);
                    foreach ($stmt->fetchAll() as $row) {
                        $guides[$row['category']][] = $row;
                    }
                } catch (PDOException $e) {
                    error_log('matchup_guides query: ' . $e->getMessage());
                }

                // 技コマンドの一覧（move_slug → command）を取得
                $moveCommandMap = [];
                try {
                    $stmt = $pdo->prepare('SELECT move_slug, command FROM movelist WHERE character_id = ?');
                    $stmt->execute([$charId]);
                    foreach ($stmt->fetchAll() as $row) {
                        $moveCommandMap[$row['move_slug']] = $row['command'];
                    }
                    // frameテーブル側にもコマンドがあれば上書き（優先）
                    $stmt = $pdo->prepare('SELECT move_slug, command FROM frame WHERE character_id = ? AND command IS NOT NULL AND command != ""');
                    $stmt->execute([$charId]);
                    foreach ($stmt->fetchAll() as $row) {
                        if (!empty($row['command'])) {
                            $moveCommandMap[$row['move_slug']] = $row['command'];
                        }
                    }
                } catch (PDOException $e) {
                    error_log('move command query: ' . $e->getMessage());
                }

                // 確定反撃リスト（guard_adv <= -4）
                try {
                    $stmt = $pdo->prepare("
                        SELECT
                            f.move_slug, f.move_variant, f.move_name_jp,
                            f.command   AS frame_command,
                            f.startup, f.guard_adv, f.damage, f.cancel,
                            m.command   AS movelist_command
                        FROM frame f
                        LEFT JOIN movelist m
                          ON f.character_id = m.character_id
                         AND f.move_slug    = m.move_slug
                        WHERE f.character_id = :id
                          AND f.guard_adv NOT IN ('', 'D', '—', '-')
                          AND CAST(f.guard_adv AS SIGNED) <= -4
                        ORDER BY CAST(f.guard_adv AS SIGNED) ASC
                    ");
                    $stmt->execute([':id' => $charId]);
                    $punishList = $stmt->fetchAll();
                } catch (PDOException $e) {
                    error_log('punish query: ' . $e->getMessage());
                }

                // 切り返し手段（無敵・アーマー）
                try {
                    $stmt = $pdo->prepare("
                        SELECT f.move_slug, f.move_variant, f.move_name_jp,
                               f.command, f.startup, f.miscellaneous
                        FROM frame f
                        WHERE f.character_id = :id
                          AND f.miscellaneous IS NOT NULL
                          AND (
                              f.miscellaneous LIKE '%完全無敵%'
                              OR f.miscellaneous LIKE '%打撃・投げに対して無敵%'
                              OR f.miscellaneous LIKE '%アーマー%'
                          )
                        ORDER BY f.sort_order
                    ");
                    $stmt->execute([':id' => $charId]);
                    $reversalList = $stmt->fetchAll();
                } catch (PDOException $e) {
                    error_log('reversal query: ' . $e->getMessage());
                }
            }
        } catch (PDOException $e) {
            $dbError   = true;
            $dbMessage = 'データ取得エラー: ' . $e->getMessage();
            error_log('matchup.php detail: ' . $e->getMessage());
        }
    }

    if ($mode === 'select') {
        $characters = getAllCharacters($pdo);
    }
}

// ── ページメタ ────────────────────────────────
$pageTitle       = 'キャラ対策 | ' . h(SITE_NAME);
$pageDescription = 'SF6キャラクター別の対策・確定反撃・切り返し手段を掲載。';
if ($mode === 'detail' && $character) {
    $pageTitle       = h($character['name_jp']) . ' 対策 | ' . h(SITE_NAME);
    $pageDescription = h($character['name_jp']) . 'の対策・確定反撃・切り返し手段。';
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
    <link rel="stylesheet" href="css/matchup.css">
    <link rel="stylesheet" href="css/ads.css">
</head>
<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main>
        <div class="l-container" style="padding-top: var(--spacing-2xl); padding-bottom: var(--spacing-3xl);">

            <!-- DBエラー -->
            <?php if ($dbError): ?>
                <div class="c-card" style="border-left: 4px solid #FF3D57; margin-bottom: var(--spacing-2xl);">
                    <h2 style="color:#FF3D57; margin-bottom: var(--spacing-sm);">⚠️ DBエラー</h2>
                    <p style="color: var(--text-muted); font-size: var(--font-size-sm);">
                        <?php echo h($dbMessage); ?>
                    </p>
                </div>
            <?php endif; ?>

            <!-- キャラ選択 -->
            <?php if ($mode === 'select'): ?>
                <?php include __DIR__ . '/../sections/_shared/char_select.php'; ?>

            <!-- キャラ対策詳細 -->
            <?php elseif ($mode === 'detail' && $character): ?>
                <?php include __DIR__ . '/../sections/matchup/char_detail.php'; ?>
            <?php endif; ?>

        </div><!-- /.l-container -->
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <script src="js/main.js"></script>
    <script>
    // アコーディオン（対策ガイドセクション）
    (function () {
        document.querySelectorAll('.p-matchup__acc-trigger').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var panel    = document.getElementById(btn.getAttribute('aria-controls'));
                var expanded = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
                if (panel) panel.hidden = expanded;
                btn.querySelector('.p-matchup__acc-arrow').textContent = expanded ? '▼' : '▲';
            });
        });
    })();
    </script>

</body>
</html>
