<?php
/**
 * データ充足状況チェック用の診断ページ（一時的なツール）
 *
 * 各キャラクターについて、combos / frame / matchup / matchup_guides に
 * 何件のデータが入っているかを一覧表示する。
 *
 * 使い方：
 *   1. このファイルを src/ 直下（index.php と同じ階層）に置く
 *   2. ブラウザで http://localhost/（配置パス）/db-check.php を開く
 *   3. 表示された内容をスクリーンショット、またはページ下部の
 *      「コピー用テキスト」をそのままコピーして共有する
 *
 * 確認が終わったら、このファイルはサーバー上から削除してください
 * （DBの内部状況が誰でも見える状態になってしまうため）。
 */

require_once 'includes/db.php';
require_once 'includes/functions/db_helpers.php';

$characters = getAllCharacters($pdo);

$rows = [];
foreach ($characters as $char) {
    $charId   = $char['id'];
    $slug     = $char['char_slug'] ?? '';
    $nameJp   = $char['name_jp'] ?? '';

    $comboCount   = count(getCombosByCharId($pdo, $charId));
    $frameCount   = count(getFrameDataByCharId($pdo, $charId));
    $punishCount  = count(getPunishableFramesByCharId($pdo, $charId));
    $matchupRow   = getMatchupByCharId($pdo, $charId);
    $guideCount   = count(getMatchupGuidesByCharId($pdo, $charId));

    $rows[] = [
        'slug'    => $slug,
        'name'    => $nameJp,
        'combo'   => $comboCount,
        'frame'   => $frameCount,
        'punish'  => $punishCount,
        'matchup' => $matchupRow ? '○' : '×',
        'guides'  => $guideCount,
    ];
}

