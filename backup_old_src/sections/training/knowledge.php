<?php
/**
 * 知識セクション
 * トレーニングモードの基礎知識
 */
?>
                <!-- 知識セクション -->
                <section id="knowledge" class="guide-section training-section">
                    <div class="guide-section-header">
                        <span class="guide-section-icon">📚</span>
                        <h2 class="guide-section-title">トレーニングモードの基礎知識</h2>
                    </div>

                    <!-- タブUI -->
                    <div class="tabs-container">
                        <div class="tabs-header">
                            <button class="tab-btn active" data-tab="frame-meter">フレームメーター</button>
                            <button class="tab-btn" data-tab="settings">推奨設定</button>
                        </div>

                        <div class="tabs-content">
                            <!-- フレームメータータブ -->
                            <div class="tab-panel active" id="tab-frame-meter">
                                <div class="c-card">
                                    <h3 class="guide-subsection-title">🎯 フレームメーターの読み方</h3>
                                    
                                    <p class="text-secondary" style="margin-bottom: 1.5rem;">
                                        トレーニングモードで表示される「フレームメーター」は、技の性能を視覚的に理解するための重要なツールです。
                                    </p>

                                    <div class="frame-meter-guide">
                                        <div class="frame-meter-item">
                                            <div class="frame-color-box" style="background: #4A90E2;"></div>
                                            <div class="frame-info">
                                                <h4 class="frame-label">青色：発生フレーム</h4>
                                                <p class="text-secondary">技が出始めるまでの時間。数値が小さいほど速い技です。</p>
                                            </div>
                                        </div>

                                        <div class="frame-meter-item">
                                            <div class="frame-color-box" style="background: #50C878;"></div>
                                            <div class="frame-info">
                                                <h4 class="frame-label">緑色：持続フレーム</h4>
                                                <p class="text-secondary">攻撃判定が出ている時間。長いほど当てやすい技です。</p>
                                            </div>
                                        </div>

                                        <div class="frame-meter-item">
                                            <div class="frame-color-box" style="background: #E74C3C;"></div>
                                            <div class="frame-info">
                                                <h4 class="frame-label">赤色：硬直フレーム</h4>
                                                <p class="text-secondary">技の後の隙。長いほどリスクが高い技です。</p>
                                            </div>
                                        </div>

                                        <div class="advantage-guide" style="margin-top: 2rem; padding: 1.5rem; background: var(--bg-tertiary); border-radius: var(--radius-md);">
                                            <h4 style="color: var(--accent-gold); margin-bottom: 1rem;">📊 有利・不利フレームとは</h4>
                                            <ul style="list-style: none; padding: 0;">
                                                <li style="padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                                                    <strong style="color: var(--success);">+3（有利）</strong>：こちらが3フレーム先に動ける
                                                </li>
                                                <li style="padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                                                    <strong style="color: var(--text-muted);">±0（五分）</strong>：同時に動ける
                                                </li>
                                                <li style="padding: 0.5rem 0;">
                                                    <strong style="color: var(--error);">-2（不利）</strong>：相手が2フレーム先に動ける
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 推奨設定タブ -->
                            <div class="tab-panel" id="tab-settings">
                                <div class="c-card">
                                    <h3 class="guide-subsection-title">⚙️ トレモ推奨設定</h3>

                                    <div class="settings-section">
                                        <h4 style="color: var(--secondary); margin-bottom: 1rem;">🎮 ショートカット設定</h4>
                                        <p class="text-secondary" style="margin-bottom: 1rem;">
                                            以下のショートカットを設定すると練習効率が劇的に向上します。
                                        </p>
                                        
                                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 2rem;">
                                            <thead>
                                                <tr style="background: var(--bg-tertiary); border-bottom: 2px solid var(--border-color);">
                                                    <th style="padding: 1rem; text-align: left;">ボタン</th>
                                                    <th style="padding: 1rem; text-align: left;">機能</th>
                                                    <th style="padding: 1rem; text-align: left;">おすすめ度</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style="border-bottom: 1px solid var(--border-color);">
                                                    <td style="padding: 1rem;"><strong>L3（左スティック押し込み）</strong></td>
                                                    <td style="padding: 1rem;">位置リセット</td>
                                                    <td style="padding: 1rem;"><span style="color: var(--accent-gold);">★★★</span> 必須</td>
                                                </tr>
                                                <tr style="border-bottom: 1px solid var(--border-color);">
                                                    <td style="padding: 1rem;"><strong>R3（右スティック押し込み）</strong></td>
                                                    <td style="padding: 1rem;">レコード開始/終了</td>
                                                    <td style="padding: 1rem;"><span style="color: var(--accent-gold);">★★★</span> 必須</td>
                                                </tr>
                                                <tr style="border-bottom: 1px solid var(--border-color);">
                                                    <td style="padding: 1rem;"><strong>タッチパッド</strong></td>
                                                    <td style="padding: 1rem;">ダミーレコード再生</td>
                                                    <td style="padding: 1rem;"><span style="color: var(--accent-gold);">★★☆</span> 推奨</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <h4 style="color: var(--secondary); margin-bottom: 1rem;">🛡️ ダミー設定のコツ</h4>
                                        <div style="padding: 1rem; background: rgba(0, 255, 255, 0.05); border-left: 3px solid var(--secondary); border-radius: var(--radius-sm); margin-bottom: 1.5rem;">
                                            <p class="text-secondary">
                                                <strong>ガード設定：</strong> 初心者は「しゃがみガード」から始めましょう
                                            </p>
                                            <p class="text-secondary">
                                                <strong>受け身設定：</strong> 「ランダム」にすると実戦的な練習ができます
                                            </p>
                                            <p class="text-secondary">
                                                <strong>CPU行動：</strong> 最初は「待機」、慣れたら「レコード」を活用
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Next Step -->
                    <div class="next-step-cta" style="margin-top: 3rem; padding: 2rem; background: linear-gradient(135deg, rgba(0, 255, 255, 0.1) 0%, rgba(255, 0, 255, 0.1) 100%); border-radius: 12px; border: 1px solid rgba(0, 255, 255, 0.2);">
                        <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                            トレモの基礎知識を確認できました。次はあなたに合った練習メニューを探しましょう
                        </p>
                        <a href="#navigation" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                            <span>練習メニューを探す</span>
                            <span>→</span>
                        </a>
                    </div>
                </section>
