<?php
/**
 * UI解説セクション
 * プレイ画面のUI要素解説
 */
?>
                <section id="ui-guide" class="guide-section">
                    <div class="guide-section-header">
                        <span class="guide-section-icon">🖥️</span>
                        <h2 class="guide-section-title">プレイ画面UI解説</h2>
                    </div>

                    <div class="card">
                     
                    </div>
                    <div class="container">
                    <h1>⚡ SF6 Battle UI Guide ⚡</h1>
                    
                    <div class="ui-content">
                        <div class="image-section">
                        <div class="image-container">
                            <img src="./img/start/playui.jpg" alt="SF6 Battle UI">
                            <div class="pin" data-id="1">1</div>
                            <div class="pin" data-id="2">2</div>
                            <div class="pin" data-id="3">3</div>
                            <div class="pin" data-id="4">4</div>
                            <div class="pin" data-id="5">5</div>
                            <div class="pin" data-id="6">6</div>
                            <div class="pin" data-id="7">7</div>
                            <div class="pin" data-id="8">8</div>
                            <div class="pin" data-id="9">9</div>
                            <div class="pin" data-id="10">10</div>
                        </div>
                        </div>
                        
                        <div class="ui-cards-section" id="ui-cards">
                        <div class="ui-card" data-id="1">
                            <div class="ui-card-header">
                            <div class="ui-card-number">1</div>
                            <div class="ui-card-title">タイマー</div>
                            </div>
                            <div class="ui-card-description">ラウンドの残り時間を表示。99秒からカウントダウンし、0になるとタイムオーバーで体力の多いプレイヤーが勝利します。残り10秒を切ると警告音が鳴ります。</div>
                        </div>
                        
                        <div class="ui-card" data-id="2">
                            <div class="ui-card-header">
                            <div class="ui-card-number">2</div>
                            <div class="ui-card-title">体力ゲージ</div>
                            </div>
                            <div class="ui-card-description">キャラクターの残り体力を示すバー。攻撃を受けるたびに減少し、0になるとKO負けとなります。赤いゲージが実際のダメージ、白いゲージは回復可能なダメージ(リカバラブルダメージ)を表します。</div>
                        </div>
                        
                        <div class="ui-card" data-id="3">
                            <div class="ui-card-header">
                            <div class="ui-card-number">3</div>
                            <div class="ui-card-title">体力(25%以下)</div>
                            </div>
                            <div class="ui-card-description">体力が25%を切ると、ゲージが赤く点滅して危険状態を知らせます。この状態では一部のキャラクターの性能が変化したり、特殊な演出が発生することがあります。</div>
                        </div>
                        
                        <div class="ui-card" data-id="4">
                            <div class="ui-card-header">
                            <div class="ui-card-number">4</div>
                            <div class="ui-card-title">ドライブゲージ</div>
                            </div>
                            <div class="ui-card-description">SF6独自の新システム。ドライブインパクト、ドライブパリィ、ドライブラッシュなどの強力なアクションに消費します。6本のバーで構成され、空になるとバーンアウト状態になり大きな不利を背負います。</div>
                        </div>
                        
                        <div class="ui-card" data-id="5">
                            <div class="ui-card-header">
                            <div class="ui-card-number">5</div>
                            <div class="ui-card-title">ラウンド数</div>
                            </div>
                            <div class="ui-card-description">現在何ラウンド目かを表示。通常は2本先取で試合が決着します。星のマークで獲得ラウンド数が視覚的に分かります。</div>
                        </div>
                        
                        <div class="ui-card" data-id="6">
                            <div class="ui-card-header">
                            <div class="ui-card-number">6</div>
                            <div class="ui-card-title">キャラアイコン</div>
                            </div>
                            <div class="ui-card-description">使用しているキャラクターの顔アイコン。一目でどのキャラを使っているかが分かります。KO時には暗転するなどの演出があります。</div>
                        </div>
                        
                        <div class="ui-card" data-id="7">
                            <div class="ui-card-header">
                            <div class="ui-card-number">7</div>
                            <div class="ui-card-title">操作タイプ</div>
                            </div>
                            <div class="ui-card-description">クラシック、モダン、ダイナミックのいずれかの操作タイプを表示。モダンタイプでは簡易コマンドで必殺技が出せるため、初心者でも戦いやすくなっています。</div>
                        </div>
                        
                        <div class="ui-card" data-id="8">
                            <div class="ui-card-header">
                            <div class="ui-card-number">8</div>
                            <div class="ui-card-title">SAゲージ</div>
                            </div>
                            <div class="ui-card-description">スーパーアーツゲージ。攻撃をヒットさせたり、ガードすることで溜まります。最大3本まで溜めることができ、強力なスーパーアーツの発動に必要です。</div>
                        </div>
                        
                        <div class="ui-card" data-id="9">
                            <div class="ui-card-header">
                            <div class="ui-card-number">9</div>
                            <div class="ui-card-title">CA(クリティカルアーツ)</div>
                            </div>
                            <div class="ui-card-description">キャラクター固有の超必殺技。SAゲージを消費して発動します。演出が派手で大ダメージを与えられるため、逆転の決め手となります。Level1〜3まで存在し、消費ゲージ量で威力が変わります。</div>
                        </div>
                        
                        <div class="ui-card" data-id="10">
                            <div class="ui-card-header">
                            <div class="ui-card-number">10</div>
                            <div class="ui-card-title">キャラ属性</div>
                            </div>
                            <div class="ui-card-description">キャラクターの国籍や流派などの情報が表示される場合があります。ストーリーモードやキャラセレクト画面でより詳しい情報を確認できます。</div>
                        </div>
                        </div>
                    </div>
                    </div>

                    <!-- Next Step -->
                    <div class="next-step-cta" style="margin-top: 3rem; padding: 2rem; background: linear-gradient(135deg, rgba(0, 255, 255, 0.1) 0%, rgba(255, 0, 255, 0.1) 100%); border-radius: 12px; border: 1px solid rgba(0, 255, 255, 0.2);">
                        <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                            画面の見方を覚えたら、最後に最適な設定を行いましょう
                        </p>
                        <a href="#settings" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                            <span>設定を確認</span>
                            <span>→</span>
                        </a>
                    </div>
                </section>