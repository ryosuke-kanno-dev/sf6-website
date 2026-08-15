<?php
/**
 * ナビゲーションセクション
 * 悩み別・ランク別・時間別のフィルター
 */
?>
                <!-- ナビゲーションセクション -->
                <section id="navigation" class="guide-section training-section">
                    <div class="guide-section-header">
                        <span class="guide-section-icon">🎯</span>
                        <h2 class="guide-section-title">あなたに合った練習を探す</h2>
                    </div>

                    <p class="text-secondary" style="margin-bottom: 2rem;">
                        以下のフィルターから、あなたの状況に合った練習メニューを探せます。クリックすると該当するメニューが表示されます。
                    </p>

                    <div class="filter-cards-grid">
                        <!-- 悩み別フィルター -->
                        <div class="filter-card" data-filter-type="problem">
                            <h3 style="color: var(--accent-gold); margin-bottom: 1rem; font-size: var(--font-size-xl);">
                                💀 悩みから探す
                            </h3>
                            <p class="text-secondary" style="font-size: var(--font-size-sm); margin-bottom: 1rem;">
                                あなたの悩みに直結する練習メニュー
                            </p>
                            <button data-filter="defense" class="filter-btn">
                                <span class="filter-icon">🛡️</span>
                                <span>すぐやられる</span>
                            </button>
                            <button data-filter="offense" class="filter-btn">
                                <span class="filter-icon">⚔️</span>
                                <span>攻撃が当たらない</span>
                            </button>
                            <button data-filter="finish" class="filter-btn">
                                <span class="filter-icon">⚡</span>
                                <span>勝ち切れない</span>
                            </button>
                            <button data-filter="all" class="filter-btn filter-reset">
                                <span>すべて表示</span>
                            </button>
                        </div>

                        <!-- ランク別フィルター -->
                        <div class="filter-card" data-filter-type="rank">
                            <h3 style="color: var(--secondary); margin-bottom: 1rem; font-size: var(--font-size-xl);">
                                🎖️ ランクから探す
                            </h3>
                            <p class="text-secondary" style="font-size: var(--font-size-sm); margin-bottom: 1rem;">
                                あなたの現在のランクに最適な練習
                            </p>
                            <button data-filter="beginner" class="filter-btn">
                                <span class="filter-icon">🔰</span>
                                <span>ビギナー〜ブロンズ</span>
                            </button>
                            <button data-filter="silver" class="filter-btn">
                                <span class="filter-icon">🥈</span>
                                <span>シルバー〜ゴールド</span>
                            </button>
                            <button data-filter="platinum" class="filter-btn">
                                <span class="filter-icon">💎</span>
                                <span>プラチナ以上</span>
                            </button>
                            <button data-filter="all" class="filter-btn filter-reset">
                                <span>すべて表示</span>
                            </button>
                        </div>

                        <!-- 時間別フィルター -->
                        <div class="filter-card" data-filter-type="duration">
                            <h3 style="color: var(--accent-orange); margin-bottom: 1rem; font-size: var(--font-size-xl);">
                                ⏱️ 時間から探す
                            </h3>
                            <p class="text-secondary" style="font-size: var(--font-size-sm); margin-bottom: 1rem;">
                                今日の練習時間に合わせて選ぶ
                            </p>
                            <button data-filter="5" class="filter-btn">
                                <span class="filter-icon">⚡</span>
                                <span>5分コース</span>
                            </button>
                            <button data-filter="10" class="filter-btn">
                                <span class="filter-icon">🔥</span>
                                <span>10分コース</span>
                            </button>
                            <button data-filter="30" class="filter-btn">
                                <span class="filter-icon">💪</span>
                                <span>30分コース</span>
                            </button>
                            <button data-filter="all" class="filter-btn filter-reset">
                                <span>すべて表示</span>
                            </button>
                        </div>
                    </div>

                    <!-- フィルター状態表示 -->
                    <div id="filterStatus" class="filter-status" style="margin-top: 2rem; padding: 1rem; background: var(--bg-tertiary); border-radius: var(--radius-md); display: none;">
                        <p class="text-secondary">
                            <strong>フィルター:</strong> <span id="filterText">すべて</span>
                        </p>
                    </div>
                </section>
