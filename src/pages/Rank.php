<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rank</title>
    <meta name="description" content="sample text sample text sample text sample text">
    <?php include_once(__DIR__ . '/../partials/head.php'); ?>
    <link rel="stylesheet" href="../css/Rank.css">
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
                    <h2>ランクマッチについて</h2>
                    <p>ここでは、ランクマッチのシステムと各ランク帯でのアドバイスをまとめています。</p>
                    <p>アドバイスはランクの階級(システム)が変わるごとに分けています。</p>
                    <nav class="section-nav">
                        <span class="nav-label">セクション一覧</span>
                        <ul>
                            <li><a href="#section1">・初めに</a></li>
                            <li><a href="#section2">・ゴールド以下</a></li>
                            <li><a href="#section3">・プラチナ~ダイヤモンド</a></li>
                            <li><a href="#section4">・マスター以上</a></li>
                        </ul>
                    </nav>
                </section>

                <section class="beginning" id="section1">
                    <h2>初めに</h2>
                    <div>
                        <h3>ランクマッチのシステム</h3>
                        <img class="content-img" src="../img/rank/system-certification.png" alt="認定システム画像">
                        <h4>【認定マッチ】</h4>
                        <p>
                            ランクマッチを始めるにあたって、適切なランクからスタートできるよう、<strong>各キャラクターごとに認定マッチを10戦</strong>行います。<br>
                            一体目のキャラクターでランクを始めるときは、CPUとの対戦から始まります。<br>
                            二体目以降でランクを始めるときは、ほかのキャラクターのランクが少し参照された形でランクがつきます。<br>
                            例えば、一体のキャラクターをマスターに到達していると二体目のキャラクターからは、最低でもダイヤモンド☆１からスタートになります。<br>
                        </p>
                        <img class="content-img" src="../img/rank/system-rank.png" alt="階級システム画像">
                        <h4>【リーグ】</h4>
                        <p>
                            階級は<strong>ルーキー</strong>から<strong>マスター</strong>までの8リーグがあり、各リーグには5段階の☆ランクが設けられています。<br>
                            さらに、マスターの上位500人には<strong>レジェンド</strong>という称号が付与されます。
                        </p>
                        <h5>リーグごとの特徴</h5>
                        <ul>
                            <li>
                                <strong>Rookie（ルーキー）</strong><br>
                                ・連勝ボーナス：あり<br>
                                ・敗北時のLP減少：なし
                            </li>
                            <li>
                                <strong>Iron（アイアン）～Gold（ゴールド）</strong><br>
                                ・連勝ボーナス：あり<br>
                                ・下位リーグへの降格：なし<br>
                                ・ランク降格保護：あり
                            </li>
                            <li>
                                <strong>Platinum（プラチナ）～Diamond（ダイヤモンド）</strong><br>
                                ・連勝ボーナス：なし<br>
                                ・下位リーグへの降格：あり<br>
                                ・ランク降格保護：あり
                            </li>
                            <li>
                                <strong>Master（マスター）</strong><br>
                                ・連勝ボーナス：なし<br>
                                ・下位リーグへの降格：なし<br>
                                ・マスターランク（MR）が付与される
                            </li>
                        </ul>
                        <h5>用語解説</h5>
                        <dl>
                            <dt><strong>連勝ボーナス</strong></dt>
                            <dd>3連勝すると+50LPが加算され、以降10連勝まで+50ずつ追加。最大で+400LPが追加される。</dd>

                            <dt><strong>下位リーグへの降格</strong></dt>
                            <dd>現在のリーグから一つ下のリーグへ落ちること。例：プラチナからゴールドには降格するが、ゴールドからシルバーには降格しない。</dd>

                            <dt><strong>ランク降格保護</strong></dt>
                            <dd>敗北してLPが0を下回っても、1度だけそのランクの最下位で踏みとどまる。再度敗北するとランクが1段階降格する。</dd>
                        </dl>
                        <div>
                            <h4>ランクの分布</h4>
                            <?php include_once(__DIR__ . '/../partials/rank-table.php'); ?>
                </section>

                <div id="advice-container"></div>
            </div>
            <?php include_once(__DIR__ . '/../partials/right.php'); ?>
        </div>
    </div>
    <?php include_once(__DIR__ . '/../partials/footer.php'); ?>
    <?php include_once(__DIR__ . '/../partials/javascript.php'); ?>
    <script src="../js/rank.js"></script>
</body>

</html>