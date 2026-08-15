<?php
/**
 * デバイス紹介セクション
 * パッド・アケコン・レバーレスの特徴と比較
 * $devicesData変数が必要
 */
?>
                <section id="devices" class="guide-section">
                    <div class="guide-section-header">
                        <span class="guide-section-icon">🎮</span>
                        <h2 class="guide-section-title">デバイス紹介</h2>
                    </div>

                    <?php if ($devicesData): ?>
                        <?php foreach ($devicesData as $device): ?>
                            <div class="guide-subsection">
                                <h3 class="guide-subsection-title"><?php echo h($device['title']); ?></h3>
                                
                                <div class="c-card">
                                    <div class="c-card__header">
                                        <h4 class="c-card__title">特徴</h4>
                                    </div>
                                    
                                    <div class="device-lists">
                                        <?php if (!empty($device['merit'])): ?>
                                            <div>
                                                <strong style="color: var(--positive); margin-bottom: 0.5rem; display: block;">✓ メリット</strong>
                                                <?php foreach ($device['merit'] as $item): ?>
                                                    <div class="device-list-item"><?php echo h($item); ?></div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($device['demerit'])): ?>
                                            <div style="margin-top: 1rem;">
                                                <strong style="color: var(--negative); margin-bottom: 0.5rem; display: block;">× デメリット</strong>
                                                <?php foreach ($device['demerit'] as $item): ?>
                                                    <div class="device-list-item demerit"><?php echo h($item); ?></div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($device['recommend'])): ?>
                                            <div style="margin-top: 1rem; padding: 1rem; background: rgba(0, 255, 255, 0.1); border-left: 3px solid var(--secondary); border-radius: 4px;">
                                                <strong style="color: var(--secondary); margin-bottom: 0.5rem; display: block;">💡 おすすめポイント</strong>
                                                <?php foreach ($device['recommend'] as $item): ?>
                                                    <div style="color: var(--text-secondary);"><?php echo h($item); ?></div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if (!empty($device['controller'])): ?>
                                    <div class="controller-grid">
                                        <?php foreach ($device['controller'] as $controller): ?>
                                            <div class="controller-card">
                                                <div class="controller-image">
                                                    <?php if (!empty($controller['img'])): ?>
                                                        <img src="img/device/<?php echo h($controller['img']); ?>.jpg" 
                                                             alt="<?php echo h($controller['name']); ?>" 
                                                             style="height: 100%; object-fit: cover;"
                                                             onerror="this.parentElement.innerHTML='画像準備中'">
                                                    <?php else: ?>
                                                        画像準備中
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <div class="controller-content">
                                                    <h5 class="controller-name"><?php echo h($controller['name']); ?></h5>
                                                    
                                                    <?php if (!empty($controller['pluspoint'])): ?>
                                                        <div class="controller-points">
                                                            <strong style="color: var(--positive); font-size: 0.875rem; display: block; margin-bottom: 0.5rem;">良い点</strong>
                                                            <?php foreach ($controller['pluspoint'] as $point): ?>
                                                                <div class="controller-point plus"><?php echo h($point); ?></div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (!empty($controller['minuspoint'])): ?>
                                                        <div class="controller-points">
                                                            <strong style="color: var(--negative); font-size: 0.875rem; display: block; margin-bottom: 0.5rem;">注意点</strong>
                                                            <?php foreach ($controller['minuspoint'] as $point): ?>
                                                                <div class="controller-point minus"><?php echo h($point); ?></div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <div class="controller-links">
                                                        <?php if (!empty($controller['amazon'])): ?>
                                                            <a href="<?php echo h($controller['amazon']); ?>" 
                                                               target="_blank" 
                                                               rel="noopener" 
                                                               class="controller-link amazon">
                                                                Amazon
                                                            </a>
                                                        <?php endif; ?>
                                                        
                                                        <?php if (!empty($controller['rakuten'])): ?>
                                                            <a href="<?php echo h($controller['rakuten']); ?>" 
                                                               target="_blank" 
                                                               rel="noopener" 
                                                               class="controller-link rakuten">楽天</a>
                                                        <?php endif; ?>
                                                        
                                                        <?php if (!empty($controller['official'])): ?>
                                                            <a href="<?php echo h($controller['official']); ?>" 
                                                               target="_blank" 
                                                               rel="noopener" 
                                                               class="controller-link official">
                                                                公式
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Next Step -->
                    <div class="next-step-cta" style="margin-top: 3rem; padding: 2rem; background: linear-gradient(135deg, rgba(0, 255, 255, 0.1) 0%, rgba(255, 0, 255, 0.1) 100%); border-radius: 12px; border: 1px solid rgba(0, 255, 255, 0.2);">
                        <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                            デバイスが決まったら、次は操作タイプを選びましょう
                        </p>
                        <a href="#operation-types" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                            <span>操作タイプを選ぶ</span>
                            <span>→</span>
                        </a>
                    </div>
                </section>

                <!-- コンテンツ間広告 -->
                <div class="ad-space rectangle ad-between-content">
                    広告スペース (336x280)
                </div>

                <!-- 操作タイプセクション -->
