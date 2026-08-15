<?php
/**
 * 設定セクション
 * オプション設定・バトル設定・コントローラー設定
 */
?>
                <section id="settings" class="guide-section">
                    <div class="guide-section-header">
                        <span class="guide-section-icon">⚡</span>
                        <h2 class="guide-section-title">設定</h2>
                    </div>

                    <!-- オプション設定 -->
                    <div class="guide-subsection">
                        <h3 class="guide-subsection-title">オプション設定</h3>
                        <!-- 絶対に変えるべき設定 -->
                        <h2>変えるべきオプション設定</h2>
                        <div class="critical-list">
                            <div class="critical-item">
                            <div class="img-placeholder"><img src="./img/option/changes-delayreduction.jpg" alt="入力遅延軽減設定画像"></div>
                            <div class="item-info">
                                <h4>入力遅延の軽減をONにする <span class="rec-tag">推奨</span></h4>
                                <p>ボタンを押してから技が出るまでのラグを減らします。※スペック不足で画面が乱れる場合はOFFへ。</p>
                            </div>
                            </div>
                            <div class="critical-item">
                            <div class="img-placeholder"><img src="./img/option/changes-framerate.jpg" alt="フレームレート設定画像"></div>
                            <div class="item-info">
                                <h4>MAXフレームレート：120</h4>
                                <p>120FPS対応モニターなら動きが滑らかに。出ない場合はPCスペックに合わせます。</p>
                            </div>
                            </div>
                            <div class="critical-item">
                            <div class="img-placeholder"><img src="./img/option/changes-seaudio.jpg" alt="SE音量設定画像"></div>
                            <div class="item-info">
                                <h4>SA・ドライブSE音量を上げる</h4>
                                <p>音量を上げることで、インパクトやSAの発生を「音」で察知しやすくなります。</p>
                            </div>
                            </div>
                            <div class="critical-item">
                            <div class="img-placeholder"><img src="./img/option/changes-delayreduction.jpg" alt="離し入力設定画像"></div>
                            <div class="item-info">
                                <h4>離し入力設定：基本OFF</h4>
                                <p>コマンドの正確性を高めます。技が出にくいと感じる人だけONを試しましょう。</p>
                            </div>
                            </div>
                        </div>

                        <!-- その他変えるべき設定 -->
                        <h2>その他自分に合わせて調整</h2>
                        <div class="other-grid">
                            <div class="mini-card"><h5>GAME</h5><p>バトルHUBやゲーム全体の設定変更。</p></div>
                            <div class="mini-card"><h5>CONTROL</h5><p>キーコンフィグや基本操作タイプの設定。</p></div>
                            <div class="mini-card"><h5>CAMERA</h5><p>ストーリー等でのキャラ追従カメラ設定。</p></div>
                            <div class="mini-card"><h5>DISPLAY</h5><p>画面の明るさや、対戦中の揺れ調整。</p></div>
                            <div class="mini-card"><h5>AUDIO</h5><p>各音量を細かくミキシングできます。</p></div>
                            <div class="mini-card"><h5>GRAPHIC</h5><p>画質クオリティと負荷のバランス調整。</p></div>
                        </div>
                    </div>

                    <!-- バトル設定 -->
                    <div class="guide-subsection">
                        <h3 class="guide-subsection-title">バトル設定</h3>
                        <div class="card">
                            設定方法
                            キーボードの「R」やコントローラーの「✖」でバトル設定を開くことができます。
                        </div>

                        <div class="container">
                            <h1>⚡バトル設定ガイド</h1>

                            <div class="tabs">
                                <div class="tab" data-index="0">マッチング設定</div>
                                <div class="tab" data-index="1">キャラクター設定</div>
                                <div class="tab" data-index="2">その他</div>
                                <div class="tab" data-index="3">ファイタープロフィール設定</div>
                            </div>

                            <div class="slider-container">
                                <button class="nav-btn" id="prevBtn">‹</button>
                                <div class="slider-wrapper">
                                    <div class="slider-track" id="sliderTrack">
                                        <!-- マッチング設定 -->
                                        <div class="slider-card data-index=0">
                                            <h3>マッチング設定</h3>
                                            <table class="setting-table">
                                                <tr>
                                                <th>検索範囲</th>
                                                <td>狭い地域<span class="badge-rec">推奨</span>
                                                    <span class="note-text">日本国内のプレイヤーと当たりやすくなり、ラグが最小限に抑えられます。</span>
                                                </td>
                                                </tr>
                                                <tr>
                                                <th>通信状態</th>
                                                <td>4〜5
                                                    <span class="note-text">対戦相手の通信環境を指定します。4以上ならほぼ快適にプレイ可能です。</span>
                                                </td>
                                                </tr>
                                                <tr>
                                                <th>対戦相手確認</th>
                                                <td>ON<span class="badge-rec">推奨</span>
                                                    <span class="note-text">承認前に相手の回線状況を確認できるため、予期せぬラグを回避できます。</span>
                                                </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <!-- キャラクター設定 -->
                                        <div class="slider-card" data-index="1">
                                            <h3>キャラクター設定</h3>
                                            <p>バトルを彩るカスタマイズ項目です。</p>
                                            <div class="setting-item-box">
                                                <h4>コスチューム・カラー</h4>
                                                <span class="note-text">入手済みのOutfitやカラー番号を変更できます。</span>
                                            </div>
                                            <div class="setting-item-box">
                                                <h4>称号・乱入演出</h4>
                                                <span class="note-text">自分だけの個性をアピール。称号やカットインを自由に入れ替え可能です。</span>
                                            </div>
                                            <div class="setting-item-box">
                                                <h4>コントローラー設定</h4>
                                                <span class="note-text">ボタン配置や、モダン/クラシックの切り替えをここで行います。</span>
                                            </div>
                                        </div>

                                        <!-- その他 -->
                                        <div class="slider-card" data-index="2">
                                            <h3>その他</h3>
                                            <div class="setting-item-box">
                                                <h4>ステージ設定：トレーニングルーム <span class="badge-rec">推奨</span></h4>
                                                <span class="note-text">視認性が高く、壁の位置などが分かりやすいため対戦に集中できます。</span>
                                            </div>
                                            <div class="setting-item-box">
                                                <h4>実況設定：基本OFF</h4>
                                                <span class="note-text">基本は好みですが、ONにするとゲージ状況を声で教えてくれるメリットも。</span>
                                            </div>
                                            <div class="setting-item-box">
                                                <h4>サイド設定：1P / 2P</h4>
                                                <span class="note-text">最初は得意な側を固定するのがおすすめ。相手と被った場合はランダムになります。</span>
                                            </div>
                                        </div>

                                        <!-- ファイタープロフィール設定 -->
                                        <div class="slider-card" data-index="3">
                                            <h3>ファイタープロフィール設定</h3>
                                            <p>自分のオンライン上の名刺をカスタマイズします。</p>
                                            <div class="setting-item-box" style="border-left: 2px solid var(--sf6-purple);">
                                                <h4>ユーザーIDの編集</h4>
                                                <span class="note-text">自分のプロフィール画面を好きなアイコンやプレートで装飾できます。</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="nav-btn" id="nextBtn">›</button>
                            </div>
                        </div>
                    </div>

                    <!-- コントローラー設定 -->
                    <div class="guide-subsection">
                        <h3 class="guide-subsection-title">コントローラー設定</h3>
                        <div class="c-card">
                            OPTIONの中のCONTOLからコントローラーの操作設定が可能です。<br>おすすめの設定を記載していますがやっていくうちに自分に合った設定にしていくのがいいと思います
                        </div>

                        <!-- ゲームパッド -->
                        <div class="guide-subsection">
                            <div class="setting-item-name">ゲームパッド</div>
                            <div class="setting-item-description">
                                十字キーで方向入力、ボタンで攻撃。L1/R1に投げやドライブインパクトを割り当てるのが一般的
                            </div>
                            <div class="setting-grid">
                                <div class="setting-card">
                                    <div class="setting-image modern">
                                        <img src="./img/keyconfig/modern-pad.jpg" alt="パッド(モダン)">
                                    </div>
                                    <div class="setting-card-header">
                                        <h4>モダン</h4>
                                    </div>
                                    <div class="setting-content">
                                    </div>                           
                                </div>
                                <div class="setting-card">
                                    <div class="setting-image classic">
                                        <img src="./img/keyconfig/classic-pad.jpg" alt="パッド(クラシック)">
                                    </div>
                                    <div class="setting-card-header">
                                        <h4>クラシック</h4>
                                    </div>
                                    <div class="setting-content">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- アーケードコントローラー -->
                        <div class="guide-subsection">
                            <div class="setting-item-name">アーケードコントローラー</div>
                            <div class="setting-item-description">
                                レバーで方向入力、ボタンで攻撃。弱・中・強パンチ/キックを上下2段に配置
                            </div>
                            <div class="setting-grid">
                                <div class="setting-card">
                                    <div class="setting-image modern">
                                        <img src="./img/keyconfig/modern-leverless.jpg" alt="アーケードコントローラー(モダン)">
                                    </div>
                                    <div class="setting-card-header">
                                        <h4>モダン</h4>
                                    </div>
                                    <div class="setting-content">
                                    </div>                           
                                </div>
                                <div class="setting-card">
                                    <div class="setting-image classic">
                                        <img src="./img/keyconfig/classic-leverless.jpg" alt="アーケードコントローラー(クラシック)">
                                    </div>
                                    <div class="setting-card-header">
                                        <h4>クラシック</h4>
                                    </div>
                                    <div class="setting-content">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- キーボード -->
                        <div class="guide-subsection">
                            <div class="setting-item-name">キーボード</div>
                            <div class="setting-item-description">
                                WASDで方向入力が一般的。スペースバーにジャンプを割り当てる人も
                            </div>
                            <div class="setting-grid">
                                <div class="setting-card">
                                    <div class="setting-image modern">
                                        <img src="./img/keyconfig/modern-keyboard.jpg" alt="パッド(モダン)">
                                    </div>
                                    <div class="setting-card-header">
                                        <h4>モダン</h4>
                                    </div>
                                    <div class="setting-content">
                                    </div>                           
                                </div>
                                <div class="setting-card">
                                    <div class="setting-image classic">
                                        <img src="./img/keyconfig/classic-keyboard.jpg" alt="パッド(クラシック)">
                                    </div>
                                    <div class="setting-card-header">
                                        <h4>クラシック</h4>
                                    </div>
                                    <div class="setting-content">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>