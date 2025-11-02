<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>main-Conbo</title>
    <meta name="description" content="sample text sample text sample text sample text">
    <?php include_once(__DIR__ . '/../partials/head.php'); ?>
    <link rel="stylesheet" href="../css/Combo.css">
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
                <div class="section-intro">
                    <h2>全キャラC用コンボ</h2>
                    <div class="combo-box"><span>屈強P</span>><span>中フラッシュナックル</span><span class="sub">ジャスト</span>><span>弱フラッシュナックル</span><span class="sub">ジャスト</span>><span>強フラッシュナックル</span><span class="sub">ジャスト</span></div>
                    <p>
                        ここで紹介しているコンボは自分が使っていた時のとりあえずこれというあまり難しくないコンボをまとめています。
                        アップデートを重ねなのでもっと簡単なコンボや火力が高いコンボなどがあると思いますが了承ください。
                        自分はここに記載されているコンボを使いすべてのキャラクターマスターランクに到達しました。
                        サブキャラクターを使いたい・触りたい人にはすごくお勧めできます。
                    </p>
                    <div class="character-table character-table-mid"></div>
                </div>
                <div class="ad"><img class="main-img" src="https://placehold.jp/336x280.png" alt="広告"></div>
                <div id="conbo"></div>
            </div>
            <div class="right">
                <img class="ad-right" src="https://placehold.jp/300x250.png" alt="広告">
                <img class="ad-right" src="https://placehold.jp/300x600.png" alt="広告">
                <div class="right-table sticky">
                    <div class="character-table"></div>
                </div>
                <div class="right-table sticky sticky-secod">
                    <div class="list right-table-contents">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once(__DIR__ . '/../partials/footer.php'); ?>
    <?php include_once(__DIR__ . '/../partials/javascript.php'); ?>
    <script src="../js/combo.js"></script>
</body>

</html>