// --- move_type別の内訳チェック（?char=luke のように指定。省略時は luke） ---
$checkSlug = $_GET['char'] ?? 'luke';
$checkChar = getCharacterBySlug($pdo, $checkSlug);
$moveTypeBreakdown = [];
$frameSample = [];
if ($checkChar) {
    $frameRows = getFrameDataByCharId($pdo, $checkChar['id']);
    foreach ($frameRows as $f) {
        $type = $f['move_type'] ?? '(未設定)';
        $moveTypeBreakdown[$type] = ($moveTypeBreakdown[$type] ?? 0) + 1;
    }
    $frameSample = $frameRows;
}
$expectedTypes = ['normal_moves', 'unique_attacks', 'special_moves', 'super_arts', 'throws', 'common_moves'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>データ充足状況チェック</title>
<style>
  body { font-family: sans-serif; background:#14181A; color:#E7E5DE; padding: 24px; }
  h1 { font-size: 18px; margin-bottom: 4px; }
  p.note { color:#8E968F; font-size: 13px; margin-bottom: 20px; }
  table { border-collapse: collapse; width: 100%; max-width: 900px; font-size: 13px; }
  th, td { border: 1px solid #2B3230; padding: 8px 12px; text-align: left; }
  th { background: #1D2325; }
  td.num { text-align: right; font-family: monospace; }
  td.zero { color: #E2585B; font-weight: bold; }
  td.ok { color: #4E9F6E; }
  textarea { width: 100%; max-width: 900px; height: 200px; margin-top: 24px; font-family: monospace; font-size: 12px; background:#1D2325; color:#E7E5DE; border:1px solid #2B3230; padding:10px; }
</style>
</head>
<body>

<h1>キャラクター別データ充足状況（全<?php echo count($rows); ?>キャラ）</h1>
<p class="note">combo/frame/punishが0件（赤字）のキャラは、まだデータ未整備の可能性があります。確認が終わったら db-check.php は削除してください。</p>

<table>
  <thead>
    <tr>
      <th>char_slug</th>
      <th>名前</th>
      <th>コンボ数</th>
      <th>フレームデータ数</th>
      <th>確定反撃数</th>
      <th>matchup総評</th>
      <th>対策コラム数</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?php echo htmlspecialchars($r['slug'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($r['name'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td class="num <?php echo $r['combo'] === 0 ? 'zero' : 'ok'; ?>"><?php echo $r['combo']; ?></td>
        <td class="num <?php echo $r['frame'] === 0 ? 'zero' : 'ok'; ?>"><?php echo $r['frame']; ?></td>
        <td class="num <?php echo $r['punish'] === 0 ? 'zero' : 'ok'; ?>"><?php echo $r['punish']; ?></td>
        <td><?php echo $r['matchup']; ?></td>
        <td class="num <?php echo $r['guides'] === 0 ? 'zero' : 'ok'; ?>"><?php echo $r['guides']; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<h3 style="margin-top:24px; font-size:14px;">コピー用テキスト（チャットにそのまま貼り付けられます）</h3>
<textarea readonly onclick="this.select()"><?php
echo "slug\tname\tcombo\tframe\tpunish\tmatchup\tguides\n";
foreach ($rows as $r) {
    echo "{$r['slug']}\t{$r['name']}\t{$r['combo']}\t{$r['frame']}\t{$r['punish']}\t{$r['matchup']}\t{$r['guides']}\n";
}
?></textarea>

<hr style="margin:36px 0; border-color:#2B3230;">

<h1>フレームデータ内訳チェック：<?php echo htmlspecialchars($checkChar['name_jp'] ?? $checkSlug, ENT_QUOTES, 'UTF-8'); ?></h1>
<p class="note">URLの末尾に <code>?char=キャラのslug</code> を付けると対象キャラを変更できます（例: <code>db-check.php?char=gouki</code>）。</p>

<?php if (!$checkChar): ?>
  <p style="color:#E2585B;">指定した char_slug「<?php echo htmlspecialchars($checkSlug, ENT_QUOTES, 'UTF-8'); ?>」が見つかりませんでした。</p>
<?php else: ?>
  <table style="max-width:500px;">
    <thead><tr><th>move_type</th><th>件数</th><th>判定</th></tr></thead>
    <tbody>
      <?php foreach ($expectedTypes as $type): ?>
        <?php $cnt = $moveTypeBreakdown[$type] ?? 0; ?>
        <tr>
          <td><?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8'); ?></td>
          <td class="num <?php echo $cnt === 0 ? 'zero' : 'ok'; ?>"><?php echo $cnt; ?></td>
          <td><?php echo $cnt === 0 ? '⚠️ データなし' : '✅'; ?></td>
        </tr>
      <?php endforeach; ?>
      <?php
        // 想定外の move_type 値が入っていないか（ENUM外の値が紛れていないかの検査）
        $unexpected = array_diff_key($moveTypeBreakdown, array_flip($expectedTypes));
      ?>
      <?php foreach ($unexpected as $type => $cnt): ?>
        <tr>
          <td><?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8'); ?></td>
          <td class="num zero"><?php echo $cnt; ?></td>
          <td>⚠️ 想定外の move_type 値</td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h3 style="margin-top:24px; font-size:14px;">技名一覧（<?php echo count($frameSample); ?>件・move_type順）</h3>
  <table>
    <thead><tr><th>move_type</th><th>技名</th><th>コマンド</th><th>発生</th><th>ガード時</th></tr></thead>
    <tbody>
      <?php foreach ($frameSample as $f): ?>
        <tr>
          <td><?php echo htmlspecialchars($f['move_type'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?php echo htmlspecialchars($f['move_name_jp'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?php echo htmlspecialchars($f['command'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?php echo htmlspecialchars($f['startup'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?php echo htmlspecialchars($f['guard_adv'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h3 style="margin-top:24px; font-size:14px;">コピー用テキスト（技名一覧）</h3>
  <textarea readonly onclick="this.select()"><?php
    echo "move_type\tmove_name_jp\tcommand\tstartup\tguard_adv\n";
    foreach ($frameSample as $f) {
        echo ($f['move_type'] ?? '') . "\t" . ($f['move_name_jp'] ?? '') . "\t" . ($f['command'] ?? '') . "\t" . ($f['startup'] ?? '') . "\t" . ($f['guard_adv'] ?? '') . "\n";
    }
  ?></textarea>
<?php endif; ?>

</body>
</html>
