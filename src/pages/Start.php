<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start</title>
    <meta name="description" content="sample text sample text sample text sample text">
    <?php include_once(__DIR__ . '/../partials/head.php'); ?>
    <link rel="stylesheet" href="../css/Start.css">
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
                    <h2>これから始める人向け</h2>
                    <nav class="section-nav">
                        <span class="nav-label">セクション一覧</span>
                        <ul>
                            <li><a href="#section1"><span>1.</span>カプコンIDの作成</a></li>
                            <li><a href="#section2"><span>2.</span>始め方・ホームUI解説</a></li>
                            <li><a href="#section3"><span>3.</span>チュートリアル解説</a></li>
                            <li><a href="#section4"><span>4.</span>プレイ画面UI解説</a></li>
                        </ul>
                    </nav>
                </section>

                <section class="id" id="section1">
                    <h2>カプコンIDの作成</h2>
                    <p>カプコンIDは、ストリートファイター６をプレイするうえで必ず必要になります。<br>
                        ですがカプコン公式サイトから無料で登録できるので安心してください。<br>
                        登録していない人は以下を参考にしてください</p>
                    <img class="content-img" src="../img/start/capcom-id.jpg" alt="カプコンID作成画面">
                    <p>ストリートファイター６を始めるときカプコンIDを持っていないまたは連携していない人はこのような画面が出てきます。</p>
                    <h3>カプコンIDの作成についてはこちら</h3>
                    <p>「CAPCOM IDの作成」については、CAPCOM IDのウェブサイト作成はこちら<a href="https://cid.capcom.com/ja/">CAPCOM ID公式</a>の右上にある「ログイン」ボタンを押し、表示されるウィンドウで「ユーザー登録」をクリックすることで作成が可能です。</p>
                    <h3>カプコンIDのアカウント連携についてはこちら</h3>
                    <p>「CAPCOM IDと各プラットフォームのアカウントの連携」については、<a href="https://cid.capcom.com/ja/guide/">CAPCOM IDサポートページ</a>の「外部アカウント連携について」をご覧ください。</p>
                </section>

                <section class="get-started" id="section2">
                    <h2>始め方(UI紹介)</h2>
                    <div class="chapter">
                        <h3>開いたすぐの画面</h3>
                        <img class="content-img" src="../img/start/start.jpg" alt="スタート画面">
                        <p><span class="speace"></span>開くとこのような画面が出てきて<strong>クリック</strong>や<strong>Enter</strong>、<strong>〇ボタン</strong>、<strong>決定</strong>などを押すと次の画面に進みます。</p>
                        <div><a class="alignment" href="#section3">チュートリアルの説明に移動</a></div>
                    </div>
                    <div class="chapter">
                        <h3>三つ選択する場面</h3>
                        <img class="content-img" src="../img/start/mode-choice.jpg" alt="ゲームモード選択画面">
                        <p>
                            次の場面はこの<strong>三つから選ぶ画面</strong>です。左から
                            <span class="speace"></span><strong>ストーリー</strong><strong>アーケード</strong><strong>ファイティンググラウンド</strong>モードです。<br>
                            <span class="speace"></span>今回は一番右の <strong>ファイティンググラウンドモード</strong>について説明していきたいと思います。
                        </p>
                        <h4>ファイティンググラウンド(一番右)</h4>
                        <img class="content-img" src="../img/start/fighting-ground.jpg" alt="ファイティンググラウンド">
                        <p>
                            ここでは、 <strong>トレーニングモード</strong>やオンラインの <strong>ランクマッチ</strong>や <br><span class="alignment"><strong>カジュアルマッチ</strong>、 <strong>フレンドとの対戦</strong>ルームがプレイ可能です。</span>
                            <br>
                            またこの画面からすぐに <strong>トレーニングモード</strong>にも<strong></strong>キーボードの <strong>「R」</strong>コントローラーの <strong>「✖」</strong>から行けます。<br>
                            初めてこの画面を開いたときチュートリアルに飛ばされるかもしれません。
                        </p>
                        <div><a class="alignment" href="#section3">チュートリアルの説明に移動</a></div>
                    </div>
                    <div class="chapter">
                        <h3>5つから選択する場面</h3>
                        <p>主にプレイするモードは<strong><span class="glyphicon glyphicon-star" aria-hidden="true"></strong></span>がついている２つ目の<strong>「PRACTICE」</strong>と５つ目の<strong>「ONLINE」</strong>というモードです。</p>
                        <div class="paragraph">
                            <h4>「ARCADE」</h4>
                            <img class="content-img" src="../img/start/arcade.jpg" alt="アーケード画面">
                            <p>簡単なストーリーになぞってコンピュータと連続で対戦する事の出来るモードです。</p>
                        </div>
                        <div class="paragraph">
                            <h4><span class="glyphicon glyphicon-star" aria-hidden="true"></span>「PRACTICE」</h4>
                            <img class="content-img" src="../img/start/practice.jpg" alt="プラクティス画面">
                            <P>上から<strong>トレーニングモード</strong>、<strong>チュートリアル</strong>、<strong>キャラクターガイド </strong>、<strong>コンボトライアル</strong>の4種類のモードが遊べます。</P>
                            <h5>モード種類</h5>
                            <h6>トレーニングモード</h6>
                            <p>動かないBOTにコンボの練習をしたり、BOTに特定の行動をレコードさせて対応の練習をしたりします。</p>
                            <h6>チュートリアル</h6>
                            <p>初めにやったチュートリアルをもう一度行うことができます。もし最初に飛ばしてしまった人がやっておくことをお勧めします。</p>
                            <h6>キャラクターガイド</h6>
                            <p>すべてのキャラクターについて簡単に解説があります。</p>
                            <h6>コンボトライアル</h6>
                            <p>すべてのキャラクターコンボが初級から上級までまとまっていますが実践的ではないものもあります。なのでコンボトライアルではコンボパーツを知ったりコンボ中のコマンドの練習をしたりするのがおすすめです。<br>自分が実際に使ったコンボはこちらから<a href="./Combo.html">コンボ紹介ページ</a></p>
                        </div>
                        <div class="paragraph">
                            <h4>「VERSUS」</h4>
                            <img class="content-img" src="../img/start/versus.jpg" alt="バーサス画面">
                            <p>ここでは、オフラインの対戦やコンピュータとの対戦ができます。いきなり対人戦に行くのは躊躇するという方はコンピュータ戦をやるのをお勧めします。</p>
                        </div>
                        <div class="paragraph">
                            <h4>「SPECIAL MATCH」</h4>
                            <img class="content-img" src="../img/start/special-match.jpg" alt="スペシャルマッチ画面">
                            <p>ここでは、エクストラバトルと言って簡単に言えばミニゲーム対戦ができるモードになっています。</p>
                        </div>
                        <div class="paragraph">
                            <h4><span class="glyphicon glyphicon-star" aria-hidden="true"></span>「ONLINE」</h4>
                            <img class="content-img" src="../img/start/online.jpg" alt="オンライン画像">
                            <p>ここでは、3種のオンラインプレイが可能なモードです。上からランクマッチ、カジュアルマッチ、カスタムルームがあります。</p>
                            <h5>モード種類</h5>
                            <h6>ランクマッチ</h6>
                            <p>キャラクターごとにランクが付与され最初に10戦認定戦をしてビギナーからダイヤまでのランクに振り分けられます。<br>マスターまではLP(リーグポイント)という形式でランクをあてされて全国のプレイヤーと競います。</p>
                            <h6>カジュアルマッチ</h6>
                            <p>ランクを気にせず自分と実力が近いオンラインの相手と戦うことができます。</p>
                            <h6>カスタムルーム</h6>
                            <p>フレンドとプレイするためのルームが使えるモードです。</p>
                        </div>
                        <div>
                            <div>
                                <h4>右上</h4>
                                <img class="content-img" src="../img/start/method.jpg" alt="設定方法画像">
                                <p>
                                    <span class="speace">右上は <strong>「R」「✖」</strong>で開くことができオンラインで使う <strong>キャラクター</strong>や<strong>操作タイプ</strong>、<strong>対戦相手の通信状況</strong>などのオンラインマッチでの設定ができます。<br>
                                        詳しい設定はこちらの <a href="Option.html">設定紹介</a>をご覧ください。
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="tutorial" id="section3">
                    <h2>チュートリアル</h2>
                    <h3>すべて解説している動画</h3>
                    <div class="video"><iframe width="560" height="315" src="https://www.youtube.com/embed/R6vFRv-SpbM?si=MDPptHX0mCC3Mr1S" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>
                    <div class="center">クリックで難易度変更</div>
                    <div id="tutorial"></div>
                </section>

                <section class="ui" id="section4">
                    <h2>プレイ画面UI</h2>
                    <div>
                        <img class="content-img" src="../img/start/battle-ui.jpg" alt="バトルUI画像">
                        <div>
                            <strong><span class="color1"><span>①</span>タイマー</span></strong>
                            <p>ラウンドの残り時間を表します。99秒から始まり0になったら残り体力が多いほうがラウンドを取得します。</p>
                        </div>
                        <div>
                            <strong><span class="color2"><span>②</span>体力ゲージ</span></strong>
                            <p>自信と相手の体力ゲージを表します。 <br>基本のキャラクターは体力が10000ですが少し高かったり低かったりするキャラもいます。</p>
                        </div>
                        <div>
                            <strong><span class="color3"><span>③</span>体力ゲージ(25%以下)</span></strong>
                            <p>体力ゲージが25％を切るとゲージの色が黄色になります。</p>
                        </div>
                        <div>
                            <strong><span class="color4"><span>④</span>ドライブゲージ</span></strong>
                            <p>ドライブゲージはSF6において様々なアクションを強化やパリィ、インパクトを使用するために消費します。 <br>ゲージがなくなるとバーンアウト状態になりゲージを使う行動ができなくなりその状態でインパクトを受け壁に当たるとスタン状態になります。</p>
                        </div>
                        <div>
                            <strong><span class="color5"><span>⑤</span>ラウンド数</span></strong>
                            <p>現在のラウンド取得数を表示してます。アイコンの種類は、ラウンドの勝ち方を示しています。</p>
                        </div>
                        <div>
                            <strong><span class="color6"><span>⑥</span>キャラクターアイコン</span></strong>
                            <p>使用しているキャラクターを示しています。</p>
                        </div>
                        <div>
                            <strong><span class="color7"><span>⑦</span>操作タイプ</span></strong>
                            <p>使用している操作タイプ(C＝クラシック、M＝モダン)を示しています。</p>
                        </div>
                        <div>
                            <strong><span class="color8"><span>⑧</span>SA(スーパーアーツ)ゲージ</span></strong>
                            <p>ゲージは1～3あり数が増えるほど強力な必殺技を使うことができます。自分が攻撃したり相手に攻撃された時に少しずつたまっていきます。</p>
                        </div>
                        <div>
                            <strong><span class="color9"><span>⑨</span>CA(クリティカルアーツ)</span></strong>
                            <p>体力ゲージが25％を切りSA3がたまっている時にSA3の火力や性質が変わります。</p>
                        </div>
                        <div>
                            <strong><span class="color10"><span>⑩</span>キャラクター属性アイコン</span></strong>
                            <p>SF6では固有の能力を使うキャラは初期キャラクターで以下の8キャラいます。<br>
                                その能力の残数がここに表示されます。
                            </p>
                            <div class="unique">
                                <div>ジェイミー(酔いレベル)<div class="unique-img"><img width="100px" src="../img/character/jamie_ss02.jpg" alt="ジェイミー画像"><img src="../img/unique/jamie.png" alt="酔いレベル画像"></div>
                                </div>
                                <div>マノン(メダルレベル)<div class="unique-img"><img width="100px" src="../img/character/manon_ss02.jpg" alt="マノン画像"><img src="../img/unique/manon.png" alt="メダルレベル画像"></div>
                                </div>
                            </div>
                            <div class="unique">
                                <div>キンバリー(手裏剣ストック)<div class="unique-img"><img width="100px" src="../img/character/kimberly_ss02.jpg" alt="キンバリー画像"><img src="../img/unique/kimberly.png" alt="手裏剣ストック画像"></div>
                                </div>
                                <div>リリー(風纏い)<div class="unique-img"><img width="100px" src="../img/character/lily_ss02.jpg" alt="リリー画像"><img src="../img/unique/lily.png" alt="風纏い画像"></div>
                                </div>
                            </div>
                            <div class="unique">
                                <div>ジュリ(風破ストック)<div class="unique-img"><img width="100px" src="../img/character/juri_ss02.jpg" alt="ジュリ画像"><img src="../img/unique/juri.png" alt="風波ストック画像"></div>
                                </div>
                                <div>リュウ(電刃錬気)<div class="unique-img"><img width="100px" src="../img/character/ryu_ss02.jpg" alt="リュウ画像"><img src="../img/unique/ryu.png" alt="電刃錬気"></div>
                                </div>
                            </div>
                            <div class="unique">
                                <div>ホンダ(肩屋入り)<div class="unique-img"><img width="100px" src="../img/character/ehonda_ss02.jpg" alt="エドモンド本田画像"><img src="../img/unique/ehonda.png" alt="肩屋入り画像"></div>
                                </div>
                                <div>ブランカ(ブランカちゃん爆弾)<div class="unique-img"><img width="100px" src="../img/character/blanka_ss02.jpg" alt="ブランカ画像"><img src="../img/unique/blanka.png" alt="ブランカちゃん爆弾画像"></div>
                                </div>
                            </div>
                            <p>各キャラクターの詳しい固有能力はこちらをご覧ください。→<a href="./Combo.html#list">コンボ(キャラクター一覧)</a></p>
                        </div>
                    </div>
                </section>
            </div>
            <?php include_once(__DIR__ . '/../partials/right.php'); ?>
        </div>
    </div>
    <?php include_once(__DIR__ . '/../partials/footer.php'); ?>
    <?php include_once(__DIR__ . '/../partials/javascript.php'); ?>
    <script src="../js/start.js"></script>
</body>

</html>