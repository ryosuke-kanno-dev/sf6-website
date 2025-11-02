<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>training</title>
    <meta name="description" content="sample text sample text sample text sample text">
    <?php include_once(__DIR__ . '/../partials/head.php'); ?>
    <link rel="stylesheet" href="../css/training.css">
</head>

<body>
    <?php include_once(__DIR__ . '/../partials/header.php'); ?>
    <?php include_once(__DIR__ . '/../partials/head-content.php'); ?>
    <div class="main-content">
        <?php include_once(__DIR__ . '/../partials/prologue.php'); ?>
        <div class="ad-728x90"><img src="https://placehold.jp/728x90.png" alt="広告"></div>
        <div class="main">
            <?php include_once(__DIR__ . '/../partials/left.php'); ?>
            <div class="mid">
                <?php include_once(__DIR__ . '/../partials/article-header.php'); ?>
                <section class="section-intro">
                    <h2>トレーニング</h2>
                    <p>ここでは、トレーニングモードのレコード機能を使った練習をまとめています。</p>
                    <nav class="section-nav">
                        <span class="nav-label">セクション一覧</span>
                        <div class="training-nav"></div>
                    </nav>
                </section>

                <div id="training-container"></div>
            </div>
            <?php include_once(__DIR__ . '/../partials/right.php'); ?>
        </div>
    </div>
    <?php include_once(__DIR__ . '/../partials/footer.php'); ?>
    <?php include_once(__DIR__ . '/../partials/javascript.php'); ?>
    <script src="../js/training.js"></script>
</body>

</html>