<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Option</title>
    <meta name="description" content="sample text sample text sample text sample text">
    <?php include_once(__DIR__ . '/../partials/head.php'); ?>
    <link rel="stylesheet" href="../css/Option.css">
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
                    <h2>設定紹介</h2>
                    <nav class="section-nav">
                        <span class="nav-label">セクション一覧</span>
                        <ul>
                            <li><a href="#section1"><span>1.</span>オプション設定</a></li>
                            <li><a href="#section2"><span>2.</span>バトル設定</a></li>
                            <li><a href="#section3"><span>3.</span>コントローラー設定</a></li>
                        </ul>
                    </nav>
                </section>
                <div class="ad"><img class="main-img" src="https://placehold.jp/300x250.png" alt="広告"></div>
                <section class="setting" id="section1">
                    <h2>オプション設定</h2>
                    <div class="list" data-section="setting">
                        <span class="list-label"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>目次</span>
                        <ul>
                            <li><a href="#setting1"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>設定方法</a></li>
                            <li><a href="#setting2"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>絶対に変えるべき設定(4つ)</a></li>
                            <li><a href="#setting3"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>その他変えるべき設定</a></li>
                        </ul>
                    </div>
                    <div id="setting1">
                        <h3>設定方法</h3>
                        <img class="content-img" src="../img/option/menu.jpg" alt="メニュー画面画像">
                        <p>この画面で<strong>「Esc」</strong>や <strong>「メニュー」</strong>を押すとマルチメニューの画面が出てきます。ここでは、プロフィール閲覧や自他のリプレイを見たりオプション設定が可能です。</p>
                        <img class="content-img" src="../img/option/menu-option.jpg" alt="オプション設定画面">
                        <p>今回はこのボタンから <strong>オプションの設定</strong>について説明していきます。</p>
                    </div>
                    <div id="setting2">
                        <h3>絶対に変えるべき設定(4つ)</h3>
                        <div>
                            <h4>1.GRAPHICから入力遅延の軽減をONにする</h4>
                            <img class="content-img" src="../img/option/changes-delayreduction.jpg" alt="遅延軽減設定画像">
                            <p>ですが入力遅延の減少をONにすると画像が乱れたりするケースがあるので自身の <strong>PCスペックやハード、モニターに応じてしてOFF</strong>にすることをお勧めします。</p>
                        </div>
                        <div>
                            <h4>2.GRAPHICからMAXフレームレートの変更</h4>
                            <img class="content-img" src="../img/option/changes-framerate.jpg" alt="フレームレート設定画像">
                            <p>特に <strong>制限がない人はMAXの120</strong>に、PCスペックやモニター、ハードの関係で120FPSが出ない人は<strong>出る限りのFPS</strong>にしておくことをお勧めします。</p>
                        </div>
                        <div>
                            <h4>3.AUDIOからSA・ドライブアクション発動SE音量を20にする</h4>
                            <img class="content-img" src="../img/option/changes-seaudio.jpg" alt="SE音量設定画像">
                            <p>この音量を上げておくと<strong>ドライブインパクトやスーパーアーツの音が聞きやすく</strong>返しやすくなる。</p>
                        </div>
                        <div>
                            <h4>4.CONTOLから、離し入力をOFF・ONにする</h4>
                            <img class="content-img" src="../img/option/changes-releaseinput.jpg" alt="離し入力設定画像">
                            <p>コマンドを入力するとき離す時にも入力をするかどうか。 <br>もしプレイしていて技が出ないと感じる人はONにしてみると技が出やすくなるかもしれません。ONでもOFFでも変わらない人は<strong>OFFがおすすめ</strong>です。</p>
                        </div>
                    </div>
                    <div id="setting3">
                        <h3>その他おすすめ設定</h3>
                        <p>その中でも対戦中に変わり変えておくべき設定は<span class="glyphicon glyphicon-star" aria-hidden="true"></span>がついているGRAPHICの設定です。<a href="#section1.4">GRAPHIC設定に飛ぶ</a></p>
                        <div>
                            <h4>GAME</h4>
                            <img class="content-img" src="../img/option/game.jpg" alt="ゲーム設定画像">
                            <p>GAMEでは、プレイ中の設定ではなくゲーム全体の設定やバトルHUBなどの設定が可能です。</p>
                            <h4>CONTOL</h4>
                            <img class="content-img" src="../img/option/contol.jpg" alt="コントローラー設定画像">
                            <img class="content-img" src="../img/option/contol-keyconfig.jpg" alt="キーコンフィグ設定画像">
                            <p>CONTOLでは、基本的に使う操作タイプやキーコンフィグ (ボタン割り当て)などを変更することが可能です。</p>
                            <h4>CAMERA</h4>
                            <img class="content-img" src="../img/option/camera.jpg" alt="カメラ設定画像">
                            <p>CAMERAでは、ストーリーモードやアーケードモードの時のキャラクターを追うカメラの設定ができます</p>
                            <h4>DISPLAY</h4>
                            <img class="content-img" src="../img/option/display.jpg" alt="ディスプレイ設定画像">
                            <p>DISPLAYでは、対戦中の<strong>揺れ</strong>や<strong>明るさ</strong>の調整が可能です。</p>
                            <h4>AUDIO</h4>
                            <img class="content-img" src="../img/option/audio-basic.jpg" alt="オーディオ設定画像">
                            <img class="content-img" src="../img/option/audio-detail.jpg" alt="オーディオ詳細設定画像">
                            <p>AUDIOでは、<strong>全体の音量</strong>や一つ一つの<strong>音量を細かく</strong>設定することが可能です。</p>
                            <h4 id="section1.4"><span class="glyphicon glyphicon-star" aria-hidden="true"></span>GRAPHIC</h4>
                            <img class="content-img" src="../img/option/graphic.jpg" alt="グラフィック設定画像">
                            <img class="content-img" src="../img/option/graphic-basic.jpg" alt="グラフィック基本設定画像">
                            <img class="content-img" src="../img/option/graphic-detail.jpg" alt="グラフィック詳細設定画像">
                            <p>GRAPHICでは、<strong>解像度</strong>の設定や<strong>クオリティ</strong>の設定、<strong>フレームレート</strong>の設定などが可能です。</p>
                        </div>
                    </div>
                </section>
                <div class="ad"><img class="main-img" src="https://placehold.jp/300x250.png" alt="広告"></div>
                <section class="battle" id="section2">
                    <h2>バトル設定</h2>
                    <div class="list" data-section="battle">
                        <span class="list-label"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>目次</span>
                        <ul>
                            <li><a href="#battle1"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>設定方法</a></li>
                            <li><a href="#battle2"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>マッチング設定</a></li>
                            <li><a href="#battle3"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>キャラクター設定</a></li>
                            <li><a href="#battle4"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>その他</a></li>
                            <li><a href="#battle5"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>ファイタープロフィール設定</a></li>
                        </ul>
                    </div>
                    <div id="battle1">
                        <h3>設定方法</h3>
                        <img class="content-img" src="../img/option/method.jpg" alt="設定方法画像">
                        <p class="text">キーボードの<strong>「R」</strong>やコントローラーの<strong>「✖」</strong>でバトル設定を開くことができます。</p>
                    </div>
                    <div id="battle2">
                        <h3>マッチング設定</h3>
                        <img class="content-img" src="../img/option/matching.jpg" alt="マッチング設定画像">
                        <h4>ここで変えたほうが良い設定は三つ</h4>
                        <h5>検索範囲</h5>
                        <p class="btext"><strong>狭い地域</strong><br>狭い地域にしておくと日本のプレイヤーとあたりラグが少なくなる</p>
                        <h5>通信状態</h5>
                        <p class="btext"><strong>４～５</strong><br>相手の通信状況を指定することができる４～５にしておくとラグを感じにくい</p>
                        <h5>対戦相手確認</h5>
                        <p class="btext"><strong>ON</strong><br>対戦相手が決まった時に相手の通信状況を見ることができるのでONがおすすめ</p>
                    </div>
                    <div id="battle3">
                        <h3>キャラクター設定</h3>
                        <img class="content-img" src="../img/option/character.jpg" alt="キャラクター設定画像">
                        <p class="text">
                            <strong>カジュアルマッチやランクマッチなどで使用するキャラクターの設定</strong><br>
                            その他にもキャラクターごとの操作タイプや操作設定、称号設定、乱入カスタマイズが可能。
                        </p>
                    </div>
                    <div id="battle4">
                        <h3>その他の設定</h3>
                        <img class="content-img" src="../img/option/others.jpg" alt="その他設定画像">
                        <h4>ステージ設定</h4>
                        <p><span class="speace"></span>特にこだわりがないのであれば <strong>トレーニングルーム</strong>をお勧めします。<br></p>
                        <h4>対戦相手のコスチューム設定</h4>
                        <p><span class="speace"></span>相手キャラクターのコスチュームが見ずらいという時に <strong>相手のコスチュームを固定</strong>することができます。</p>
                        <h4>バトルBGM設定</h4>
                        <p><span class="speace"></span>バトル中のBGMを設定することができます。「T」を押すとキャラクターごとにBGMを細かく設定できます。 </p>
                        <h4>実況設定</h4>
                        <p><span class="speace"></span><strong>実況者や解説者の設定</strong>、ほとんどの人が切っている。ONにすることでゲージの管理などをしている人もいます。</p>
                        <h4>サイド設定サイド設定</h4>
                        <p><span class="speace"></span><strong>１P側か２P側どちらからスタート</strong>するかを決められます。相手も同じ設定をしていたらランダムになります。</p>
                    </div>
                    <div id="battle5">
                        <h3>ファイタープロフィール設定</h3>
                        <img class="content-img" src="../img/option/profile.jpg" alt="ファイタープロフィール設定画像">
                        <p class="text">
                            フレンドIDなどが載っているプロフィールを好きにカスタマイズすることができます。
                        </p>
                    </div>
                </section>
                <div class="ad"><img class="main-img" src="https://placehold.jp/300x250.png" alt="広告"></div>
                <section class="controller" id="section3">
                    <h2>コントローラー設定</h2>
                    <p>
                        OPTIONの中のCONTOLからコントローラーの操作設定が可能です。<br>
                        おすすめの設定を記載していますがやっていくうちに自分に合った設定にしていくのがいいと思います。
                    </p>
                    <div class="list" data-section="controller">
                        <span class="list-label"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>目次</span>
                        <ul>
                            <li><a href="#controller1"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>ゲームパッド</a></li>
                            <li><a href="#controller2"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>キーボード</a></li>
                            <li><a href="#controller3"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>アーケードコントローラー</a></li>
                        </ul>
                    </div>
                    <div id="controller1">
                        <h3>ゲームパッド</h3>
                        <h4>モダン</h4>
                        <img class="content-img" src="../img/keyconfig/modern-pad.jpg" alt="キーコンフィグ画像(モダン・パッド)">
                        <h4>クラシック</h4>
                        <img class="content-img" src="../img/keyconfig/classic-pad.jpg" alt="キーコンフィグ画像(クラシック・パッド)">
                    </div>
                    <div id="controller2">
                        <h3>キーボード</h3>
                        <h4>モダン</h4>
                        <img class="content-img" src="../img/keyconfig/modern-keyboard.jpg" alt="キーコンフィグ画像(モダン・キーボード)">
                        <h4>クラシック</h4>
                        <img class="content-img" src="../img/keyconfig/classic-keyboard.jpg" alt="キーコンフィグ画像(クラシック・キーボード)">
                    </div>
                    <div id="controller3">
                        <h3>アーケードコントローラー</h3>
                        <h4>モダン</h4>
                        <img class="content-img" src="../img/keyconfig/modern-leverless.jpg" alt="キーコンフィグ画像(モダン・レバーレス)">
                        <h4>クラシック</h4>
                        <img class="content-img" src="../img/keyconfig/classic-leverless.jpg" alt="キーコンフィグ画像(クラシック・レバーレス)">
                    </div>
                </section>
            </div>
            <?php include_once(__DIR__ . '/../partials/right.php'); ?>
        </div>
    </div>
    <?php include_once(__DIR__ . '/../partials/footer.php'); ?>
    <?php include_once(__DIR__ . '/../partials/javascript.php'); ?>
</body>

</html>