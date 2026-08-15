<?php
/**
 * 練習メニューセクション
 * JSON連携で練習メニューをカード形式で表示
 */
?>
                <!-- 練習メニューセクション -->
                <section id="menu" class="guide-section training-section">
                    <div class="guide-section-header">
                        <span class="guide-section-icon">💪</span>
                        <h2 class="guide-section-title">練習メニュー</h2>
                    </div>

                    <p class="text-secondary" style="margin-bottom: 2rem;">
                        各メニューの「習得済み」にチェックを入れると、次回訪問時も記録が残ります。自分のペースで確実にステップアップしましょう。
                    </p>

                    <div class="menu-grid" id="menuGrid">
                        <?php if (isset($trainMenus['menus']) && is_array($trainMenus['menus'])): ?>
                            <?php foreach ($trainMenus['menus'] as $menu): ?>
                                <div class="c-card" 
                                     data-category="<?php echo h($menu['category']); ?>"
                                     data-rank="<?php echo h($menu['rank']); ?>"
                                     data-duration="<?php echo h($menu['duration']); ?>"
                                     data-problem="<?php echo h($menu['problem'] ?? ''); ?>">
                                    
                                    <!-- カードヘッダー -->
                                    <div class="c-card__header">
                                        <span class="menu-category badge-<?php echo h($menu['category']); ?>">
                                            <?php echo h($menu['category_label']); ?>
                                        </span>
                                        <label class="mastered-label">
                                            <input type="checkbox" class="mastered-check" 
                                                   data-menu-id="<?php echo h($menu['id']); ?>">
                                            <span class="mastered-text">習得済み</span>
                                        </label>
                                    </div>

                                    <!-- タイトル -->
                                    <h3 class="menu-title"><?php echo h($menu['title']); ?></h3>

                                    <!-- メタ情報 -->
                                    <div class="menu-meta">
                                        <span class="menu-rank">
                                            <span class="icon">🎖️</span>
                                            <?php echo h($menu['rank_label']); ?>
                                        </span>
                                        <span class="menu-duration">
                                            <span class="icon">⏱️</span>
                                            <?php echo h($menu['duration']); ?>分
                                        </span>
                                    </div>

                                    <!-- 目的 -->
                                    <p class="menu-objective"><?php echo h($menu['objective']); ?></p>

                                    <!-- アコーディオン: レコード設定 -->
                                    <details class="menu-accordion">
                                        <summary>
                                            <span class="icon">📹</span>
                                            <span>レコード設定</span>
                                        </summary>
                                        <div class="menu-accordion-content">
                                            <?php echo nl2br(h($menu['dummy_setting'])); ?>
                                        </div>
                                    </details>

                                    <!-- アコーディオン: 実践のコツ -->
                                    <details class="menu-accordion">
                                        <summary>
                                            <span class="icon">💡</span>
                                            <span>実践のコツ</span>
                                        </summary>
                                        <div class="menu-accordion-content">
                                            <?php echo nl2br(h($menu['tips'])); ?>
                                        </div>
                                    </details>

                                    <!-- リンク -->
                                    <div class="menu-links">
                                        <a href="<?php echo h($menu['related_matchup']); ?>" class="menu-link">
                                            <span>キャラ別のコツを見る</span>
                                            <span>→</span>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="card" style="grid-column: 1 / -1;">
                                <p class="text-secondary">練習メニューが見つかりませんでした。</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- フィルター結果表示 -->
                    <div id="noResults" class="no-results" style="display: none; grid-column: 1 / -1; text-align: center; padding: 3rem;">
                        <p style="font-size: var(--font-size-xl); color: var(--text-muted);">
                            😔 該当する練習メニューが見つかりませんでした
                        </p>
                        <p class="text-secondary" style="margin-top: 1rem;">
                            別のフィルターを選択してください
                        </p>
                    </div>

                    <!-- Next Step -->
                    <div class="next-step-cta" style="margin-top: 3rem; padding: 2rem; background: linear-gradient(135deg, rgba(0, 255, 255, 0.1) 0%, rgba(255, 0, 255, 0.1) 100%); border-radius: 12px; border: 1px solid rgba(0, 255, 255, 0.2);">
                        <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                            練習メニューを確認できました。次は毎日のルーティーンで継続していきましょう
                        </p>
                        <a href="#routine" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                            <span>ルーティーンを見る</span>
                            <span>→</span>
                        </a>
                    </div>
                </section>
