<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main-Top</title>
    <meta name="description" content="sample text sample text sample text sample text">
    <?php include_once(__DIR__ . '/../partials/head.php'); ?>
    <link rel="stylesheet" href="../css/Main-Top.css">
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
                    <h2>ストリートファイター６<br>これから始める人向け(初心者)</h2>
                    <nav class="section-nav">
                        <span class="nav-label">セクション一覧</span>
                        <ul>
                            <li><a href="#section1"><span>1.</span>概要</a></li>
                            <li><a href="#section2"><span>2.</span>デバイス紹介</a></li>
                            <li><a href="#section3"><span>3.</span>操作タイプ</a></li>
                            <li><a href="#section4"><span>4.</span>キャラクター</a></li>
                        </ul>
                    </nav>
                </section>
                <div class="ad"><img class="main-img" src="https://placehold.jp/300x250.png" alt="広告"></div>
                <section class="basic" id="section1">
                    <h2>概要</h2>
                    <img class="content-img" src="../img/official/wallpaper.jpg" alt="SF6背景画像">
                    <p><strong>『ストリートファイター6』 </strong><br>ストリートファイターシックス、STREET FIGHTER 6、略称『スト6』は、カプコンから2023年6月2日に発売された <strong>対戦型格闘ゲーム</strong>です。<br>
                        対応プラットフォームは、PlayStation 4、PlayStation 5、Xbox Series X/S、Steamがあります。 <br>
                        またタイトーより、アーケード版 『ストリートファイター6 タイプアーケード』も稼動開始しました。<br>
                        <a class="alignment" href="https://sf6wiki.com/" target="_blank" rel="noopener noreferrer">(wikpedia)</a>
                    </p>
                    <div class="outline-table">
                        <table>
                            <tr class="head">
                                <th>概要一覧</th>
                            </tr>
                            <tr>
                                <th>タイトル</th>
                                <td>ストリートファイター６</td>
                            </tr>
                            <tr>
                                <th>メーカー</th>
                                <td>CAPCOM</td>
                            </tr>
                            <tr>
                                <th>ジャンル</th>
                                <td>対戦型格闘ゲーム、 アクションゲーム<br> コンピュータRPG、 アドベンチャーゲーム<br> Adventure</td>
                            </tr>
                            <tr>
                                <th>プラット <br>フォーム</th>
                                <td>PlayStation 5、 PlayStation 4、 アーケードゲーム<br> Xbox Series X/S、 GeForce Now、 Microsoft<br> Windows</td>
                            </tr>
                            <tr>
                                <th>発売日</th>
                                <td>2023年6月2日(金)</td>
                            </tr>
                            <tr>
                                <th>価格</th>
                                <td>価格:¥ 7,990</td>
                            </tr>
                            <tr>
                                <th>公式サイト</th>
                                <td><a href="https://www.streetfighter.com/6/" target="_blank" rel="noopener noreferrer">https://www.streetfighter.com/6/</a></td>
                            </tr>
                            <tr>
                                <th>公式Twitter</th>
                                <td><a href="https://twitter.com/StreetFighterJA" target="_blank" rel="noopener noreferrer">https://twitter.com/StreetFighterJA</a></td>
                            </tr>
                            <tr>
                                <th>デザイナー</th>
                                <td>橋本 祐介</td>
                            </tr>
                        </table>
                    </div>
                </section>
                <div class="ad"><img class="main-img" src="https://placehold.jp/300x250.png" alt="広告"></div>
                <section class="device" id="section2">
                    <h2>デバイス紹介</h2>
                    <img class="content-img" src="../img/device/device-summary.jpg" alt="デバイスまとめ画像">
                    <div id="device-list"></div>
                </section>
                <div class="ad"><img class="main-img" src="https://placehold.jp/300x250.png" alt="広告"></div>
                <section class="type" id="section3">
                    <h2>操作タイプ</h2>
                    <img class="content-img" src="../img/operation/operation-list.png" alt="操作タイプ一覧画像">
                    <div class="list" data-section="type">
                        <span class="list-label"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>目次</span>
                        <ul>
                            <li><a href="#operation1"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>(C)クラシック</a></li>
                            <li><a href="#operation2"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>(M)モダン</a></li>
                            <li><a href="#operation3"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>(D)ダイナミック</a></li>
                        </ul>
                    </div>
                    <div>
                        <div id="operation1">
                            <h3>(C)クラシック<img height="30px" src="../img/operation/classic-cut.jpg" alt="クラシック画像"></h3>
                            <div class="features">
                                <img height="100px" src="../img/operation/classic-simple.png" alt="クラシック画像">
                                <span class="glyphicon glyphicon-play" aria-hidden="true"></span>特徴<br>
                                ・従来のプレイ体験<br>
                                ・コマンド操作が必要<br>
                                ・初心者には難しい<br>
                                ・プロや超上級者の大半が使用<br>
                            </div>
                            <h5>公式紹介文</h5>
                            <p>従来のシリーズ同様の操作形態。<br>
                                繊細な操作が求められるハイレベルなバトルで有効だ。自由にコマンドを設定できるボタンもあり、闘い方に幅を持たせることもできる。
                            </p>
                        </div>
                        <div id="operation2">
                            <h3>(M)モダン<img height="30px" src="../img/operation/modern-cut.jpg" alt="モダン画像"></h3>
                            <div class="features">
                                <img height="100px" src="../img/operation/modern-simple.png" alt="モダン画像">
                                <span class="glyphicon glyphicon-play" aria-hidden="true"></span>特徴<br>
                                ・初心者におすすめ<br>
                                ・プロでも使用者がいる<br>
                                ・コマンドやコンボがワンボタンで出すことができる<br>
                            </div>
                            <h5>公式紹介文</h5>
                            <p>方向キーと1ボタンの組み合わせで華麗なバトルができる。<br>
                                コマンド入力を覚えることなく、バトルの醍醐味である読み合いを楽しもう。</p>
                        </div>
                        <div id="operation3">
                            <h3>(D)ダイナミック<img height="30px" src="../img/operation/dynamic-cut.jpg" alt="ダイナミック画像"></h3>
                            <div class="features">
                                <img height="100px" src="../img/operation/dynamic-simple.png" alt="ダイナミック画像">
                                <span class="glyphicon glyphicon-play" aria-hidden="true"></span>特徴<br>
                                ・オート攻撃が可能<br>
                                ・オフラインバトルの時のみ使用可能<br>
                            </div>
                            <h5>公式紹介文</h5>
                            <p>家族や友人と手軽にバトルする時や、初めて使用するキャラクターの基本的な動きを確認したり色んなキャラクターを試してみる時におすすめだ。<br>
                                ※Fighting Groundの一部モード専用の操作タイプです。<br>
                                ※オンラインプレイでは使用できません。<br>
                                ※オート攻撃以外の操作も可能です。</p>
                        </div>
                    </div>
                </section>
                <div class="ad"><img class="main-img" src="https://placehold.jp/300x250.png" alt="広告"></div>
                <section class="character" id="section4">
                    <h2>キャラクター</h2>
                    <h3>キャラクター選びについて</h3>
                    <p class="text">使うキャラクターを選ぶときは見た目や環境キャラランク、公式キャラクター診断、とりあえず触ってみた感じなどで決めてしまってよいと思います。</p>
                    <a class="alignment" href="https://www.streetfighter.com/6/contents/characterquiz/ja-jp/" target="_blank" rel="noopener noreferrer">公式キャラクター診断</a>
                    <h3>初期キャラクター</h3>
                    <div class="paragraph">
                        <img class="content-img" src="../img/official/initial-character.jpg" alt="初期キャラクター一覧画像">
                        <p>SF6で最初からいるキャラクターはおなじみのリュウやケン、パッケージキャラクターのルークを加えSF6から参戦のキャラクター６キャラ合わせて１８キャラクターがいます。</p>
                        <a class="alignment" href="https://www.streetfighter.com/6/ja-jp/character" target="_blank" rel="noopener noreferrer">公式キャラクター紹介</a>
                    </div>
                    <h3>追加キャラクター</h3>
                    <p>追加キャラクターは一年ごとに4キャラ追加されyearパスまたは単体でキャラクターを購入すると使うことができます。</p>
                    <p>yearパスは￥3,000で単体でキャラクターを買おうとすると約￥700で×４体で￥2800ですが購入クレジット上の関係で結局全キャラ買おうとするとyearパスのほうが安く済みます。</p>
                    <div id="character-years"></div>
                </section>
            </div>
            <?php include_once(__DIR__ . '/../partials/right.php'); ?>
        </div>
    </div>
    <?php include_once(__DIR__ . '/../partials/footer.php'); ?>
    <?php include_once(__DIR__ . '/../partials/javascript.php'); ?>
    <script src="../js/main-top.js"></script>
</body>

</html>