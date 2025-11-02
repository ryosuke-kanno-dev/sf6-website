<?php
$pdo = new PDO('mysql:host=localhost;dbname=sf6;charset=utf8mb4', 'root', '');

// 簡易パスワード（超シンプル認証）
$admin_pass = "mysecret"; 
session_start();
if (!isset($_SESSION['login'])) {
    if ($_POST['pass'] ?? '' === $admin_pass) {
        $_SESSION['login'] = true;
    } else {
        echo '<form method="post"><input type="password" name="pass"><button>ログイン</button></form>';
        exit;
    }
}

// 新規追加
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['slug'], $_POST['content'])) {
    if ($_POST['content'] !== '') {
        $stmt = $pdo->prepare("INSERT INTO strategies (slug, content) VALUES (?, ?)");
        $stmt->execute([$_POST['slug'], $_POST['content']]);
    }
}

// キャラ一覧（JSON読み込み）
$characters = json_decode(file_get_contents(__DIR__ . "/../data/character.json"), true);

// 表示用
$slug = $_GET['slug'] ?? $characters[0]['slug'];
$stmt = $pdo->prepare("SELECT * FROM strategies WHERE slug = ? ORDER BY created_at DESC");
$stmt->execute([$slug]);
$strategies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>キャラ対策編集 (<?= htmlspecialchars($slug) ?>)</h1>

<form method="post">
    <select name="slug">
        <?php foreach ($characters as $c): ?>
            <option value="<?= $c['slug'] ?>" <?= $c['slug']===$slug?'selected':'' ?>>
                <?= htmlspecialchars($c['jp']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <textarea name="content" rows="3" cols="40" placeholder="立ち回りや対策を入力"></textarea><br>
    <button type="submit">追加</button>
</form>

<ul>
    <?php foreach ($strategies as $s): ?>
        <li><?= nl2br(htmlspecialchars($s['content'])) ?> (<?= $s['created_at'] ?>)</li>
    <?php endforeach; ?>
</ul>
