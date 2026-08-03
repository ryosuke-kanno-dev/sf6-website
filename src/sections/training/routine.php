<?php
/**
 * ルーティーンセクション
 * 毎日の練習ルーティーン提案
 */
?>
                <!-- ルーティーンセクション -->
                <section id="routine" class="guide-section training-section">
                    <div class="guide-section-header">
                        <span class="guide-section-icon">📅</span>
                        <h2 class="guide-section-title">毎日のルーティーン</h2>
                    </div>

                    <p class="text-secondary" style="margin-bottom: 2rem;">
                        「今日は何を練習しよう？」と迷わないために、レベル別のおすすめルーティーンを用意しました。
                        対戦前の5分でも、確実に上達につながります。
                    </p>

                    <!-- ルーティーンタブ -->
                    <div class="routine-tabs tabs-container">
                        <div class="tabs-header">
                            <button class="tab-btn active" data-tab="beginner">🔰 初級（10分）</button>
                            <button class="tab-btn" data-tab="intermediate">🥈 中級（20分）</button>
                            <button class="tab-btn" data-tab="advanced">💎 上級（30分）</button>
                        </div>

                        <div class="tabs-content">
                            <!-- 初級ルーティーン -->
                            <div class="tab-panel active" id="tab-beginner">
                                <div class="c-card">
                                    <h3 style="color: var(--accent-gold); margin-bottom: 1.5rem;">
                                        🔰 初級ルーティーン（10分）
                                    </h3>
                                    <p class="text-secondary" style="margin-bottom: 1.5rem;">
                                        初心者が最優先で身につけるべき基礎スキルのセット。
                                        毎日これだけやれば確実に上達します。
                                    </p>

                                    <ol class="routine-list">
                                        <li class="routine-item">
                                            <div class="routine-item-header">
                                                <span class="routine-number">1</span>
                                                <strong>対空練習</strong>
                                                <span class="routine-time">5分</span>
                                            </div>
                                            <p class="routine-description">
                                                ジャンプ攻撃を落とす基礎。10回中7回成功を目標に。
                                            </p>
                                        </li>

                                        <li class="routine-item">
                                            <div class="routine-item-header">
                                                <span class="routine-number">2</span>
                                                <strong>投げ抜け練習</strong>
                                                <span class="routine-time">3分</span>
                                            </div>
                                            <p class="routine-description">
                                                投げられる前に抜ける反応速度を鍛える。
                                            </p>
                                        </li>

                                        <li class="routine-item">
                                            <div class="routine-item-header">
                                                <span class="routine-number">3</span>
                                                <strong>基本コンボ確認</strong>
                                                <span class="routine-time">2分</span>
                                            </div>
                                            <p class="routine-description">
                                                メインキャラの3ヒットコンボを5回通す。
                                            </p>
                                        </li>
                                    </ol>

                                    <div class="routine-tip" style="margin-top: 1.5rem; padding: 1rem; background: rgba(0, 255, 255, 0.05); border-left: 3px solid var(--secondary); border-radius: var(--radius-sm);">
                                        <p style="color: var(--text-secondary);">
                                            <strong style="color: var(--secondary);">💡 ポイント：</strong>
                                            完璧を目指さず、まずは継続が大事。3日坊主にならないよう、短時間でOK。
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- 中級ルーティーン -->
                            <div class="tab-panel" id="tab-intermediate">
                                <div class="c-card">
                                    <h3 style="color: var(--accent-gold); margin-bottom: 1.5rem;">
                                        🥈 中級ルーティーン（20分）
                                    </h3>
                                    <p class="text-secondary" style="margin-bottom: 1.5rem;">
                                        基礎ができた人向け。攻めと守りのバランスを整える練習セット。
                                    </p>

                                    <ol class="routine-list">
                                        <li class="routine-item">
                                            <div class="routine-item-header">
                                                <span class="routine-number">1</span>
                                                <strong>対空＋確定反撃</strong>
                                                <span class="routine-time">7分</span>
                                            </div>
                                            <p class="routine-description">
                                                対空を落とした後のコンボまでセットで練習。
                                            </p>
                                        </li>

                                        <li class="routine-item">
                                            <div class="routine-item-header">
                                                <span class="routine-number">2</span>
                                                <strong>起き攻め練習</strong>
                                                <span class="routine-time">8分</span>
                                            </div>
                                            <p class="routine-description">
                                                ダウンを取った後の攻撃を重ねる。受け身のタイミングを覚える。
                                            </p>
                                        </li>

                                        <li class="routine-item">
                                            <div class="routine-item-header">
                                                <span class="routine-number">3</span>
                                                <strong>シミー対策</strong>
                                                <span class="routine-time">5分</span>
                                            </div>
                                            <p class="routine-description">
                                                投げシケを読まれた時の対処法を身につける。
                                            </p>
                                        </li>
                                    </ol>

                                    <div class="routine-tip" style="margin-top: 1.5rem; padding: 1rem; background: rgba(255, 140, 0, 0.05); border-left: 3px solid var(--accent-orange); border-radius: var(--radius-sm);">
                                        <p style="color: var(--text-secondary);">
                                            <strong style="color: var(--accent-orange);">💡 ポイント：</strong>
                                            実戦でよく使う状況を重点的に。ランクマ前の20分で一気にウォーミングアップ。
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- 上級ルーティーン -->
                            <div class="tab-panel" id="tab-advanced">
                                <div class="c-card">
                                    <h3 style="color: var(--accent-gold); margin-bottom: 1.5rem;">
                                        💎 上級ルーティーン（30分）
                                    </h3>
                                    <p class="text-secondary" style="margin-bottom: 1.5rem;">
                                        ハイレベルな対戦に向けた総合練習。弱点を徹底的に潰す。
                                    </p>

                                    <ol class="routine-list">
                                        <li class="routine-item">
                                            <div class="routine-item-header">
                                                <span class="routine-number">1</span>
                                                <strong>状況別コンボ</strong>
                                                <span class="routine-time">10分</span>
                                            </div>
                                            <p class="routine-description">
                                                画面端、対空ヒット、カウンターヒットなど状況別の最大コンボ。
                                            </p>
                                        </li>

                                        <li class="routine-item">
                                            <div class="routine-item-header">
                                                <span class="routine-number">2</span>
                                                <strong>確定反撃完全版</strong>
                                                <span class="routine-time">10分</span>
                                            </div>
                                            <p class="routine-description">
                                                主要キャラの-5〜-15フレームの技に対する確定反撃を網羅。
                                            </p>
                                        </li>

                                        <li class="routine-item">
                                            <div class="routine-item-header">
                                                <span class="routine-number">3</span>
                                                <strong>ドライブゲージ管理</strong>
                                                <span class="routine-time">10分</span>
                                            </div>
                                            <p class="routine-description">
                                                バーンアウト回避、パリィ・DI・キャンセルの使い分け。
                                            </p>
                                        </li>
                                    </ol>

                                    <div class="routine-tip" style="margin-top: 1.5rem; padding: 1rem; background: rgba(157, 78, 221, 0.05); border-left: 3px solid var(--accent-purple); border-radius: var(--radius-sm);">
                                        <p style="color: var(--text-secondary);">
                                            <strong style="color: var(--accent-purple);">💡 ポイント：</strong>
                                            大会前やランクアップを狙う時の集中練習。リプレイを見て苦手を分析してから臨む。
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 継続のコツ -->
                    <div class="c-card" style="margin-top: 3rem;">
                        <h3 style="color: var(--secondary); margin-bottom: 1.5rem;">
                            🔥 継続のコツ
                        </h3>
                        <div class="tips-grid" style="display: grid; gap: 1rem;">
                            <div class="tip-item" style="padding: 1rem; background: var(--bg-tertiary); border-radius: var(--radius-sm);">
                                <h4 style="color: var(--accent-gold); margin-bottom: 0.5rem;">✅ 毎日同じ時間に</h4>
                                <p class="text-secondary">ランクマ前、お風呂前など、習慣化しやすいタイミングを決める</p>
                            </div>
                            <div class="tip-item" style="padding: 1rem; background: var(--bg-tertiary); border-radius: var(--radius-sm);">
                                <h4 style="color: var(--accent-gold); margin-bottom: 0.5rem;">✅ 記録を残す</h4>
                                <p class="text-secondary">習得済みチェックやメモで成長を可視化</p>
                            </div>
                            <div class="tip-item" style="padding: 1rem; background: var(--bg-tertiary); border-radius: var(--radius-sm);">
                                <h4 style="color: var(--accent-gold); margin-bottom: 0.5rem;">✅ 完璧を求めない</h4>
                                <p class="text-secondary">70%できればOK。継続が何より大事</p>
                            </div>
                        </div>
                    </div>
                </section>
