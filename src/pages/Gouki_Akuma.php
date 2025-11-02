<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gouki_Akuma</title>
    <meta name="description" content="sample text sample text sample text sample text">
    <?php include_once(__DIR__ . '/../partials/head.php'); ?>
    <link rel="stylesheet" href="../css/Gouki_Akuma.css">
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
                    <h2>豪鬼まとめ</h2>
                    <p>ここでは、自分のメインキャラ豪鬼についてまとめたサイトになります。</p>
                    <nav class="section-nav">
                        <span class="nav-label">セクション一覧</span>
                        <ul>
                            <li><a href="#section1">強み・弱み</a></li>
                            <li><a href="#section2">立ち回り</a></li>
                            <li><a href="#section3">リーサル判断</a></li>
                            <li><a href="#section4">コンボ集</a></li>
                            <li><a href="#section5">起き攻め</a></li>
                            <li><a href="#section6">セットアップ</a></li>
                            <li><a href="#section7">キャラ対策</a></li>
                            <li><a href="#section8">フレームデータ</a></li>
                        </ul>
                    </nav>
                    <div class="card">
                        <div class="card-head">豪鬼メモ</div>
                        <span class="note"></span>
                    </div>
                </div>

                <section class="analysis" id="section1">
                    <h2>強み・弱み</h2>
                    <div class="traits-container">
                        <div class="strengths-wrapper">
                            <div class="gradient-bar strengths-bar"></div>
                            <div class="strengths scrollable">
                                <div class="strengths-head">強み</div>
                                <ul>
                                    <li>機動力が非常に高い(前歩き・後ろ歩き共にすべての <br>キャラクターでトップクラス)</li>
                                    <li>飛び道具が優秀
                                        <ul>
                                            <li>弾速・全体フレーム・ガード時フレームがリュウの波動拳より優れる</li>
                                            <li>溜め対応でジャストパリィ対策がされにくい</li>
                                            <li>阿修羅閃空派生の「朧」と択になっている</li>
                                            <li>コンボパーツとしても実用的</li>
                                        </ul>
                                    </li>
                                    <li>運びが優秀</li>
                                    <li>対空が豊富でダメージ・状況が優秀
                                        <ul>
                                            <li>対空豪昇龍拳からSA3をキャンセルできる</li>
                                            <li>強昇龍拳は横リーチが長く対策が困難</li>
                                            <li>OD昇龍拳は三段でスーパーアーマーを貫通</li>
                                            <li>対空の斬空、SA1(天魔豪斬空)などリターンが大きい</li>
                                        </ul>
                                    </li>
                                    <li>画面端コンボ火力が非常に高い（OD金剛灼火やSA2）</li>
                                    <li>安定した起き攻めに繋がる技が豊富</li>
                                    <li>大差がついた展開での「捨てゲー行動」が強力
                                        <ul>
                                            <li>立ち強K：+3Fの突進技</li>
                                            <li>天魔空刃脚・百鬼襲：昇龍対空釣り</li>
                                            <li>瞬獄殺によるラウンドリーサル</li>
                                            <li>昇龍キャンセルSA3の逆択</li>
                                        </ul>
                                    </li>
                                    <li>弱技全般のリーチが長く、確反性能が高い</li>
                                    <li>中攻撃の性能が全体的に優秀</li>
                                    <li>強攻撃はリターンが高く確認しやすい</li>
                                    <li>プロでも使用者が多く、動画や解説を探しやすい</li>
                                </ul>
                            </div>
                        </div>
                        <div class="weaknesses-wrapper">
                            <div class="gradient-bar weaknesses-bar"></div>
                            <div class="weaknesses scrollable">
                                <div class="weaknesses-head">弱み</div>
                                <ul>
                                    <li>体力が9000で全体的に被ダメージリスクが高い</li>
                                    <li>画面中央での火力が並みで攻め継続もやや難しい
                                        <ul>
                                            <li>竜巻斬空脚がしゃがみに当たらない</li>
                                            <li>豪昇龍拳や金剛灼火は起き攻めに使いにくい</li>
                                            <li>投げからの起き攻めが不可</li>
                                            <li>投げ(パニカン)でも起き攻めが難しい</li>
                                        </ul>
                                    </li>
                                    <li>SA1の発生がやや遅く切り返しに不安</li>
                                    <li>中央でのSA2はヒットしてもリターンがとりにくい</li>
                                    <li>位置入れ替えコンボが少なく画面端脱出が難しい</li>
                                    <li>ドライブラッシュの後半速度が遅め</li>
                                    <li>高ランク帯では対策・慣れられている可能性あり</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="movement" id="section2">
                    <h2>立ち回り</h2>
                    <div class="move">
                        <h3>立ち回りで振る技</h3>
                        波動拳について
                        立弱P=カウンターで立弱Kに派生してコンボ
                        無敵のないキャラにはラッシュから連ガを作らない例:無敵あり=屈中K(ラッシュ)＞弱P 無敵なし=屈中K(ラッシュ)＞中P
                        百鬼襲 昇竜拳をすかせるくらいのところでKに派生する
                        相手の弾をガードしたら次の弾までに前ステやSA2を回しておく
                    </div>
                    <h3>距離別の攻め時と守り時</h3>
                    <div class="section-move">
                        <h4>遠距離</h4>
                        <div class="row">
                            <div class="column attack">
                                <div class="move-head">攻め時</div>
                                <ul>
                                    <li>Dゲージがある時はこの距離に居てもしょうがない</li>
                                    <li>相手が固有ゲージ持ち（ジュリ、リリーなど）の時は近づくべき</li>
                                    <li>弱波動や斬空と共に近づく</li>
                                </ul>
                            </div>
                            <div class="column defense">
                                <div class="move-head">守り時</div>
                                <ul>
                                    <li>Dゲージを回復させたい時は弱波動や強波動で距離を維持</li>
                                    <li>弾ガードで相手のDゲージ回復を遅らせる</li>
                                    <li>端同士なら弾抜けをあまり警戒しなくてよい</li>
                                    <li>下がりすぎず斬空で画面押すのもアリ</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="section-move">
                        <h4>中距離</h4>
                        <div class="row">
                            <div class="column attack">
                                <div class="move-head">攻め時</div>
                                <ul>
                                    <li>奇襲できるが、安定はどっしり構える</li>
                                    <li>波動拳を回して主導権を握る（対空意識）</li>
                                    <li>弾・前中Kで固める</li>
                                    <li>インパクト狙いに注意、逆に釣りたい</li>
                                    <li>立ち強Kは+2Fだが、しゃがみに当たらない</li>
                                    <li>固まった相手に前ステ投げ・ラッシュ・阿修羅→朧など</li>
                                    <li>百鬼は相手の弾を見て使い分け</li>
                                    <li>弱百鬼→着地で様子見、意識を揺さぶる</li>
                                    <li>百鬼への反応が鈍ったら百鬼Pで有利を取る</li>
                                </ul>
                            </div>
                            <div class="column defense">
                                <div class="move-head">守り時</div>
                                <ul>
                                    <li>低体力なので差し合いは不利になりやすい</li>
                                    <li>置き技合戦は運ゲー＋低体力で不利</li>
                                    <li>置き技は2中P、攻めには中足</li>
                                    <li>仕込みは中央→ラッシュ、相手側→OD灼火</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="section-move">
                        <h4>近距離</h4>
                        <div class="row">
                            <div class="column attack">
                                <div class="move-head">攻め時</div>
                                <ul>
                                    <li>立ち中Pガードで+1F、有利なので使いやすい</li>
                                    <li>端付近：しゃがみ中P×2→OD灼火で画面端へ</li>
                                    <li>端での固め：立ち中P（+1F）、OD波動（+2F）、百鬼P（+4F）</li>
                                </ul>
                            </div>
                            <div class="column defense">
                                <div class="move-head">守り時</div>
                                <ul>
                                    <li>暴れるならしゃがみ弱P</li>
                                    <li>カウンター確認できるならしゃがみ中Pでコンボ</li>
                                    <li>確認しないなら：しゃがみ弱P×2→立ち弱K→強昇龍</li>
                                    <li>強昇龍→OD波動ならさらに距離を離せてターンを取れる</li>
                                    <li>後ろ阿修羅は無敵なし。バクステや後ろジャンプ推奨</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="lethal" id="section3">
                    <h2>リーサル判断</h2>

                    <div class="combo-card">
                        <div class="combo-head">空対空</div>
                        <div class="combo-box2"><span>J中P</span>＞<span>OD斬空波動拳</span>＞<span>OD百鬼襲</span>＞<span>百鬼豪斬空</span>＞<span>生ラッシュ</span>＞<span>屈強P</span>＞<span>キャンセルラッシュ</span>＞<span>引強K</span>＞<span>弱豪波動拳</span><span class="sub">Lv2</span>＞<span>中竜巻斬空脚</span>＞<span>弱豪昇龍拳</span>＞<span>SA3</span></div>
                    </div>
                    <div class="combo-cord">
                        <h3>インパクト後ノーゲージ火力</h3>
                        <div class="combo-box2"><span>屈強P</span>＞<span>弱竜巻斬空脚</span>＞<span>強豪昇龍拳</span></div>
                    </div>
                    <div class="combo-card">
                        <h3>強灼火パニカン始動画面端CA最大</h3>
                        <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈大P</span>＞<span>OD灼火</span>＞<span>引強K</span>＞<span>OD百鬼襲</span>＞<span>百鬼豪斬空</span>＞<span>DR</span>＞<span>中P(CR)</span>＞<span>引強K</span>＞<span>豪波動拳(Lv2)</span>＞<span>中竜巻斬空脚</span>＞<span>弱豪昇龍拳</span>＞<span>SA3</span></div>
                        <div class="Situation">
                            <div class="ALL"><img src="../img/Gouki/Lethal/強灼火パニカン始動画面端CA最大/ALL.png" alt="リーサル場面画像"></div>
                            <div class="INFO">
                                ・ダメージ合計: <br>
                                <img src="../img/Gouki/Lethal/強灼火パニカン始動画面端CA最大/HP.png" alt="強灼火パニカン始動画面端CA最大-hp"><br>
                                ・SAゲージ増加量： <br>
                                <img src="../img/Gouki/Lethal/強灼火パニカン始動画面端CA最大/SA.png" alt="強灼火パニカン始動画面端CA最大-sa"> <br>
                                ・始動可能ドライブゲージ:約5本 <br>
                                <img src="../img/Gouki/Lethal/強灼火パニカン始動画面端CA最大/D.png" alt="強灼火パニカン始動画面端CA最大-ca"> <br>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="combos" id="section4">
                    <h2>始動別コンボ集</h2>
                    <div class="list" data-section="combos">
                        <ul>
                            <li><strong><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>始動技一覧</strong></li>
                            <li class="list-span"><span class="glyphicon glyphicon-play" aria-hidden="true"></span><a href="#Little">弱技始動</a></li>
                            <li class="list-span"><span class="glyphicon glyphicon-play" aria-hidden="true"></span><a href="#Medium">中技始動</a></li>
                            <li class="list-span"><span class="glyphicon glyphicon-play" aria-hidden="true"></span><a href="#Strong">強技始動</a></li>
                            <li class="list-span"><span class="glyphicon glyphicon-play" aria-hidden="true"></span><a href="#Junp">ジャンプ技始動</a></li>
                            <li class="list-span"><span class="glyphicon glyphicon-play" aria-hidden="true"></span><a href="#Special">特殊技始動</a></li>
                            <li class="list-span"><span class="glyphicon glyphicon-play" aria-hidden="true"></span><a href="#Impact">インパクト始動</a></li>
                            <li class="list-span"><span class="glyphicon glyphicon-play" aria-hidden="true"></span><a href="#Syakuka">強灼火パニカン始動</a></li>
                            <li class="list-span"><span class="glyphicon glyphicon-play" aria-hidden="true"></span><a href="#Tenma">天魔空刃脚始動</a></li>
                            <li class="list-span"><span class="glyphicon glyphicon-play" aria-hidden="true"></span><a href="#Zankuu">斬空波動拳始動</a></li>
                            <li class="list-span"><span class="glyphicon glyphicon-play" aria-hidden="true"></span><a href="#ODSyakuka">画面端OD灼火後</a></li>
                            <li class="list-span"><span class="glyphicon glyphicon-play" aria-hidden="true"></span><a href="#SA2">画面端SA2後</a></li>
                            <li class="list-span"><span class="glyphicon glyphicon-play" aria-hidden="true"></span><a href="#Others">その他始動</a></li>
                        </ul>
                    </div>
                    <!--
                        <div class="combo-box2"><span></span>＞<span></span>＞<span></span></div>
                        <div class="combo-tree">
                            <span class="label title">始動技</span>
                            <div class="tree">
                                <div class="node">
                                    <span class="label hit">通常ヒット</span>
                                    <div class="tree">
                                        <div class="node">
                                            <span class="label state">立ち状態</span>
                                            <div class="combo-box2"><span></span>＞<span></span>＞<span></span></div>
                                        </div>
                                        <div class="node">
                                            <span class="label state">しゃがみ状態</span>
                                            <div class="combo-box2"><span></span>＞<span></span>＞<span></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="node">
                                    <span class="label counter">カウンター</span>
                                    <div class="combo-box2"><span></span>＞<span></span>＞<span></span></div>
                                </div>
                                <div class="node">
                                    <span class="label punish">パニカン</span>
                                    <div class="combo-box2"><span></span>＞<span></span>＞<span></span></div>
                                </div>
                            </div>
                        </div>
                        中Pタゲコンからは弱灼火=微歩き投げで暴れにも負けなそう
                        <div id="始動技">
                            <h3>始動</h3>
                            <div class="combo-card">
                                <div class="combo-head"></div>
                                <div class="combo-box2"><span></span>＞<span></span>＞<span></span></div>
                                <div class="Damabe">ダメージ:</div>
                                <div class="Dgauge">Dゲージ:</div>
                                <div class="SAgauge">SAゲージ:</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                        </div>
                        -->
                    <div id="Little">
                        <h3>弱技始動</h3>
                        <div class="combo-card">
                            <div class="combo-head"></div>
                            <div class="combo-box2"><span></span>＞<span></span>＞<span></span></div>
                            <div class="Damabe">ダメージ:</div>
                            <div class="Dgauge">Dゲージ:</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment">場面:</div>
                        </div>
                    </div>
                    <div id="Medium">
                        <h3>中技始動</h3>
                        <div class="combo-card">
                            <div class="combo-head"></div>
                            <div class="combo-box2"><span></span>＞<span></span>＞<span></span></div>
                            <div class="Damabe">ダメージ:</div>
                            <div class="Dgauge">Dゲージ:</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment">場面:</div>
                        </div>
                    </div>
                    <div id="Strong">
                        <h3>強技始動</h3>
                        <div class="combo-card">
                            <div class="combo-head"></div>
                            <div class="combo-box2"><span></span>＞<span></span>＞<span></span></div>
                            <div class="Damabe">ダメージ:</div>
                            <div class="Dgauge">Dゲージ:</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment">場面:</div>
                        </div>
                    </div>
                    <div id="Junp">
                        <h3>ジャンプ技始動</h3>
                        <div class="combo-card">
                            <div class="combo-head"></div>
                            <div class="combo-box2"><span></span>＞<span></span>＞<span></span></div>
                            <div class="Damabe">ダメージ:</div>
                            <div class="Dgauge">Dゲージ:</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment">場面:</div>
                        </div>
                    </div>
                    <div id="Special">
                        <h3>特殊技技始動</h3>
                        <div class="combo-card">
                            <div class="combo-head"></div>
                            <div class="combo-box2"><span></span>＞<span></span>＞<span></span></div>
                            <div class="Damabe">ダメージ:</div>
                            <div class="Dgauge">Dゲージ:</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment">場面:</div>
                        </div>
                    </div>
                    <!--
                        <div id="Impact">
                            <h3>インパクト始動</h3>
                            <div class="combo-card">
                                <div class="combo-head">ノーゲージ運び</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>前ステ</span><span class="sub">×2</span>＞<span>屈強P</span>＞<span>強竜巻斬空脚</span></div>
                                <div class="Damabe">ダメージ:2800</div>
                                <div class="Dgauge">Dゲージ:0本</div>
                                <div class="SAgauge">SAゲージ0本</div>
                                <div class="Movie"></div>
                                <div class="Coment">Dゲージに余裕がなく画面端に到達できる場合使用する。</div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">1ゲージ運び</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>前ステ</span>＞<span>引強K</span>＞<span>弱豪波動拳</span>＞<span>生ラッシュ</span>＞<span>立強P</span>＞<span>中竜巻斬空脚</span>＞<span>(弱豪昇龍拳)</span></div>
                                <div class="Damabe">ダメージ:2918(3193)</div>
                                <div class="Dgauge">Dゲージ:1本</div>
                                <div class="SAgauge">SAゲージ:0本</div>
                                <div class="Movie"></div>
                                <div class="Scene">場面:初期位置くらい</div>
                                <div class="Coment">画面端に到達できれば弱豪昇龍拳が入るので画面端に到達できるのなら使用する。</div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">2ゲージ運び</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>前ステ</span><span class="sub">×2</span>＞<span>屈強P</span>＞<span>OD竜巻斬空脚</span>＞<span>強竜巻斬空脚</span></div>
                                <div class="Damabe">ダメージ:3340</div>
                                <div class="Dgauge">Dゲージ:2本</div>
                                <div class="SAgauge">SAゲージ:0本</div>
                                <div class="Movie"></div>
                                <div class="Coment">ゲージに余裕がある場合使用する。基本的にはこのコンボ。</div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">1ゲージ/ダメージ</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>屈強P</span>＞<span>弱竜巻斬空脚</span>＞<span>強豪昇龍拳</span></div>
                                <div class="Damabe">ダメージ:2850</div>
                                <div class="Dgauge">Dゲージ:0.1~1本</div>
                                <div class="SAgauge">SAゲージ:0本</div>
                                <div class="Movie"></div>
                                <div class="Coment">リーサルが取れる場面やダメージ調節。</div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">2ゲージ/ダメージ</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>前ステ</span>＞<span>屈強P</span>＞<span>OD竜巻斬空脚</span>＞<span>強竜巻斬空脚</span></div>
                                <div class="Damabe">ダメージ:3340</div>
                                <div class="Dgauge">Dゲージ:1.1~2.9本</div>
                                <div class="SAgauge">SAゲージ:0本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">3ゲージ/ダメージ</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>前ステ</span>＞<span>屈強P</span>＞<span>OD竜巻斬空脚</span>＞<span>OD豪昇龍拳</span></div>
                                <div class="Damabe">ダメージ:3400</div>
                                <div class="Dgauge">Dゲージ:3~3.9本</div>
                                <div class="SAgauge">SAゲージ:0本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">4ゲージ/ダメージ</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P</span>＞<span>強竜巻斬空脚</span></div>
                                <div class="Damabe">ダメージ:3653</div>
                                <div class="Dgauge">Dゲージ:4~6本</div>
                                <div class="SAgauge">SAゲージ:0本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA1/1ゲージ</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>引強K</span>＞<span>弱豪波動拳</span>＞<span>SA1</span></div>
                                <div class="Damabe">ダメージ:3410</div>
                                <div class="Dgauge">Dゲージ:0.1~1本</div>
                                <div class="SAgauge">SAゲージ:0.6本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA1/2ゲージ</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>前ステ</span>＞<span>屈強P</span>＞<span>OD強灼火</span>＞<span>SA1</span></div>
                                <div class="Damabe">ダメージ:3690</div>
                                <div class="Dgauge">Dゲージ:1.1~3.9本</div>
                                <div class="SAgauge">SAゲージ:0.5本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA1/最大</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P</span>＞<span>弱竜巻斬空脚</span>＞<span>SA1</span></div>
                                <div class="Damabe">ダメージ:4063</div>
                                <div class="Dgauge">Dゲージ:4~6本</div>
                                <div class="SAgauge">SAゲージ:0.1本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA2/1ゲージ</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>屈強P</span>＞<span>SA2</span></div>
                                <div class="Damabe">ダメージ:3640</div>
                                <div class="Dgauge">Dゲージ:0.1~1本</div>
                                <div class="SAgauge">SAゲージ:1.7本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA2/1.1ゲージ</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>屈強P</span>＞<span>OD灼火</span>＞<span>SA2</span></div>
                                <div class="Damabe">ダメージ:3990</div>
                                <div class="Dgauge">Dゲージ:1.1~2</div>
                                <div class="SAgauge">SAゲージ:1.5本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA2/2ゲージ</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>前ステ</span>＞<span>引強K</span>＞<span>弱豪波動拳</span>＞<span>ドライブラッシュ</span>＞<span>立強P</span>＞<span>OD灼火</span>＞<span>SA2</span></div>
                                <div class="Damabe">ダメージ:4150</div>
                                <div class="Dgauge">Dゲージ:2~3.9本</div>
                                <div class="SAgauge">SAゲージ:1.4本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA2/最大</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P</span>＞<span>弱竜巻斬空脚</span>＞<span>SA2</span></div>
                                <div class="Damabe">ダメージ:4523</div>
                                <div class="Dgauge">Dゲージ:4~6本</div>
                                <div class="SAgauge">SAゲージ:1.1本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA3/1ゲージ</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>屈強P</span>＞<span>強灼火</span>＞<span>SA3</span></div>
                                <div class="Damabe">ダメージ:4670(4920)</div>
                                <div class="Dgauge">Dゲージ:0.1~1本</div>
                                <div class="SAgauge">SAゲージ:2.6本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA3/2ゲージ</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P</span>＞<span>強灼火</span>＞<span>SA3</span></div>
                                <div class="Damabe">ダメージ:5193(5443)</div>
                                <div class="Dgauge">Dゲージ:1.1~3.9本</div>
                                <div class="SAgauge">SAゲージ:2.4本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA3/最大</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P</span>＞<span>強灼火</span>＞<span>SA3</span></div>
                                <div class="Damabe">ダメージ:5580(5830)</div>
                                <div class="Dgauge">Dゲージ:4~6本</div>
                                <div class="SAgauge">SAゲージ:2.1本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">CA/最大</div>
                                <div class="combo-box2"><span>インパクト</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P</span>＞<span>弱灼火</span>＞<span>瞬獄殺</span></div>
                                <div class="Damabe">ダメージ:5863</div>
                                <div class="Dgauge">Dゲージ:4~6本</div>
                                <div class="SAgauge">SAゲージ:2.1本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                        </div>-->
                    <div id="Syakuka">
                        <h3>強灼火パニカン始動</h3>
                        <table class="combo-table">
                            <thead>
                                <tr>
                                    <th colspan="6">ゲージごとコンボ</th>
                                </tr>
                                <tr>
                                    <th>コンボ種類</th>
                                    <th class="Carry">運び</th>
                                    <th class="Power" colspan="4">ダメージ</th>
                                </tr>
                                <tr>
                                    <th class="SA">SAゲージ</th>
                                    <th><a href="#Syakuka0Carry">0</a></th>
                                    <th>0</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="D">ドライブゲージ</td>
                                    <td><a href="#Syakuka0/0Carry">0</a><a href="#Syakuka0/1Carry">1</a></td>
                                    <td><a href="#Syakuka0/0Power">0</a><a href="#Syakuka0/3Power">3</a><a href="#Syakuka0/4Power">4</a><a href="#Syakuka0/6Power">6最大</a></td>
                                    <td><a href="#Syakuka1/0Power">0</a><a href="#Syakuka1/3Power">3</a><a href="#Syakuka1/3Power2">3</a><a href="#Syakuka1/6Power">6最大</a></td>
                                    <td><a href="#Syakuka2/0Power">0</a><a href="#Syakuka2/2Power">2</a><a href="#Syakuka2/6Power">6最大</a></td>
                                    <td><a href="#Syakuka0/0Power">3</a><a href="#Syakuka0/0Power">3</a><a href="#Syakuka0/0Power">3</a></td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="Syakuka0Carry" class="combo-card">
                            <div class="combo-head">運びコンボSAゲージなし</div>
                            <div id="Syakuka0/0Carry" class="combo-subcard">
                                <div class="combo-subhead">ノーゲージ</div>
                                <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈中P</span><span class="sub">×2</span>＞<span>弱竜巻斬空脚</span><span class="sub">微遅らせ</span>＞<span>中竜巻斬空脚</span></div>
                                <div class="flex">
                                    <div class="Damabe">ダメージ:3080</div>
                                    <div class="Dgauge">Dゲージ:0本</div>
                                    <div class="SAgauge">SAゲージ:0本</div>
                                </div>
                                <div class="Coment"></div>
                                <div class="Movie"></div>
                            </div>
                            <div id="Syakuka0/1Carry" class="combo-subcard">
                                <div class="combo-subhead">1ゲージ</div>
                                <div class="combo-box2"><span>強灼火(PC)</span>＞<span>引強K</span>＞<span>弱豪波動拳</span>＞<span>生ラッシュ</span>＞<span>立強P</span>＞<span>中竜巻斬空脚</span>＞<span>(弱豪昇龍拳)</span></div>
                                <div class="Damabe">ダメージ:2918(3193)</div>
                                <div class="Dgauge">Dゲージ:1本</div>
                                <div class="SAgauge">SAゲージ:0本</div>
                                <div class="Movie"></div>
                                <div class="Coment">場面:初期位置くらいで画面端に到達できれば弱豪昇龍拳が入るので画面端に到達できるのなら使用する。</div>
                            </div>
                        </div>
                        <div id="Syakuka0/0Power" class="combo-card">
                            <div class="combo-head">ノーゲージダメージ</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈強P</span>＞<span>弱竜巻斬空脚</span>＞<span>強豪昇龍拳</span></div>
                            <div class="Damabe">ダメージ:3360</div>
                            <div class="Dgauge">Dゲージ:0本</div>
                            <div class="SAgauge">SAゲージ:0本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="Syakuka0/3Power" class="combo-card">
                            <div class="combo-head">3ゲージ</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P</span>＞<span>強竜巻斬空脚</span></div>
                            <div class="Damabe">ダメージ:3871</div>
                            <div class="Dgauge">Dゲージ:0.1~0.5</div>
                            <div class="SAgauge">SAゲージ:0本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="Syakuka0/4Power" class="combo-card">
                            <div class="combo-head">4ゲージ</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>引強K</span>＞<span>弱豪波動拳</span>＞<span>生ラッシュ</span>＞<span>立強P(CR)</span>＞<span>屈強P</span><span class="sub">目押し</span>＞<span>強竜巻斬空脚</span></div>
                            <div class="Damabe">ダメージ:4043</div>
                            <div class="Dgauge">Dゲージ:0.6~2.5本</div>
                            <div class="SAgauge">SAゲージ:0本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="Syakuka0/6Power" class="combo-card">
                            <div class="combo-head">最大(6ゲージ)</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P</span>＞<span>強竜巻斬空脚</span></div>
                            <div class="Damabe">ダメージ:4385</div>
                            <div class="Dgauge">Dゲージ:2.6~6本</div>
                            <div class="SAgauge">SAゲージ:0本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="Syakuka1/0Power" class="combo-card">
                            <div class="combo-head">SA1/ノーゲージ</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>引強K</span>＞<span>弱豪波動拳</span>＞<span>SA1</span></div>
                            <div class="Damabe">ダメージ:3980</div>
                            <div class="Dgauge">Dゲージ:0本</div>
                            <div class="SAgauge">SAゲージ:0.8本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="Syakuka1/3Power" class="combo-card">
                            <div class="combo-head">SA1/3ゲージ</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P</span>＞<span>SA1</span></div>
                            <div class="Damabe">ダメージ:4177</div>
                            <div class="Dgauge">Dゲージ:0.1~0.5</div>
                            <div class="SAgauge">SAゲージ:0.7本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="Syakuka1/3Power2" class="combo-card">
                            <div class="combo-head">SA1/3ゲージ</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>引強K</span>＞<span>弱豪波動拳</span>＞<span>生ラッシュ</span>＞<span>立強P</span>＞<span>OD灼火</span>＞<span>SA1</span></div>
                            <div class="Damabe">ダメージ:4311</div>
                            <div class="Dgauge">Dゲージ:0.6~2.5本</div>
                            <div class="SAgauge">SAゲージ:0.6本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="Syakuka1/6Power" class="combo-card">
                            <div class="combo-head">SA1/最大(6ゲージ)</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P(CR)</span>＞<span>前強</span>＞<span>屈強P</span>＞<span>SA1</span></div>
                            <div class="Damabe">ダメージ:4589</div>
                            <div class="Dgauge">Dゲージ:2.6~6本</div>
                            <div class="SAgauge">SAゲージ:0.5本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="Syakuka2/0Power" class="combo-card">
                            <div class="combo-head">SA2/ノーゲージ</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈強P</span>＞<span>SA2</span></div>
                            <div class="Damabe">ダメージ:4220</div>
                            <div class="Dgauge">Dゲージ:0本</div>
                            <div class="SAgauge">SAゲージ:1.9本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="Syakuka2/2Power" class="combo-card">
                            <div class="combo-head">SA2/2ゲージ</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈強P</span>＞<span>OD灼火</span>＞<span>SA2</span></div>
                            <div class="Damabe">ダメージ:4710</div>
                            <div class="Dgauge">Dゲージ:0.1~2.5本</div>
                            <div class="SAgauge">SAゲージ:1.8本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="Syakuka2/6Power" class="combo-card">
                            <div class="combo-head">SA2/最大(6ゲージ)</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P</span>＞<span>弱竜巻斬空脚強</span>＞<span>SA2</span></div>
                            <div class="Damabe">ダメージ:5165</div>
                            <div class="Dgauge">Dゲージ:2.6~6本</div>
                            <div class="SAgauge">SAゲージ:1.4本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="Syakuka3/0Power" class="combo-card">
                            <div class="combo-head">SA3/ノーゲージ</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈強P</span>＞<span>SA3</span></div>
                            <div class="Damabe">ダメージ:5180(5580)</div>
                            <div class="Dgauge">Dゲージ:0本</div>
                            <div class="SAgauge">SAゲージ:2.9本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="SyakukaCA/0Power" class="combo-card">
                            <div class="combo-head">瞬獄殺/ノーゲージ</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>瞬獄殺</span></div>
                            <div class="Damabe">ダメージ:5780</div>
                            <div class="Dgauge">Dゲージ:0本</div>
                            <div class="SAgauge">SAゲージ:3本</div>
                            <div class="Movie"></div>
                            <div class="Coment">ドライブゲージがなくCAの時はこのコンボがいい。</div>
                        </div>
                        <div id="Syakuka3/3Power" class="combo-card">
                            <div class="combo-head">SA3/3ゲージ</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P</span>＞<span>強灼火</span>＞<span>SA3</span></div>
                            <div class="Damabe">ダメージ:5766(6016)</div>
                            <div class="Dgauge">Dゲージ:0.1~0.5本</div>
                            <div class="SAgauge">SAゲージ:2.6本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="Syakuka3/3Power2" class="combo-card">
                            <div class="combo-head">SA3/3ゲージ</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>引強K</span>＞<span>弱豪波動拳</span>＞<span>生ラッシュ</span>＞<span>立強P(CR)</span>＞<span>屈強P</span><span class="sub">目押し</span>＞<span>強灼火</span>＞<span>SA3</span></div>
                            <div class="Damabe">ダメージ:5953(6203)</div>
                            <div class="Dgauge">Dゲージ:0.6~2.5本</div>
                            <div class="SAgauge">SAゲージ:2.5本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="Syakuka3/6Power" class="combo-card">
                            <div class="combo-head">SA3/最大</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P</span>＞<span>強灼火</span>＞<span>SA3</span></div>
                            <div class="Damabe">ダメージ:6297(6547)</div>
                            <div class="Dgauge">Dゲージ:2.6~6本</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div id="SyakukaCA/6Power" class="combo-card">
                            <div class="combo-head">瞬獄殺/最大</div>
                            <div class="combo-box2"><span>強灼火(PC)</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P(CR)</span>＞<span>前強P</span>＞<span>屈強P</span>＞<span>弱灼火</span>＞<span>瞬獄殺</span></div>
                            <div class="Damabe">ダメージ:6554</div>
                            <div class="Dgauge">Dゲージ:2.6~6本</div>
                            <div class="SAgauge">SAゲージ:2.4本</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <h3>その他灼火始動</h3>
                        <div class="combo-card">
                            <div class="combo-head">弱灼火パニカン/中・強灼火カウンター</div>
                            <div class="combo-box2"><span>屈弱P</span>＞<span>立弱K</span>＞<span>〆</span></div>
                            <div class="Damabe">ダメージ:</div>
                            <div class="Dgauge">Dゲージ:</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">中・強灼火パニカン</div>
                            <div class="combo-box2"><span>屈強P</span>＞<span>〆</span></div>
                            <div class="Damabe">ダメージ:</div>
                            <div class="Dgauge">Dゲージ:</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment"></div>
                        </div>
                    </div>
                    <div id="Sky">
                        <h3>空対空始動</h3>
                        <div class="combo-card">
                            <div class="combo-head">ノーゲージ運び</div>
                            <div class="combo-box2"><span>ジャンプ中P</span>＞<span>強斬空波動拳</span>＞<span>中竜巻斬空脚</span></div>
                            <div class="Damabe">ダメージ:</div>
                            <div class="Dgauge">Dゲージ:</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment">場面:</div>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">1ゲージ運び</div>
                            <div class="combo-box2"><span>ジャンプ中P</span>＞<span>強斬空波動拳</span>＞<span>生ラッシュ</span>＞<span>立強P</span>＞<span>中竜巻斬空脚or強竜巻斬空脚</span></div>
                            <div class="Damabe">ダメージ:</div>
                            <div class="Dgauge">Dゲージ:</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment">場面:</div>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">2ゲージ運び(基本)</div>
                            <div class="combo-box2"><span>ジャンプ中P</span>＞<span>強斬空波動拳</span>＞<span>生ラッシュ</span>＞<span>引強K</span>＞<span>弱豪波動拳</span>＞<span>生ラッシュ</span>＞<span>立強P</span>＞<span>中竜巻斬空脚or強竜巻斬空脚</span></div>
                            <div class="Damabe">ダメージ:</div>
                            <div class="Dgauge">Dゲージ:</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment">場面:</div>
                        </div>
                    </div>
                    <div id="Tenma">
                        <h3>天魔空刃脚始動</h3>
                        <div class="combo-card">
                            <div class="combo-head">通常ヒット</div>
                            <div class="combo-head">屈弱P始動</div>
                            <div class="Damabe">ダメージ:</div>
                            <div class="Dgauge">Dゲージ:</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment">場面:</div>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">カウンター</div>
                            <div class="combo-head">頭上ヒット:屈弱P始動
                                足元ヒット:中Pタゲコン＞強竜巻斬空脚
                            </div>
                            <div class="Damabe">ダメージ:</div>
                            <div class="Dgauge">Dゲージ:</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment">場面:</div>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">パニカン</div>
                            <div class="combo-head">頭上ヒット:中Pタゲコン＞強竜巻斬空脚
                                足元ヒット:屈強P始動
                            </div>
                            <div class="Damabe">ダメージ:</div>
                            <div class="Dgauge">Dゲージ:</div>
                            <div class="SAgauge">SAゲージ:</div>
                            <div class="Movie"></div>
                            <div class="Coment">場面:</div>
                        </div>
                    </div>
                    <div id="Zankuu">
                        <h3>斬空波動拳始動</h3>
                        <div class="combo-card">
                            <div class="combo-head">ODノーゲージ</div>
                            <div class="combo-box2"><span>中竜巻斬空脚</span></div>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">OD+1ゲージ</div>
                            <div class="combo-box2"><span>生ラッシュ</span>＞<span>立中K</span>＞<span>立強K</span>＞<span>中・強竜巻斬空脚</span></div>
                        </div>
                        ODからラッシュ屈強P拾える？
                    </div>
                    <!--
                        <div id="ODSyakuka">
                            <h3>画面端OD灼火後コンボ</h3>
                            <div class="combo-card">
                                <div class="combo-head">2ゲージ/ダメージルート</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>屈強P</span>＞<span>弱豪波動拳</span>＞<span>強竜巻斬空脚</span></div>
                                <div class="Damabe">ダメージ:3110</div>
                                <div class="Dgauge">Dゲージ:0.1~2本</div>
                                <div class="SAgauge">SAゲージ:0本</div>
                                <div class="Movie"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">2ゲージ/起き攻めルート</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>屈強P</span>＞<span>中竜巻斬空脚</span>＞<span>弱豪昇龍拳</span></div>
                                <div class="Damabe">ダメージ:2930</div>
                                <div class="Dgauge">Dゲージ:0.1~2本</div>
                                <div class="SAgauge">SAゲージ:0本</div>
                                <div class="Movie"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">3.4ゲージ</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>屈強P</span>＞<span>OD竜巻斬空脚</span>＞<span>強竜巻斬空脚</span></div>
                                <div class="Damabe">ダメージ:3290</div>
                                <div class="Dgauge">Dゲージ:2.1~4本</div>
                                <div class="SAgauge">SAゲージ:0本</div>
                                <div class="Movie"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">5ゲージ</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>屈強P</span>＞<span>OD竜巻斬空脚</span>＞<span>OD豪昇龍拳</span></div>
                                <div class="Damabe">ダメージ:3340</div>
                                <div class="Dgauge">Dゲージ:4.1~5.7本</div>
                                <div class="SAgauge">SAゲージ:0本</div>
                                <div class="Movie"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">最大</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>屈強P</span>＞<span>OD百鬼襲</span>＞<span>百鬼豪斬空</span>＞<span>OD豪波動拳</span>＞<span>OD豪昇龍拳</span></div>
                                <div class="Damabe">ダメージ:3440</div>
                                <div class="Dgauge">Dゲージ:5.8~6本</div>
                                <div class="SAgauge">SAゲージ:0本</div>
                                <div class="Movie"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA1/2ゲージ</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>屈強P</span>＞<span>弱豪波動拳</span>＞<span>SA1</span></div>
                                <div class="Damabe">ダメージ:3410</div>
                                <div class="Dgauge">Dゲージ:0.1~2本</div>
                                <div class="SAgauge">SAゲージ:0.7本</div>
                                <div class="Movie"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA1/3ゲージ</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>引強K</span>＞<span>OD百鬼襲</span>＞<span>SA1(天魔豪斬空)</span>＞<span>強竜巻斬空脚</span></div>
                                <div class="Damabe">ダメージ:3740</div>
                                <div class="Dgauge">Dゲージ:2.1~3.9本</div>
                                <div class="SAgauge">SAゲージ:0.8本</div>
                                <div class="Movie"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA1/4ゲージ</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>OD百鬼襲</span>＞<span>百鬼豪斬空</span>＞<span>OD豪波動拳</span>＞<span>SA1</span></div>
                                <div class="Damabe">ダメージ:3520</div>
                                <div class="Dgauge">Dゲージ:4~5本</div>
                                <div class="SAgauge">SAゲージ:0.6本</div>
                                <div class="Movie"></div>
                                <div class="Coment">基本的には3本時の時の方が高いが補正値によりこっちのコンボの方が高くなる。</div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA1/最大</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>引強K</span>＞<span>OD百鬼襲</span>＞<span>百鬼豪斬空</span>＞<span>ドライブラッシュ</span>＞<span>中P</span><span class="sub">CR</span>＞<span>屈強P</span>＞<span>豪波動拳(Lv2)</span>＞<span>SA1</span></div>
                                <div class="Damabe">ダメージ:3828</div>
                                <div class="Dgauge">Dゲージ:5.1~6本</div>
                                <div class="SAgauge">SAゲージ:0.5本</div>
                                <div class="Movie"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA2/2ゲージ</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>SA2</span>＞<span>屈強P</span>＞<span>強竜巻斬空脚</span></div>
                                <div class="Damabe">ダメージ:3810</div>
                                <div class="Dgauge">Dゲージ:0.1~2本</div>
                                <div class="SAgauge">SAゲージ:1.9本</div>
                                <div class="Movie"></div>
                            </div>  
                            <div class="combo-card">
                                <div class="combo-head">SA2/3ゲージ</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>引強K</span>＞<span>弱豪波動拳</span><span class="sub">Lv2</span>＞<span>OD灼火</span>＞<span>SA2</span></div>
                                <div class="Damabe">ダメージ:4030</div>
                                <div class="Dgauge">Dゲージ:2.1~3.9本</div>
                                <div class="SAgauge">SAゲージ:1.6本</div>
                                <div class="Movie"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA2/4ゲージ</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>引強K</span>＞<span>OD豪波動拳</span><span class="sub">Lv3</span>＞<span>OD灼火</span>＞<span>SA2</span></div>
                                <div class="Damabe">ダメージ:4150</div>
                                <div class="Dgauge">Dゲージ:4~4.9本</div>
                                <div class="SAgauge">SAゲージ:1.6本</div>
                                <div class="Movie"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA2/5ゲージ</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>引強K</span>＞<span>OD百鬼襲</span>＞<span>百鬼豪斬空</span>＞<span>ドライブラッシュ</span>＞<span>中P</span><span class="sub">CR</span>＞<span>屈強P</span>＞<span>豪波動拳(Lv2)</span>＞<span>SA2</span></div>
                                <div class="Damabe">ダメージ:4288</div>
                                <div class="Dgauge">Dゲージ:5~本5.8本</div>
                                <div class="SAgauge">SAゲージ:1.5本</div>
                                <div class="Movie"></div>
                            </div>  
                            <div class="combo-card">
                                <div class="combo-head">SA2/最大</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>引強K</span>＞<span>OD百鬼襲</span>＞<span>百鬼豪斬空</span>＞<span>OD豪波動拳</span><span class="sub">微遅らせ</span>＞<span>OD灼火</span>＞<span>SA2</span></div>
                                <div class="Damabe">ダメージ:4330</div>
                                <div class="Dgauge">Dゲージ:5.9~6本</div>
                                <div class="SAgauge">SAゲージ:1.5本</div>
                                <div class="Movie"></div>
                                <div class="Coment">ゲージが最大でしか使用できないし微遅らせも必要なので使う場面はほぼない</div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA3/2ゲージ</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>屈強P</span>＞<span>中竜巻斬空脚</span>＞<span>弱豪昇龍拳</span></div>
                                <div class="Damabe">ダメージ:4930(5180)</div>
                                <div class="Dgauge">Dゲージ:0.1~2本</div>
                                <div class="SAgauge">SAゲージ:2.6本</div>
                                <div class="Movie"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA3/3ゲージ</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>引強K</span>＞<span>OD百鬼襲</span>＞<span>百鬼豪斬空</span>＞<span>中竜巻斬空脚</span>＞<span>弱豪昇龍拳</span>＞<span>SA3</span></div>
                                <div class="Damabe">ダメージ:5190(5440)</div>
                                <div class="Dgauge">Dゲージ:2.1~4</div>
                                <div class="SAgauge">SAゲージ:2.5本</div>
                                <div class="Movie"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA3/4~6</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>引強K</span>＞<span>OD百鬼襲</span>＞<span>百鬼豪斬空</span>＞<span>OD竜巻斬空脚</span>＞<span>弱豪昇龍拳</span>＞<span>SA3</span></div>
                                <div class="Damabe">ダメージ:5300(5550)</div>
                                <div class="Dgauge">Dゲージ:4.1~5</div>
                                <div class="SAgauge">SAゲージ:2.5本</div>
                                <div class="Movie"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA3/最大</div>
                                <div class="combo-box2"><span>OD灼火</span>＞<span>引強K</span>＞<span>OD百鬼襲</span>＞<span>百鬼豪斬空</span>＞<span>ドライブラッシュ</span>＞<span>中P</span><span class="sub">CR</span>＞<span>引強K</span>＞<span>豪波動拳(Lv2)</span>＞<span>中竜巻斬空脚</span>＞<span>SA3</span></div>
                                <div class="Damabe">ダメージ:5302(5552)</div>
                                <div class="Dgauge">Dゲージ:5.1~6</div>
                                <div class="SAgauge">SAゲージ:2.3本</div>
                                <div class="Movie"></div>
                                <div class="Coment">ダメージが2高いのとSAゲージ増加量がこっちの方が高いのでDゲージに余裕があるときはこっちのコンボを使用。</div>
                            </div>
                        </div>-->
                    <!--
                        <div id="SA2">
                            <h3>画面端SA2後コンボ・セットアップ</h3>
                            <div class="combo-card">
                                <div class="combo-head">ノーゲージ安定(詐欺飛び)</div>
                                <div class="combo-box2"><span>SA2</span>＞<span>引強K</span>＞<span>百鬼襲</span>＞<span>百鬼豪刃</span></div>
                                <div class="Damabe">ダメージ:3630</div>
                                <div class="Dgauge">Dゲージ:0本</div>
                                <div class="SAgauge">SAゲージ:2本</div>
                                <div class="Movie"></div>
                                <div class="Coment">有利フレーム+42Fになるので詐欺飛びになる。</div>
                            </div>
                            <div class="combo-card">    
                                <div class="combo-head">ノーゲージダメージ</div>
                                <div class="combo-box2"><span>SA2</span>＞<span>屈強P</span>＞<span>強竜巻斬空脚</span></div>
                                <div class="Damabe">ダメージ:4140</div>
                                <div class="Dgauge">Dゲージ:0本</div>
                                <div class="SAgauge">SAゲージ:2本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">2ゲージ</div>
                                <div class="combo-box2"><span>SA2</span>＞<span>引強K</span>＞<span>OD百鬼襲</span>＞<span>百鬼豪螺旋</span>＞<span>強竜巻斬空脚</span></div>
                                <div class="Damabe">ダメージ:4410</div>
                                <div class="Dgauge">Dゲージ:0.1~1</div>
                                <div class="SAgauge">SAゲージ:</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">最大</div>
                                <div class="combo-box2"><span>SA2</span>＞<span>屈強P</span>＞<span>OD竜巻斬空脚</span>＞<span>OD豪昇龍拳</span></div>
                                <div class="Damabe">ダメージ:4520</div>
                                <div class="Dgauge">Dゲージ:1.1~6</div>
                                <div class="SAgauge">SAゲージ:</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA1/ノーゲージ</div>
                                <div class="combo-box2"><span>SA2</span>＞<span>中K</span>＞<span>強K</span>＞<span>SA1</span></div>
                                <div class="Damabe">ダメージ:4180</div>
                                <div class="Dgauge">Dゲージ:0本</div>
                                <div class="SAgauge">SAゲージ:2.9本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA1/ノーゲージ</div>
                                <div class="combo-box2"><span>SA2</span>＞<span>屈強P</span>＞<span>SA1</span></div>
                                <div class="Damabe">ダメージ:4440</div>
                                <div class="Dgauge">Dゲージ:0本</div>
                                <div class="SAgauge">SAゲージ:2.9本</div>
                                <div class="Movie"></div>
                                <div class="Coment">補正値の関係で基本的には上のコンボの方が高い。生でSA2を充てた時などはこっちの方が高い。</div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA1/</div>
                                <div class="combo-box2"><span>SA2</span>＞<span>引強K</span>＞<span>OD百鬼襲</span>＞<span>天魔豪斬空</span>＞<span>強竜巻斬空脚</span></div>
                                <div class="Damabe">ダメージ:4840</div>
                                <div class="Dgauge">Dゲージ:0.1~1本</div>
                                <div class="SAgauge">SAゲージ:2.9本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">SA1/最大</div>
                                <div class="combo-box2"><span>SA2</span>＞<span>引強K</span>＞<span>OD百鬼襲</span>＞<span>天魔豪斬空</span>＞<span>OD豪昇龍拳</span></div>
                                <div class="Damabe">ダメージ:4875</div>
                                <div class="Dgauge">Dゲージ:1.1本~6本</div>
                                <div class="SAgauge">SAゲージ:2.9本</div>
                                <div class="Movie"></div>
                                <div class="Coment"></div>
                            </div>
                            <div class="combo-card">
                                <div class="combo-head">表裏</div>
                                <div class="combo-box2"><span>SA2</span>＞<span>バックステップ</span>＞<span>屈強P</span>＞<span>最速J中K</span>or<span>微遅らせJ中K</span></div>
                                <div class="Damabe">ダメージ:2800</div>
                                <div class="Dgauge">Dゲージ:0本</div>
                                <div class="SAgauge">SAゲージ:2本</div>
                                <div class="Movie"></div>
                                <div class="Coment">最速J中Kでは表ヒット、裏落ちになり微遅らせJ中Kでは裏ヒット、裏落ちになる。</div>
                            </div>
                        </div>-->
                    <div id="Others">
                        <h3>その他始動・コンボ</h3>
                        <div class="combo-card">
                            <div class="combo-head">自分が端で垂直ジャンプされた時</div>
                            <div class="combo-box2"><span>引強K</span>＞<span>中竜巻斬空脚</span>＞<span>前ステ</span>＞<span>大P(持続気味)</span>＞<span>(インパクト)</span></div>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">入れ替えコンボ</div>
                            <div class="combo-box2"><span>引強K</span>＞<span>強灼火</span></div>
                            <p>
                                中豪波動拳が持続・カウンターヒットしたら強Kにつながる・前強Pで連ガ<br>
                                前歩き+5F投げ
                            </p>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">波動確認</div>
                            <div class="combo-box2"><span>キャンセル可能な通常技</span>＞<span>豪波動拳</span>＞<span>SA3</span></div>
                            <p>通常技から豪波動拳にキャンセルするタイミングで確認とコマンド入力をしヒットしていたらキャンセルする。</p>
                            <div class="combo-box2"><span></span>＞<span></span></div>
                            <div class="combo-box2"><span></span>＞<span></span></div>
                        </div>
                    </div>
                </section>
                <section class="okizeme" id="section5">
                    <h2>起き攻め</h2>
                    <div id="Grab">
                        <h3>通常投げ</h3>
                        <div class="combo-card">
                            <div class="combo-head">画面中央</div>
                            <ul>
                                <li>生ラッシュ少し伸ばして＞屈強K</li>
                            </ul>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">パニカン/画面中央</div>
                            <ul>
                                <li>前ステ＞強P</li>
                                <li>前ステ＞前強P(4Fと相打ち、相打ち後は強Pが入る)</li>
                                <li>生ラッシュ＞中P持続
                                <li>
                                <li>生ラッシュ＞何もしない投げまわい+2F</li>

                            </ul>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">画面端</div>
                            <ul>
                                <li>前ステ始動</li>
                                <li>投げ(柔道)</li>
                                <li>立中P(持続)＞屈中P(入れ込み)</li>
                                <li>シミー</li>
                                <li></li>
                                <li>ラッシュ＞立弱P始動</li>
                                <li>投げ(柔道)</li>
                                <li>弱P連キャンにならないように(発生10F以上の無敵を詐欺れる)</li>
                                <li>立中P(Dリバを詐欺れる)</li>
                                <li>シミー</li>
                            </ul>
                        </div>
                    </div>
                    <div id="SquatStrong">
                        <h3>しゃがみ強キック</h3>
                        <div class="combo-card">
                            <div class="combo-head">通常/カウンターヒット/中央</div>
                            <ul>
                                <li>屈弱K＞前ステ()</li>
                                <li>弱百鬼襲＞百鬼豪刃(+5F投げ間合い、無敵に負ける)</li>
                                <li>弱百鬼襲＞遅らせ百鬼豪衝or百鬼豪刃(ファジー狩り)</li>
                                <li>弱百鬼襲＞百鬼潜影(-5F、無敵をガードできる)</li>
                            </ul>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">通常/カウンターヒット/画面端</div>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">パニカン/中央</div>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">パニカン/画面端</div>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">空中ヒット/中央</div>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">空中ヒット/画面端</div>
                            <ul>
                                <li>弱P×2(フレーム消費)＞前強P(持続)</li>
                            </ul>
                        </div>
                    </div>
                    <div id="Tatsumaki">
                        <h3>竜巻斬空脚</h3>
                        <div class="combo-card">
                            <div class="combo-head">中竜/画面中央</div>
                            <ul>
                                <li>微歩き＞前ステ＝中P持続or投げorシミー</li>
                                <li>弱百鬼襲＞百鬼豪斬が先端で+2(昇龍拳すかせる)</li>
                                <li>生ラッシュ＞最速朧重なってるor何もしな(投げまわい外+15)orラッシュ伸ばして中P持続</li>
                            </ul>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">強竜巻斬空脚</div>
                            <ul>
                                <li>前ステ＞前強Pタゲコン</li>
                                <li></li>
                            </ul>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">弱竜巻斬空脚＞強竜巻斬空脚</div>
                            <ul>
                                <li>屈弱K×2＞投げ(5F)</li>
                                <li>屈弱P×2＞立中P(持続)</li>
                                <li>シミー</li>
                            </ul>
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">強金剛灼火＞強竜巻斬空脚</div>
                            <ul>
                                <li>立中K＞投げ(5F)</li>
                                <li>屈弱P＞立弱P＞立中P(持続)</li>
                                <li>シミー</li>
                            </ul>
                        </div>
                        <div class="combo-card">
                            <div id="Syouryuuken">
                                <h3>豪昇龍拳</h3>
                                <div class="combo-card">
                                    <div class="combo-head">弱昇龍</div>
                                    <ul>
                                        <li>屈弱P＞立弱K＞投げ(5F)</li>
                                        <li>投げすかり＞立中P(持続)</li>
                                        <li>屈弱P＞前中P(持続中段)</li>
                                        <li>屈弱P＞弱豪波動拳(持続)</li>
                                        <li>シミー</li>
                                    </ul>
                                </div>
                            </div>
                            <div id="OkizemeOthers">
                                <h3>その他</h3>
                                <div class="combo-card">
                                    <div class="combo-head">壁張り付きのないSA2</div>
                                    <ul>
                                        <li>前ステ＞立中K(持続ヒット、屈中P入れ込み基本OK)</li>
                                        <li>通常投げ(目押)</li>
                                        <li>シミー</li>
                                    </ul>
                                </div>
                            </div>
                </section>
                <section class="setup" id="section6">
                    <h2>セットアップ</h2>
                    <div id="Shungoku">
                        <h3>瞬獄殺</h3>
                        <div class="combo-card">
                            <div class="combo-box2"><span>弱K</span>＞<span>キャンセルラッシュ</span>＞<span>瞬獄殺</span></div>
                            <div class="combo-box2"><span>弱竜巻斬空脚</span>＞<span>J強K</span><span class="sub">空振り</span>＞<span>瞬獄殺</span></div>
                            <div class="combo-box2"><span>ラッシュ立中P</span>＞<span>微歩き</span>＞<span>瞬獄殺</span></div>
                            <div class="combo-box2"><span>中・強灼火</span><span class="sub">一段止め</span>＞<span>瞬獄殺</span></div>
                            <div class="combo-box2"><span>百鬼豪刃</span><span class="sub">下の方</span>＞<span>瞬獄殺</span></div>
                            <div class="combo-head">画面端</div>
                            <div class="combo-box2"><span>壁張り付き</span>＞<span>屈強P</span>＞<span>弱豪波動拳</span>＞<span>豪波動拳</span><span class="sub">空振り</span>＞<span>瞬獄殺</span></div>
                            <div class="combo-box2"><span>OD灼火</span>＞<span>引強K</span>＞<span>OD豪波動拳</span><span class="sub">Lv3</span>＞<span>生ラッシュ</span>＞<span>立弱P</span>＞<span>OD灼火</span>＞<span>投げ</span><span class="sub">空振り</span>＞<span>瞬獄殺</span></div>
                            <div class="combo-box2"><span>空中弱豪昇龍拳</span>＞<span>屈弱P</span>＞<span>弱豪波動拳</span>＞<span>瞬獄殺</span></div>
                            <div class="combo-box2"><span>引強K</span>＞<span>OD百鬼襲</span>＞<span>百鬼豪螺旋</span>＞<span>空パリィ</span>＞<span>瞬獄殺</span></div>
                            <div class="combo-box2"><span>投げ</span>＞<span>生ラッシュ</span>＞<span>立弱P</span><span class="sub">空振り</span>＞<span>瞬獄殺</span></div>
                            <div class="combo-box2"><span>壁張り付き</span>＞<span>屈強P</span>＞<span>OD百鬼襲</span>＞<span>百鬼豪刃空</span>＞<span>百鬼襲</span>＞<span>百鬼豪衝</span><span class="sub">空振り</span>＞<span>瞬獄殺</span></div>
                            <div class="combo-box2"><span>壁張り付き</span>＞<span>屈強P</span>＞<span>キャンセルラッシュ</span>＞<span>立中K</span>＞<span>インパクト</span><span class="sub">空振り</span>＞<span>瞬獄殺</span></div>
                            <div class="combo-box2"><span>生ラッシュ</span>＞<span>屈強P</span><span class="sub">ロック</span>＞<span>瞬獄殺</span></div>
                            <div class="combo-box2"><span></span>＞<span></span>＞<span></span></div>
                            <div class="combo-box2"><span></span>＞<span></span>＞<span></span></div>
                        </div>
                    </div>
                    <div id="Oboro">
                        <h3>朧</h3>
                        <div class="combo-card">
                            <p>+28F~+31Fのフレーム内では、</p>
                            +27F✕中竜巻＞屈弱P
                            +28F〇引強K＞強灼火＞屈弱K
                            +29F〇引強K＞立弱K
                            +30F〇弱竜巻＞強昇竜
                            +31F〇強灼火＞屈弱K
                            +32F✕中昇竜
                        </div>
                        <div class="combo-card">
                            <div class="combo-head">端</div>
                            中P＞屈小P＞小K＞弱波動＞中灼火=弱波動後に差し込みに来た相手に中灼火でサプレッサー
                        </div>
                    </div>
                </section>
                <section class="countermeasure" id="section7">
                    <h2>キャラ対策</h2>
                    <p>全キャラ共通の対策ではなく自キャラが豪鬼の対策</p>
                    <div class="countermeasure-table">
                        <table>
                            <tr class="head-tr">
                                <th>キャラクター一覧</th>
                            </tr>
                            <tr>
                                <td><a class="link" href="#luke"><img class="countermeasure-img" src="../img/character/luke_ss02.jpg" alt="ルーク">ルーク</a></td>
                                <td><a class="link" href="#jamie"><img class="countermeasure-img" src="../img/character/jamie_ss02.jpg" alt="ジェイミー">ジェイミー</a></td>
                                <td><a class="link" href="#manon"><img class="countermeasure-img" src="../img/character/manon_ss02.jpg" alt="マノン">マノン</a></td>
                                <td><a class="link" href="#kimberly"><img class="countermeasure-img" src="../img/character/kimberly_ss02.jpg" alt="キンバリー">キンバリー</a></td>
                                <td><a class="link" href="#marisa"><img class="countermeasure-img" src="../img/character/marisa_ss02.jpg" alt="マリーザ">マリーザ</a></td>
                                <td><a class="link" href="#lily"><img class="countermeasure-img" src="../img/character/lily_ss02.jpg" alt="リリー">リリー</a></td>
                                <td><a class="link" href="#jp"><img class="countermeasure-img" src="../img/character/jp_ss02.jpg" alt="JP">JP</a></td>
                                <td><a class="link" href="#juri"><img class="countermeasure-img" src="../img/character/juri_ss02.jpg" alt="ジュリ">ジュリ</a></td>
                                <td><a class="link" href="#deejay"><img class="countermeasure-img" src="../img/character/deejay_ss02.jpg" alt="DJ">DJ</a></td>
                                <td><a class="link" href="#cammy"><img class="countermeasure-img" src="../img/character/cammy_ss02.jpg" alt="キャミィ">キャミィ</a></td>
                                <td><a class="link" href="#ryu"><img class="countermeasure-img" src="../img/character/ryu_ss02.jpg" alt="リュウ">リュウ</a></td>
                                <td class="last-td"><a class="link" href="#ehonda"><img class="countermeasure-img" src="../img/character/ehonda_ss02.jpg" alt="E・本田">E・本田</a></td>
                            </tr>
                            <tr>
                                <td><a class="link" href="#blanka"><img class="countermeasure-img" src="../img/character/blanka_ss02.jpg" alt="ブランカ">ブランカ</a></td>
                                <td><a class="link" href="#guile"><img class="countermeasure-img" src="../img/character/guile_ss02.jpg" alt="ガイル">ガイル</a></td>
                                <td><a class="link" href="#ken"><img class="countermeasure-img" src="../img/character/ken_ss02.jpg" alt="ケン">ケン</a></td>
                                <td><a class="link" href="#chunli"><img class="countermeasure-img" src="../img/character/chunli_ss02.jpg" alt="春麗">春麗</a></td>
                                <td><a class="link" href="#zangief"><img class="countermeasure-img" src="../img/character/zangief_ss02.jpg" alt="ザンギエフ">ザンギエフ</a></td>
                                <td><a class="link" href="#dhalsim"><img class="countermeasure-img" src="../img/character/dhalsim_ss02.jpg" alt="ダルシム">ダルシム</a></td>
                                <td><a class="link" href="#rashid"><img class="countermeasure-img" src="../img/character/rashid_ss02.jpg" alt="ラシード">ラシード</a></td>
                                <td><a class="link" href="#aki"><img class="countermeasure-img" src="../img/character/aki_ss02.jpg" alt="A.K.I.">A.K.I.</a></td>
                                <td><a class="link" href="#ed"><img class="countermeasure-img" src="../img/character/ed_ss02.jpg" alt="エド">エド</a></td>
                                <td><a class="link" href="#gouki_akuma"><img class="countermeasure-img" src="../img/character/gouki_akuma_ss02.jpg" alt="豪鬼">豪鬼</a></td>
                                <td><a class="link" href="#vega"><img class="countermeasure-img" src="../img/character/vega_mbison_ss02.jpg" alt="ベガ">ベガ</a></td>
                                <td class="last-td"><a class="link" href="#terry"><img class="countermeasure-img" src="../img/character/terry_ss02.jpg" alt="テリー">テリー</a></td>
                            </tr>
                            <tr class="last-tr">
                                <td><a class="link" href="#mai"><img class="countermeasure-img" src="../img/character/mai_ss02.jpg" alt="舞">舞</a></td>
                                <td><a class="link" href="#elena"><img class="countermeasure-img" src="../img/character/elena_ss02.jpg" alt="エレナ">エレナ</a></td>
                                <td><a class="link" href="#characternon1"><img class="countermeasure-img" src="" alt="-">-</a></td>
                                <td><a class="link" href="#characternon1"><img class="countermeasure-img" src="" alt="-">-</a></td>
                                <td><a class="link" href="#characternon1"><img class="countermeasure-img" src="" alt="-">-</a></td>
                                <td><a class="link" href="#characternon1"><img class="countermeasure-img" src="" alt="-">-</a></td>
                                <td><a class="link" href="#characternon1"><img class="countermeasure-img" src="" alt="-">-</a></td>
                                <td><a class="link" href="#characternon1"><img class="countermeasure-img" src="" alt="-">-</a></td>
                                <td><a class="link" href="#characternon1"><img class="countermeasure-img" src="" alt="-">-</a></td>
                                <td><a class="link" href="#characternon1"><img class="countermeasure-img" src="" alt="-">-</a></td>
                                <td><a class="link" href="#characternon1"><img class="countermeasure-img" src="" alt="-">-</a></td>
                                <td class="last-td"><a class="link" href="#characternon2"><img class="countermeasure-img" src="" alt="-">-</a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="character" id="luke">
                        <div class="content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">ルーク</div>
                            <img src="../img/character/luke_ss02.jpg" alt="ルーク画像">
                        </div>
                    </div>
                    <div class="character" id="jamie">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">ジェイミー</div>
                            <img src="../img/character/jamie_ss02.jpg" alt="ジェイミー画像">
                        </div>
                    </div>
                    <div class="character" id="manon">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">マノン</div>
                            <img src="../img/character/manon_ss02.jpg" alt="マノン画像">
                        </div>
                    </div>
                    <div class="character" id="kimberly">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li>疾駆けジャスパ <br>(画面端)=インパクト＞生ラッシュ＞引強K＞百鬼<br>(中央)=インパクト＞引強K＞百鬼K＞中竜巻</li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">キンバリー</div>
                            <img src="../img/character/kimberly_ss02.jpg" alt="キンバリー画像">
                        </div>
                    </div>
                    <div class="character" id="marisa">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">マリーザ</div>
                            <img src="../img/character/marisa_ss02.jpg" alt="マリーザ画像">
                        </div>
                    </div>
                    <div class="character" id="lily">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">リリー</div>
                            <img src="../img/character/lily_ss02.jpg" alt="リリー画像">
                        </div>
                    </div>
                    <div class="character" id="jp">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">JP</div>
                            <img src="../img/character/jp_ss02.jpg" alt="JP画像">
                        </div>
                    </div>
                    <div class="character" id="juri">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">ジュリ</div>
                            <img src="../img/character/juri_ss02.jpg" alt="ジュリ画像">
                        </div>
                    </div>
                    <div class="character" id="deejay">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">DJ</div>
                            <img src="../img/character/deejay_ss02.jpg" alt="DJ画像">
                        </div>
                    </div>
                    <div class="character" id="cammy">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">キャミィ</div>
                            <img src="../img/character/cammy_ss02.jpg" alt="キャミィ画像">
                        </div>
                    </div>
                    <div class="character" id="ryu">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">リュウ</div>
                            <img src="../img/character/ryu_ss02.jpg" alt="リュウ画像">
                        </div>
                    </div>
                    <div class="character" id="ehonda">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">E・本田</div>
                            <img src="../img/character/ehonda_ss02.jpg" alt="E・本田画像">
                        </div>
                    </div>
                    <div class="character" id="blanka">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">ブランカ</div>
                            <img src="../img/character/blanka_ss02.jpg" alt="ブランカ画像">
                        </div>
                    </div>
                    <div class="character" id="guile">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">ガイル</div>
                            <img src="../img/character/guile_ss02.jpg" alt="ガイル画像">
                        </div>
                    </div>
                    <div class="character" id="ken">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">ケン</div>
                            <img src="../img/character/ken_ss02.jpg" alt="ケン画像">
                        </div>
                    </div>
                    <div class="character" id="chunli">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">春麗</div>
                            <img src="../img/character/chunli_ss02.jpg" alt="春麗画像">
                        </div>
                    </div>
                    <div class="character" id="zangief">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">ザンギエフ</div>
                            <img src="../img/character/zangief_ss02.jpg" alt="ザンギエフ画像">
                        </div>
                    </div>
                    <div class="character" id="dhalsim">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li>技相性:屈中P=立中K＞キャンセルラッシュ＞前強P</li>
                                <li>技相性:立中K=屈中P＞キャンセルラッシュ＞前強P</li>
                                <li>フロート=生ラッシュ＞引強K＞弱豪波動拳Lv2＞...</li>
                                <li>フロート中P=屈強P＞キャンセルラッシュor中竜巻斬空脚</li>
                                <li>リバサSA2 <br>安定=朧投げ <br>安定SA2or3=屈強P＞SA2or3 <br>最大=インパクト＞パリィ＞引強K始動(インパクトは弾が上の方に行ったら打つ)</li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">ダルシム</div>
                            <img src="../img/character/dhalsim_ss02.jpg" alt="ダルシム画像">
                        </div>
                    </div>
                    <div class="character" id="rashid">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">ラシード</div>
                            <img src="../img/character/rashid_ss02.jpg" alt="ラシード画像">
                        </div>
                    </div>
                    <div class="character" id="aki">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li>端端でSA2(削りなど)=暗転見てから前ジャンプ斬空強波動確定</li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">A.K.I.</div>
                            <img src="../img/character/aki_ss02.jpg" alt="A.K.I.画像">
                        </div>
                    </div>
                    <div class="character" id="ed">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li>ODサイコアッパー=中パン最持続で詐欺れる <br>柔道からはラッシュ弱P(フレーム消費)＞弱P</li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">エド</div>
                            <img src="../img/character/ed_ss02.jpg" alt="エド画像">
                        </div>
                    </div>
                    <div class="character" id="gouki_akuma">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">豪鬼</div>
                            <img src="../img/character/gouki_akuma_ss02.jpg" alt="豪鬼画像">
                        </div>
                    </div>
                    <div class="character" id="vega">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">ベガ</div>
                            <img src="../img/character/vega_mbison_ss02.jpg" alt="ベガ画像">
                        </div>
                    </div>
                    <div class="character" id="terry">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">テリー</div>
                            <img src="../img/character/terry_ss02.jpg" alt="テリー画像">
                        </div>
                    </div>
                    <div class="character" id="mai">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">舞</div>
                            <img src="../img/character/mai_ss02.jpg" alt="舞画像">
                        </div>
                    </div>
                    <div class="character" id="elena">
                        <div class="-content">
                            <div class="content-head">対策</div>
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">エレナ</div>
                            <img src="../img/character/elena_ss02.jpg" alt="エレナ画像">
                        </div>
                    </div>
                    <div class="character" id="characternon1">
                        <div class="-content">
                            箇条書きで対策の内容を書いていく
                            texttexttexttexttexttexttexttexttexttexttexttexttexttexttexttexttexttext
                        </div>
                        <div class="countermeasure-list">
                            <div class="content-name">キャラクター名</div>
                            <img src="../img/character/luke_ss02.jpg" alt="キャラクター名画像">
                        </div>
                    </div>
                </section>
                <section class="framedata" id="section8">
                    <h2>フレームデータ</h2>
                    <div class="section-title">通常技</div>
                    <div class="table-wrapper">
                        <table class="move-table">
                            <thead>
                                <tr>
                                    <th>技名</th>
                                    <th>発生</th>
                                    <th>持続</th>
                                    <th>硬直</th>
                                    <th>ヒット</th>
                                    <th>ガード</th>
                                    <th>キャンセル</th>
                                    <th>ダメージ</th>
                                    <th>補正</th>
                                    <th>Dゲージ増(ヒット)</th>
                                    <th>Dゲージ減(ガード)</th>
                                    <th>Dゲージ減(パニカン)</th>
                                    <th>SAゲージ増加</th>
                                    <th>属性</th>
                                    <th>備考</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>立ち弱P（面割り）</td>
                                    <td>4</td>
                                    <td>4-6</td>
                                    <td>7</td>
                                    <td>+4</td>
                                    <td>-1</td>
                                    <td>C</td>
                                    <td>300</td>
                                    <td>始動補正20%</td>
                                    <td>250</td>
                                    <td>-500</td>
                                    <td>-2000</td>
                                    <td>300</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>立ち弱K（脛斬り）</td>
                                    <td>5</td>
                                    <td>5-7</td>
                                    <td>11</td>
                                    <td>+2</td>
                                    <td>-4</td>
                                    <td>C</td>
                                    <td>300</td>
                                    <td>始動補正20%</td>
                                    <td>250</td>
                                    <td>-500</td>
                                    <td>-2000</td>
                                    <td>300</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>立ち中P（豪掌）</td>
                                    <td>6</td>
                                    <td>6-9</td>
                                    <td>11</td>
                                    <td>+4</td>
                                    <td>+1</td>
                                    <td>C</td>
                                    <td>600</td>
                                    <td></td>
                                    <td>1500</td>
                                    <td>-3000</td>
                                    <td>-4000</td>
                                    <td>500</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>立ち中K（腸潰し）</td>
                                    <td>7</td>
                                    <td>7-11</td>
                                    <td>15</td>
                                    <td>+3</td>
                                    <td>-3</td>
                                    <td>C</td>
                                    <td>700</td>
                                    <td></td>
                                    <td>2000</td>
                                    <td>-4000</td>
                                    <td>-6000</td>
                                    <td>500</td>
                                    <td>上</td>
                                    <td>強制立ち効果</td>
                                </tr>
                                <tr>
                                    <td>立ち強P（岩砕突き）</td>
                                    <td>9</td>
                                    <td>9-13</td>
                                    <td>18</td>
                                    <td>+3</td>
                                    <td>-3</td>
                                    <td>C</td>
                                    <td>800</td>
                                    <td></td>
                                    <td>2000</td>
                                    <td>-5000</td>
                                    <td>-8000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>立ち強K（首撥ね）</td>
                                    <td>13</td>
                                    <td>13-17</td>
                                    <td>15</td>
                                    <td>+7</td>
                                    <td>+3</td>
                                    <td></td>
                                    <td>800</td>
                                    <td>コンボ補正20%</td>
                                    <td>3000</td>
                                    <td>-6000</td>
                                    <td>-10000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td>強制立ち効果 / 空振り時硬直1F増加</td>
                                </tr>
                                <tr>
                                    <td>しゃがみ弱P（足止め）</td>
                                    <td>4</td>
                                    <td>4-5</td>
                                    <td>9</td>
                                    <td>+5</td>
                                    <td>-1</td>
                                    <td>C</td>
                                    <td>300</td>
                                    <td>始動補正20%</td>
                                    <td>250</td>
                                    <td>-500</td>
                                    <td>-2000</td>
                                    <td>300</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>しゃがみ弱K（楔打ち）</td>
                                    <td>5</td>
                                    <td>5-6</td>
                                    <td>10</td>
                                    <td>+3</td>
                                    <td>-3</td>
                                    <td></td>
                                    <td>200</td>
                                    <td>始動補正20%</td>
                                    <td>250</td>
                                    <td>-500</td>
                                    <td>-2000</td>
                                    <td>300</td>
                                    <td>下</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>しゃがみ中P（膝折り豪掌）</td>
                                    <td>6</td>
                                    <td>6-8</td>
                                    <td>16</td>
                                    <td>+6</td>
                                    <td>-1</td>
                                    <td>C</td>
                                    <td>600</td>
                                    <td></td>
                                    <td>1500</td>
                                    <td>-3000</td>
                                    <td>-4000</td>
                                    <td>500</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>しゃがみ中K（踝払い）</td>
                                    <td>8</td>
                                    <td>8-10</td>
                                    <td>19</td>
                                    <td>+1</td>
                                    <td>-6</td>
                                    <td>C</td>
                                    <td>500</td>
                                    <td>始動補正20%</td>
                                    <td>1000</td>
                                    <td>-2000</td>
                                    <td>-4000</td>
                                    <td>500</td>
                                    <td>下</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>しゃがみ強P（獄門掌）</td>
                                    <td>8</td>
                                    <td>8-15</td>
                                    <td>19</td>
                                    <td>+0</td>
                                    <td>-8</td>
                                    <td>C</td>
                                    <td>900</td>
                                    <td></td>
                                    <td>3000</td>
                                    <td>-6000</td>
                                    <td>-8000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>しゃがみ強K（刎脚）</td>
                                    <td>9</td>
                                    <td>9-11</td>
                                    <td>23</td>
                                    <td>D</td>
                                    <td>-12</td>
                                    <td></td>
                                    <td>900</td>
                                    <td></td>
                                    <td>3000</td>
                                    <td>-4000</td>
                                    <td>-10000</td>
                                    <td>1000</td>
                                    <td>下</td>
                                    <td>カウンター / Pカウンター時ダウン時間増加</td>
                                </tr>
                                <tr>
                                    <td>ジャンプ弱P（眉間割り）</td>
                                    <td>4</td>
                                    <td>4-13</td>
                                    <td>着地後3</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>300</td>
                                    <td></td>
                                    <td>500</td>
                                    <td>-1500</td>
                                    <td>-2000</td>
                                    <td>300</td>
                                    <td>中</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>ジャンプ弱K（飛び膝）</td>
                                    <td>6</td>
                                    <td>6-15</td>
                                    <td>着地後3</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>300</td>
                                    <td></td>
                                    <td>500</td>
                                    <td>-1500</td>
                                    <td>-2000</td>
                                    <td>300</td>
                                    <td>中</td>
                                    <td>めくり性能</td>
                                </tr>
                                <tr>
                                    <td>ジャンプ中P（跳び朱刀）</td>
                                    <td>8</td>
                                    <td>8-11</td>
                                    <td>着地後3</td>
                                    <td></td>
                                    <td></td>
                                    <td>C</td>
                                    <td>700</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>-2500</td>
                                    <td>-4000</td>
                                    <td>500</td>
                                    <td>中</td>
                                    <td>空中ヒット時吹き飛びダウン</td>
                                </tr>
                                <tr>
                                    <td>ジャンプ中K（首斬り）</td>
                                    <td>7</td>
                                    <td>7-12</td>
                                    <td>着地後3</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>500</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>-2500</td>
                                    <td>-4000</td>
                                    <td>500</td>
                                    <td>中</td>
                                    <td>めくり性能</td>
                                </tr>
                                <tr>
                                    <td>ジャンプ強P（羅刹拳）</td>
                                    <td>9</td>
                                    <td>9-14</td>
                                    <td>着地後3</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>800</td>
                                    <td></td>
                                    <td>2000</td>
                                    <td>-4000</td>
                                    <td>-5000</td>
                                    <td>1000</td>
                                    <td>中</td>
                                    <td>空中カウンター / Pカウンター時叩きつけダウン</td>
                                </tr>
                                <tr>
                                    <td>ジャンプ強K（斬鉄脚）</td>
                                    <td>12</td>
                                    <td>12-17</td>
                                    <td>着地後3</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>800</td>
                                    <td></td>
                                    <td>2000</td>
                                    <td>-4000</td>
                                    <td>-5000</td>
                                    <td>1000</td>
                                    <td>中</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="section-title">特殊技</div>
                    <div class="table-wrapper">
                        <table class="move-table">
                            <thead>
                                <tr>
                                    <th>技名</th>
                                    <th>発生</th>
                                    <th>持続</th>
                                    <th>硬直</th>
                                    <th>ヒット</th>
                                    <th>ガード</th>
                                    <th>キャンセル</th>
                                    <th>ダメージ</th>
                                    <th>補正</th>
                                    <th>Dゲージ増(ヒット)</th>
                                    <th>Dゲージ減(ガード)</th>
                                    <th>Dゲージ減(パニカン)</th>
                                    <th>SAゲージ増加</th>
                                    <th>属性</th>
                                    <th>備考</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>頭蓋破殺</td>
                                    <td>20</td>
                                    <td>20-24</td>
                                    <td>18</td>
                                    <td>3</td>
                                    <td>-1</td>
                                    <td></td>
                                    <td>600</td>
                                    <td></td>
                                    <td>1500</td>
                                    <td>-2500</td>
                                    <td>-5000</td>
                                    <td>500</td>
                                    <td>※中上</td>
                                    <td>※初段が空振り時のみ2段目が中段判定</td>
                                </tr>
                                <tr>
                                    <td>裂槍脚</td>
                                    <td>10</td>
                                    <td>10-12</td>
                                    <td>15</td>
                                    <td>5</td>
                                    <td>-4</td>
                                    <td></td>
                                    <td>700</td>
                                    <td></td>
                                    <td>2000</td>
                                    <td>-4000</td>
                                    <td>-6000</td>
                                    <td>500</td>
                                    <td>上</td>
                                    <td>空振り時硬直4F増加/ガード時硬直3F増加</td>
                                </tr>
                                <tr>
                                    <td>羅豪脚</td>
                                    <td>12</td>
                                    <td>12-16</td>
                                    <td>27</td>
                                    <td>D</td>
                                    <td>-15</td>
                                    <td>C</td>
                                    <td>800</td>
                                    <td>始動補正20%</td>
                                    <td>2000</td>
                                    <td>-5000</td>
                                    <td>-5000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>六腑穿ち</td>
                                    <td>7</td>
                                    <td>7-9</td>
                                    <td>21</td>
                                    <td>-1</td>
                                    <td>-6</td>
                                    <td>C</td>
                                    <td>700</td>
                                    <td>コンボ補正20%</td>
                                    <td>1500</td>
                                    <td>-2000</td>
                                    <td>-4000</td>
                                    <td>500</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>骸斬り</td>
                                    <td>20</td>
                                    <td>20-22</td>
                                    <td>20</td>
                                    <td>1</td>
                                    <td>-3</td>
                                    <td></td>
                                    <td>600</td>
                                    <td>コンボ補正20%</td>
                                    <td>2000</td>
                                    <td>-4000</td>
                                    <td>-5000</td>
                                    <td>1000</td>
                                    <td>中</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>鬼哭連撃（1段目）</td>
                                    <td>13</td>
                                    <td>13-16</td>
                                    <td>20</td>
                                    <td>4</td>
                                    <td>-3</td>
                                    <td></td>
                                    <td>800</td>
                                    <td></td>
                                    <td>3000</td>
                                    <td>-5000</td>
                                    <td>-8000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>鬼哭連撃（2段目）</td>
                                    <td>10</td>
                                    <td>10-12</td>
                                    <td>21</td>
                                    <td>D</td>
                                    <td>-10</td>
                                    <td></td>
                                    <td>600</td>
                                    <td></td>
                                    <td>2000</td>
                                    <td>-5000</td>
                                    <td>-8000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>鬼哭連撃（3段目）</td>
                                    <td>9</td>
                                    <td>9-11</td>
                                    <td>24</td>
                                    <td>D</td>
                                    <td>-13</td>
                                    <td></td>
                                    <td>875</td>
                                    <td></td>
                                    <td>2500</td>
                                    <td>-2000</td>
                                    <td>0</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>天魔空刃脚</td>
                                    <td>16</td>
                                    <td>16-着地まで</td>
                                    <td>着地後13</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>800</td>
                                    <td>始動補正20%/コンボ補正20%</td>
                                    <td>3000</td>
                                    <td>-4000</td>
                                    <td>-5000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="section-title">必殺技</div>

                    <div class="table-wrapper">
                        <table class="move-table">
                            <thead>
                                <tr>
                                    <th>技名</th>
                                    <th>発生</th>
                                    <th>持続</th>
                                    <th>硬直</th>
                                    <th>ヒット</th>
                                    <th>ガード</th>
                                    <th>キャンセル</th>
                                    <th>ダメージ</th>
                                    <th>補正</th>
                                    <th>Dゲージ増(ヒット)</th>
                                    <th>Dゲージ減(ガード)</th>
                                    <th>Dゲージ減(パニカン)</th>
                                    <th>SAゲージ増加</th>
                                    <th>属性</th>
                                    <th>備考</th>
                                </tr>
                            </thead>
                            <tbody>
                                <th class="techniquename">豪波動拳</th>
                                <tr>
                                    <td>弱 豪波動拳 (Lv1)</td>
                                    <td>16</td>
                                    <td></td>
                                    <td>全体46</td>
                                    <td>0</td>
                                    <td>-4</td>
                                    <td>SA3</td>
                                    <td>700</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>-2500</td>
                                    <td>-3000</td>
                                    <td>600</td>
                                    <td>上/弾</td>
                                    <td>25F以上ボタンを押して離すとLv2が発動 / 49F以上でLv3</td>
                                </tr>
                                <tr>
                                    <td>弱 豪波動拳 (Lv2)</td>
                                    <td>31</td>
                                    <td></td>
                                    <td>全体60</td>
                                    <td>D</td>
                                    <td>2</td>
                                    <td>SA3</td>
                                    <td>1000</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>-2500</td>
                                    <td>-5000</td>
                                    <td>600</td>
                                    <td>上/弾</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>弱 豪波動拳 (Lv3)</td>
                                    <td>56</td>
                                    <td></td>
                                    <td>全体84</td>
                                    <td>D</td>
                                    <td>5</td>
                                    <td>SA3</td>
                                    <td>1200</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>-3000</td>
                                    <td>-7000</td>
                                    <td>600</td>
                                    <td>上/弾</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>中 豪波動拳 (Lv1)</td>
                                    <td>14</td>
                                    <td></td>
                                    <td>全体46</td>
                                    <td>-2</td>
                                    <td>-6</td>
                                    <td>SA3</td>
                                    <td>700</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>-2500</td>
                                    <td>-3000</td>
                                    <td>600</td>
                                    <td>上/弾</td>
                                    <td>25F以上ボタンを押して離すとLv2が発動 / 49F以上でLv3</td>
                                </tr>
                                <tr>
                                    <td>中 豪波動拳 (Lv2)</td>
                                    <td>31</td>
                                    <td></td>
                                    <td>全体60</td>
                                    <td>D</td>
                                    <td>2</td>
                                    <td>SA3</td>
                                    <td>1000</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>-2500</td>
                                    <td>-5000</td>
                                    <td>600</td>
                                    <td>上/弾</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>中 豪波動拳 (Lv3)</td>
                                    <td>56</td>
                                    <td></td>
                                    <td>全体84</td>
                                    <td>D</td>
                                    <td>5</td>
                                    <td>SA3</td>
                                    <td>1200</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>-3000</td>
                                    <td>-7000</td>
                                    <td>600</td>
                                    <td>上/弾</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>強 豪波動拳 (Lv1)</td>
                                    <td>12</td>
                                    <td></td>
                                    <td>全体46</td>
                                    <td>-4</td>
                                    <td>-8</td>
                                    <td>SA3</td>
                                    <td>700</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>-2500</td>
                                    <td>-3000</td>
                                    <td>600</td>
                                    <td>上/弾</td>
                                    <td>25F以上ボタンを押して離すとLv2が発動 / 49F以上でLv3</td>
                                </tr>
                                <tr>
                                    <td>強 豪波動拳 (Lv2)</td>
                                    <td>31</td>
                                    <td></td>
                                    <td>全体60</td>
                                    <td>D</td>
                                    <td>2</td>
                                    <td>SA3</td>
                                    <td>1000</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>-2500</td>
                                    <td>-5000</td>
                                    <td>600</td>
                                    <td>上/弾</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>強 豪波動拳 (Lv3)</td>
                                    <td>56</td>
                                    <td></td>
                                    <td>全体84</td>
                                    <td>D</td>
                                    <td>5</td>
                                    <td>SA3</td>
                                    <td>1200</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>-3000</td>
                                    <td>-7000</td>
                                    <td>600</td>
                                    <td>上/弾</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>OD 豪波動拳</td>
                                    <td>12</td>
                                    <td></td>
                                    <td>全体41</td>
                                    <td>D</td>
                                    <td>2</td>
                                    <td>SA2</td>
                                    <td>1000</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>-2500</td>
                                    <td>-5000</td>
                                    <td>600</td>
                                    <td>上/弾</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>OD 豪波動拳（ホールド）</td>
                                    <td>-</td>
                                    <td></td>
                                    <td>-</td>
                                    <td>D</td>
                                    <td>5</td>
                                    <td>SA2</td>
                                    <td>1200</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>-3000</td>
                                    <td>-7000</td>
                                    <td>600</td>
                                    <td>上/弾</td>
                                    <td>25F以上ホールドすると性能変化</td>
                                </tr>
                                <th class="techniquename">斬空波動拳</th>
                                <tr>
                                    <td>斬空波動拳(弱)</td>
                                    <td>13</td>
                                    <td></td>
                                    <td>着地後9</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>600</td>
                                    <td>始動補正40%</td>
                                    <td>2000</td>
                                    <td>-2500</td>
                                    <td>-3000</td>
                                    <td>1000</td>
                                    <td>上/弾</td>
                                    <td>空弾属性に対して無敵の技に当たらない</td>
                                </tr>
                                <tr>
                                    <td>斬空波動拳(中)</td>
                                    <td>13</td>
                                    <td></td>
                                    <td>着地後9</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>600</td>
                                    <td>始動補正40%</td>
                                    <td>2000</td>
                                    <td>-2500</td>
                                    <td>-3000</td>
                                    <td>1000</td>
                                    <td>上/弾</td>
                                    <td>空弾属性に対して無敵の技に当たらない</td>
                                </tr>
                                <tr>
                                    <td>斬空波動拳(強)</td>
                                    <td>13</td>
                                    <td></td>
                                    <td>着地後9</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>600</td>
                                    <td>始動補正40%</td>
                                    <td>2000</td>
                                    <td>-2500</td>
                                    <td>-3000</td>
                                    <td>1000</td>
                                    <td>上/弾</td>
                                    <td>空弾属性に対して無敵の技に当たらない</td>
                                </tr>
                                <tr>
                                    <td>OD 斬空波動拳</td>
                                    <td>6</td>
                                    <td></td>
                                    <td>着地後9</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                    <td>900</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>-5000</td>
                                    <td>-1000</td>
                                    <td>1000</td>
                                    <td>上/弾</td>
                                    <td>空弾属性に対して無敵の技に当たらない</td>
                                </tr>
                                <th class="techniquename">豪昇龍拳</th>
                                <tr>
                                    <td>豪昇龍拳(弱)</td>
                                    <td>5</td>
                                    <td>5-14</td>
                                    <td>21+着地後12</td>
                                    <td>D</td>
                                    <td>-23</td>
                                    <td>SA3</td>
                                    <td>1100</td>
                                    <td>始動補正20%</td>
                                    <td>2000</td>
                                    <td>-4000</td>
                                    <td>-5000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td>1-14F　空中判定の打撃・空弾属性に対して無敵/8-35F　空中判定/td>
                                </tr>
                                <tr>
                                    <td>豪昇龍拳(中)</td>
                                    <td>6</td>
                                    <td>6-15</td>
                                    <td>30+着地後12</td>
                                    <td>D</td>
                                    <td>-30</td>
                                    <td>SA3</td>
                                    <td>1300</td>
                                    <td>始動補正20%</td>
                                    <td>2000</td>
                                    <td>-4000</td>
                                    <td>-5000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td>1-9F　空中判定の打撃・空弾属性に対して無敵/9-45F　空中判定</td>
                                </tr>
                                <tr>
                                    <td>豪昇龍拳(強)</td>
                                    <td>7</td>
                                    <td>7-17</td>
                                    <td>35+着地後15</td>
                                    <td>D</td>
                                    <td>-36</td>
                                    <td>SA3</td>
                                    <td>1500</td>
                                    <td>始動補正20%</td>
                                    <td>2100</td>
                                    <td>-6000</td>
                                    <td>-5000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td>1-9F　空中判定の打撃・空弾属性に対して無敵/10-52F　空中判定</td>
                                </tr>
                                <tr>
                                    <td>OD 豪昇龍拳</td>
                                    <td>6</td>
                                    <td>6-16</td>
                                    <td>37+着地後15</td>
                                    <td>D</td>
                                    <td>-39</td>
                                    <td></td>
                                    <td>1700</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>-5000</td>
                                    <td>0</td>
                                    <td>1200</td>
                                    <td>上</td>
                                    <td>1-8F　完全無敵/8-53F　空中判定</td>
                                </tr>
                                <th class="techniquename">竜巻斬空脚</th>
                                <tr>
                                    <td>竜巻斬空脚 (弱)</td>
                                    <td>12</td>
                                    <td>12-13</td>
                                    <td>21</td>
                                    <td>D</td>
                                    <td>-13</td>
                                    <td></td>
                                    <td>600</td>
                                    <td>コンボ補正20%</td>
                                    <td>2000</td>
                                    <td>-4000</td>
                                    <td>-5000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td>空振り時硬直6F増加</td>
                                </tr>
                                <tr>
                                    <td>竜巻斬空脚 (中)</td>
                                    <td>11</td>
                                    <td>11-27</td>
                                    <td>31</td>
                                    <td>D</td>
                                    <td>-13</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>コンボ補正20%</td>
                                    <td>2000</td>
                                    <td>-5000</td>
                                    <td>-5000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>竜巻斬空脚 (強)</td>
                                    <td>7</td>
                                    <td>7-51</td>
                                    <td>23+着地後12</td>
                                    <td>D</td>
                                    <td>-59</td>
                                    <td></td>
                                    <td>1600</td>
                                    <td></td>
                                    <td>2000</td>
                                    <td>-5000</td>
                                    <td>-5000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>OD 竜巻斬空脚</td>
                                    <td>13</td>
                                    <td>13-37</td>
                                    <td>26</td>
                                    <td>D</td>
                                    <td>-17</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>-4000</td>
                                    <td>-10000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <th class="techniquename">空中竜巻斬空脚</th>
                                <tr>
                                    <td>空中竜巻斬空脚</td>
                                    <td>11</td>
                                    <td>11–26</td>
                                    <td>着地後16</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                    <td>900</td>
                                    <td>始動補正30%</td>
                                    <td>2000</td>
                                    <td>-4000</td>
                                    <td>-5000</td>
                                    <td>600</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>OD 空中竜巻斬空脚</td>
                                    <td>11</td>
                                    <td>11–28</td>
                                    <td>着地後16</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                    <td>1300</td>
                                    <td>コンボ補正20%</td>
                                    <td>0</td>
                                    <td>-4000</td>
                                    <td>-10000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <th class="techniquename">金剛灼火</th>
                                <tr>
                                    <td>弱 金剛灼火（1段目）</td>
                                    <td>15</td>
                                    <td>15-17</td>
                                    <td>23</td>
                                    <td>1</td>
                                    <td>-8</td>
                                    <td>SA3</td>
                                    <td>700</td>
                                    <td></td>
                                    <td>500</td>
                                    <td>-6000</td>
                                    <td>-6000</td>
                                    <td>500</td>
                                    <td>上</td>
                                    <td>19-22F ヒット時専用技に派生可</td>
                                </tr>
                                <tr>
                                    <td>弱 金剛灼火（2段目）</td>
                                    <td>7</td>
                                    <td>7-10</td>
                                    <td>18</td>
                                    <td>3</td>
                                    <td>-10</td>
                                    <td>SA3</td>
                                    <td>500</td>
                                    <td></td>
                                    <td>500</td>
                                    <td>-4000</td>
                                    <td>-7000</td>
                                    <td>500</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>中 金剛灼火（1段目）</td>
                                    <td>19</td>
                                    <td>19-21</td>
                                    <td>20</td>
                                    <td>2</td>
                                    <td>-4</td>
                                    <td>SA3</td>
                                    <td>800</td>
                                    <td></td>
                                    <td>500</td>
                                    <td>-6000</td>
                                    <td>-10000</td>
                                    <td>500</td>
                                    <td>上</td>
                                    <td>23-26F ヒット時専用技に派生可／空振り時硬直3F増加／パニッシュカウンター時+10F</td>
                                </tr>
                                <tr>
                                    <td>中 金剛灼火（2段目）</td>
                                    <td>7</td>
                                    <td>7-10</td>
                                    <td>32</td>
                                    <td>D</td>
                                    <td>-18</td>
                                    <td>SA3</td>
                                    <td>600</td>
                                    <td></td>
                                    <td>500</td>
                                    <td>-4000</td>
                                    <td>-7000</td>
                                    <td>500</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>強 金剛灼火（1段目）</td>
                                    <td>23</td>
                                    <td>23-25</td>
                                    <td>19</td>
                                    <td>3</td>
                                    <td>-3</td>
                                    <td>SA3</td>
                                    <td>900</td>
                                    <td></td>
                                    <td>500</td>
                                    <td>-6000</td>
                                    <td>-10000</td>
                                    <td>500</td>
                                    <td>上</td>
                                    <td>27-30F ヒット時専用技に派生可／空振り時硬直2F増加／パニッシュカウンター時+12F</td>
                                </tr>
                                <tr>
                                    <td>強 金剛灼火（2段目）</td>
                                    <td>11</td>
                                    <td>11-14</td>
                                    <td>28</td>
                                    <td>D</td>
                                    <td>-14</td>
                                    <td>SA3</td>
                                    <td>600</td>
                                    <td>コンボ補正30%</td>
                                    <td>500</td>
                                    <td>-4000</td>
                                    <td>-7000</td>
                                    <td>500</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>OD 金剛灼火（1段目）</td>
                                    <td>18</td>
                                    <td>18-20</td>
                                    <td>23</td>
                                    <td>1</td>
                                    <td>-3</td>
                                    <td>SA2</td>
                                    <td>700</td>
                                    <td>始動補正20%</td>
                                    <td>0</td>
                                    <td>-6000</td>
                                    <td>-10000</td>
                                    <td>500</td>
                                    <td>上</td>
                                    <td>22-25F ヒット時専用技に派生可／パニッシュカウンター時に膝崩れダウン+39F</td>
                                </tr>
                                <tr>
                                    <td>OD 金剛灼火（2段目）</td>
                                    <td>7</td>
                                    <td>7-17</td>
                                    <td>25</td>
                                    <td>D</td>
                                    <td>-18</td>
                                    <td>SA2</td>
                                    <td>700</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>-4000</td>
                                    <td>-7000</td>
                                    <td>750</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <th class="techniquename">百鬼襲</th>
                                <tr>
                                    <td>弱 百鬼襲</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>0</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>18-40Fまで、百鬼豪斬・百鬼潜影を除く派生技でキャンセル可／7F以降空中判定</td>
                                </tr>
                                <tr>
                                    <td>中 百鬼襲</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>0</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>18-40Fまで、百鬼豪斬・百鬼潜影を除く派生技でキャンセル可／7F以降空中判定</td>
                                </tr>
                                <tr>
                                    <td>強 百鬼襲</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>0</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>18-40Fまで、百鬼豪斬・百鬼潜影を除く派生技でキャンセル可／7F以降空中判定</td>
                                </tr>
                                <tr>
                                    <td>OD 百鬼襲</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>0</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td></td>
                                    <td>16-40Fまで、百鬼豪斬・百鬼潜影を除く派生技でキャンセル可／7F以降空中判定</td>
                                </tr>
                                <tr>
                                    <td>百鬼豪斬</td>
                                    <td>8</td>
                                    <td>8-11</td>
                                    <td>19</td>
                                    <td>D</td>
                                    <td>2</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>-4000</td>
                                    <td>-10000</td>
                                    <td>1000</td>
                                    <td>下</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>百鬼豪衝</td>
                                    <td>16</td>
                                    <td>16-着地まで</td>
                                    <td>着地後9</td>
                                    <td>D</td>
                                    <td>1～10</td>
                                    <td></td>
                                    <td>1300</td>
                                    <td></td>
                                    <td>1000</td>
                                    <td>-6000</td>
                                    <td>-5000</td>
                                    <td>1000</td>
                                    <td>中</td>
                                    <td>ガードさせた高度によって硬直差が変化</td>
                                </tr>
                                <tr>
                                    <td>百鬼豪刃</td>
                                    <td>13</td>
                                    <td>13-着地まで</td>
                                    <td>着地後9</td>
                                    <td>1～10</td>
                                    <td>-4～5</td>
                                    <td></td>
                                    <td>700</td>
                                    <td>※始動補正30%/コンボ補正20%</td>
                                    <td>1000</td>
                                    <td>-4000</td>
                                    <td>-5000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td>※OD百鬼襲から発動時、始動補正20%/ヒット・ガードの高度で硬直差変化／空振り時硬直+5F</td>
                                </tr>
                                <tr>
                                    <td>百鬼潜影</td>
                                    <td></td>
                                    <td></td>
                                    <td>全体5</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>0</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>相手を飛び越えて着地時硬直+5F</td>
                                </tr>
                                <tr>
                                    <td>百鬼豪斬空</td>
                                    <td>6</td>
                                    <td></td>
                                    <td>着地後9</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                    <td>900</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>-5000</td>
                                    <td>-1000</td>
                                    <td>1000</td>
                                    <td>上/空弾</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>百鬼豪螺旋</td>
                                    <td>5</td>
                                    <td>5-23</td>
                                    <td>着地後10</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                    <td>1300</td>
                                    <td>コンボ補正20%</td>
                                    <td>0</td>
                                    <td>-4000</td>
                                    <td>-1000</td>
                                    <td>1000</td>
                                    <td>上</td>
                                    <td></td>
                                </tr>
                                <th class="techniquename">阿修羅</th>
                                <tr>
                                    <td>阿修羅閃空（前方）</td>
                                    <td></td>
                                    <td></td>
                                    <td>全体51</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>0</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>阿修羅閃空（後方）</td>
                                    <td></td>
                                    <td></td>
                                    <td>全体49</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>0</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>朧（阿修羅閃空（前方）中に）弱弱</td>
                                    <td>8</td>
                                    <td>8-10</td>
                                    <td>50</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                    <td>2200</td>
                                    <td></td>
                                    <td>5000</td>
                                    <td>0</td>
                                    <td>-10000</td>
                                    <td>3000</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-wrapper">
                        <table class="move-table">
                            <thead>
                                <tr>
                                    <th>技名</th>
                                    <th>発生</th>
                                    <th>持続</th>
                                    <th>硬直</th>
                                    <th>ヒット</th>
                                    <th>ガード</th>
                                    <th>キャンセル</th>
                                    <th>ダメージ</th>
                                    <th>補正</th>
                                    <th>Dゲージ増(ヒット)</th>
                                    <th>Dゲージ減(ガード)</th>
                                    <th>Dゲージ減(パニカン)</th>
                                    <th>SAゲージ増加</th>
                                    <th>属性</th>
                                    <th>備考</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>SA1 滅殺豪波動</td>
                                    <td>10</td>
                                    <td></td>
                                    <td>全体106</td>
                                    <td>D</td>
                                    <td>-41</td>
                                    <td></td>
                                    <td>2200</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>-2500</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>上/弾</td>
                                    <td>1-14F 打撃・投げに対して無敵<br>最低保障ダメージ30％</td>
                                </tr>
                                <tr>
                                    <td>SA1 天魔豪斬空<br>（垂直 or 前ジャンプ中に）</td>
                                    <td>14</td>
                                    <td></td>
                                    <td>着地後33</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                    <td>2000</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>-2500</td>
                                    <td>-1000</td>
                                    <td>0</td>
                                    <td>上/空弾</td>
                                    <td>最低保障ダメージ30％<br>空弾属性に対して無敵の技に当たらない</td>
                                </tr>
                                <tr>
                                    <td>SA2 崩天劫火</td>
                                    <td>9</td>
                                    <td>9-11</td>
                                    <td>52</td>
                                    <td>D</td>
                                    <td>-35</td>
                                    <td></td>
                                    <td>2800</td>
                                    <td>始動補正40%/コンボ補正40%</td>
                                    <td>0</td>
                                    <td>-5000</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>上</td>
                                    <td>1-11F 完全無敵<br>壁到達時に壁やられ<br>最低保障ダメージ40％</td>
                                </tr>
                                <tr>
                                    <td>SA3 禍坏</td>
                                    <td>8</td>
                                    <td>8-11</td>
                                    <td>58</td>
                                    <td>D</td>
                                    <td>-41</td>
                                    <td></td>
                                    <td>4000</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>-7500</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>上</td>
                                    <td>1-11F 完全無敵<br>最低保障ダメージ50％<br>※必殺技キャンセル時のみ適用</td>
                                </tr>
                                <tr>
                                    <td>CA 禍坏（体力25%以下で）</td>
                                    <td>8</td>
                                    <td>8-11</td>
                                    <td>58</td>
                                    <td>D</td>
                                    <td>-41</td>
                                    <td></td>
                                    <td>4500</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>-10000</td>
                                    <td>-3500</td>
                                    <td>0</td>
                                    <td>上</td>
                                    <td>1-11F 完全無敵<br>最低保障ダメージ50％<br>※必殺技キャンセル時のみ適用</td>
                                </tr>
                                <tr>
                                    <td>CA 瞬獄殺<br>コマンド: 弱弱弱強</td>
                                    <td>6+0</td>
                                    <td>6-27</td>
                                    <td>57</td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                    <td>4700</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>投</td>
                                    <td>1F 完全無敵<br>6-27F 飛び道具無敵<br>最低保障ダメージ50％<br>※必殺技キャンセル時のみ適用</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-wrapper">
                        <table class="move-table">
                            <thead>
                                <tr>
                                    <th>技名</th>
                                    <th>発生</th>
                                    <th>持続</th>
                                    <th>硬直</th>
                                    <th>ヒット</th>
                                    <th>ガード</th>
                                    <th>キャンセル</th>
                                    <th>ダメージ</th>
                                    <th>補正</th>
                                    <th>Dゲージ増(ヒット)</th>
                                    <th>Dゲージ減(ガード)</th>
                                    <th>Dゲージ減(パニカン)</th>
                                    <th>SAゲージ増加</th>
                                    <th>属性</th>
                                    <th>備考</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>豪衝破（近距離で）<br>弱弱</td>
                                    <td>5
                                    <td>5-7</td>
                                    <td>23</td>
                                    </td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                    <td>1200</td>
                                    <td>即時補正20%</td>
                                    <td>2000</td>
                                    <td>0</td>
                                    <td>-10000</td>
                                    <td>2000</td>
                                    <td>投</td>
                                    <td>パニッシュカウンター時：<br>ダメージ2040 / SAゲージ+4000 / ハードノックダウン</td>
                                </tr>
                                <tr>
                                    <td>朱裂刀（近距離で）<br>弱弱</td>
                                    <td>5
                                    <td>5-7</td>
                                    <td>23</td>
                                    </td>
                                    <td>D</td>
                                    <td></td>
                                    <td></td>
                                    <td>1200</td>
                                    <td>即時補正20%</td>
                                    <td>2000</td>
                                    <td>0</td>
                                    <td>-10000</td>
                                    <td>2000</td>
                                    <td>投</td>
                                    <td>パニッシュカウンター時：<br>ダメージ2040 / SAゲージ+4000 / ハードノックダウン</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-wrapper">
                        <table class="move-table">
                            <thead>
                                <tr>
                                    <th>技名</th>
                                    <th>発生</th>
                                    <th>持続</th>
                                    <th>硬直</th>
                                    <th>ヒット</th>
                                    <th>ガード</th>
                                    <th>キャンセル</th>
                                    <th>ダメージ</th>
                                    <th>補正</th>
                                    <th>Dゲージ増(ヒット)</th>
                                    <th>Dゲージ減(ガード)</th>
                                    <th>Dゲージ減(パニカン)</th>
                                    <th>SAゲージ増加</th>
                                    <th>属性</th>
                                    <th>備考</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>前方ステップ</td>
                                    <td></td>
                                    <td></td>
                                    <td>全体19</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>0</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>後方ステップ</td>
                                    <td></td>
                                    <td></td>
                                    <td>全体23</td>
                                    <td></td>
                                    <td>
                                    <td></td>
                                    </td>
                                    <td>0</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td></td>
                                    <td>1-15F 投げ無敵</td>
                                </tr>
                                <tr>
                                    <td>ドライブインパクト（鬼殺し）<br>強強</td>
                                    <td>26</td>
                                    <td>26-27</td>
                                    <td>35</td>
                                    <td>D</td>
                                    <td>-3</td>
                                    <td></td>
                                    <td>800</td>
                                    <td>始動補正20%</td>
                                    <td>0</td>
                                    <td>-5000</td>
                                    <td>-15000</td>
                                    <td>0</td>
                                    <td>上</td>
                                    <td>1-27F アーマー判定（2回）<br>ステージ端で壁やられ発生<br>パニッシュ or アーマー成立時：<br>地上ヒット膝崩れ / 空中ヒット吹き飛び時間増加 / SA+3000</td>
                                </tr>
                                <tr>
                                    <td>[ガード時]ドライブリバーサル（双破）<br>強強</td>
                                    <td>20</td>
                                    <td>20-22</td>
                                    <td>26</td>
                                    <td>D</td>
                                    <td>-6</td>
                                    <td></td>
                                    <td>500</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>上</td>
                                    <td>リカバリアブルダメージ<br>1-22F 完全無敵<br>ヒット時 硬直+5F</td>
                                </tr>
                                <tr>
                                    <td>[起き上がり時]ドライブリバーサル（双破）<br>強強</td>
                                    <td>18</td>
                                    <td>18-20</td>
                                    <td>26</td>
                                    <td>D</td>
                                    <td>-6</td>
                                    <td></td>
                                    <td>500</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>上</td>
                                    <td>リカバリアブルダメージ<br>1-20F 完全無敵<br>ヒット時 硬直+5F</td>
                                </tr>
                                <tr>
                                    <td>ドライブパリィ<br>中中</td>
                                    <td>1</td>
                                    <td>[※2]1-12</td>
                                    <td>33</td>
                                    <td></td>
                                    <td></td>
                                    <td>※1</td>
                                    <td>0</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td></td>
                                    <td>※1 4F目からドライブラッシュキャンセル可<br>ホールド可（持続延長）<br>硬直中はガードのみ可<br>常に被パニッシュカウンター</td>
                                </tr>
                                <tr>
                                    <td>ジャストパリィ（打撃）<br>中中</td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>0</td>
                                    <td>始動補正50%</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>入力Fまたは次Fで成立<br>硬直終了から5F間 無敵<br>成立された側：<br>キャンセル不可 / 強制パニッシュカウンター</td>
                                </tr>
                                <tr>
                                    <td>ジャストパリィ（飛び道具）<br>中中</td>
                                    <td>1</td>
                                    <td></td>
                                    <td>10</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>0</td>
                                    <td>始動補正50%</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>入力Fまたは次Fで成立<br>暗転なし<br>成立された側：<br>キャンセル不可 / 強制パニッシュカウンター</td>
                                </tr>
                                <tr>
                                    <td>パリィドライブラッシュ</td>
                                    <td></td>
                                    <td></td>
                                    <td>全体45</td>
                                    <td></td>
                                    <td></td>
                                    <td>※</td>
                                    <td>0</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td></td>
                                    <td>暗転10F<br>9F目～攻撃行動キャンセル可<br>24F目～パリィ以外の行動キャンセル可</td>
                                </tr>
                                <tr>
                                    <td>キャンセルドライブラッシュ<br>中中</td>
                                    <td></td>
                                    <td></td>
                                    <td>全体46</td>
                                    <td></td>
                                    <td></td>
                                    <td>※</td>
                                    <td>0</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td></td>
                                    <td>暗転9F<br>10F目～攻撃行動キャンセル可<br>25F目～パリィ以外の行動キャンセル可</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
            <div class="right">
                <img class="ad-right" src="https://placehold.jp/300x250.png" alt="広告">
                <img class="ad-right" src="https://placehold.jp/300x600.png" alt="広告">
                <div class="right-table sticky">
                    <nav class="section-nav">
                        <span class="nav-label">セクション一覧</span>
                        <ul>
                            <li><a href="#analysis">強み・弱み</a></li>
                            <li><a href="#movement">立ち回り</a></li>
                            <li><a href="#lethal">リーサル判断</a></li>
                            <li><a href="#combos">コンボ集</a></li>
                            <li><a href="#okizeme">起き攻め</a></li>
                            <li><a href="#setup">セットアップ</a></li>
                            <li><a href="#countermeasure">キャラ対策</a></li>
                            <li><a href="#framedata">フレームデータ</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="right-table sticky sticky-secod">
                    <div class="list right-table-contents">

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php include_once(__DIR__ . '/../partials/footer.php'); ?>
    <?php include_once(__DIR__ . '/../partials/javascript.php'); ?>
</body>

</html>