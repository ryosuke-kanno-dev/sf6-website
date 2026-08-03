<?php
/**
 * チュートリアルセクション
 * 初級・中級・上級チュートリアル（タブ・アコーディオン機能）
 * $tutorialsData変数が必要
 */
?>
                <section id="tutorials" class="guide-section">
                    <div class="guide-section-header">
                        <span class="guide-section-icon">📚</span>
                        <h2 class="guide-section-title">チュートリアル</h2>
                    </div>

                    <div class="tabs tutorial-tabs">
                        <button class="tutorial-tab active" data-tab="beginner">初級</button>
                        <button class="tutorial-tab" data-tab="intermediate">中級</button>
                        <button class="tutorial-tab" data-tab="advanced">上級</button>
                    </div>

                    <?php if ($tutorialsData): ?>
                        <?php foreach ($tutorialsData as $level): ?>
                            <?php 
                                // 現在の階層ディレクトリ名を取得 (beginner, intermediate, advanced)
                                $currentLevelDir = h($level['en']); 
                            ?>
                            <div class="tutorial-content <?php echo $level['en'] === 'beginner' ? 'active' : ''; ?>" 
                                id="tab-<?php echo h($level['en']); ?>">
                                
                                <?php if (!empty($level['text'])): ?>
                                    <div class="card" style="margin-bottom: 2rem;">
                                        <p><?php echo h($level['text']); ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($level['item'])): ?>
                                    <?php foreach ($level['item'] as $index => $item): ?>
                                        <div class="tutorial-accordion">
                                            <div class="tutorial-accordion-header" data-accordion="<?php echo $level['en'] . '-' . $index; ?>">
                                                <div class="tutorial-accordion-title">
                                                    📝 <?php echo h($item['title']); ?>
                                                </div>
                                                <div class="tutorial-accordion-icon">▼</div>
                                            </div>
                                            <div class="tutorial-accordion-body" id="accordion-<?php echo $level['en'] . '-' . $index; ?>">
                                                <div class="tutorial-accordion-content">
                                                    <?php if (!empty($item['contents'])): ?>
                                                        <?php foreach ($item['contents'] as $content): ?>
                                                            <div class="tutorial-step">
                                                                <?php if (!empty($content['subtitle'])): ?>
                                                                    <h5 class="tutorial-step-title"><?php echo h($content['subtitle']); ?></h5>
                                                                <?php endif; ?>
                                                                
                                                                <?php if (!empty($content['text'])): ?>
                                                                    <div class="tutorial-step-content">
                                                                        <p><?php echo $content['text']; // HTMLタグを許可 ?></p>
                                                                    </div>
                                                                <?php endif; ?>
                                                                
                                                                <?php if (!empty($content['imgs'])): ?>
                                                                    <div class="tutorial-media">
                                                                        <?php foreach ($content['imgs'] as $img): ?>
                                                                            <div class="tutorial-media-item">
                                                                                <img src="img/tutorials/<?php echo h($img); ?>.png" 
                                                                                    alt="<?php echo h($content['subtitle'] ?? ''); ?>"
                                                                                    onerror="this.parentElement.innerHTML='<div class=&quot;tutorial-media-placeholder&quot;>画像準備中</div>'">
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                                
                                                                <?php if (!empty($content['videos'])): ?>
                                                                    <div class="tutorial-media">
                                                                        <?php foreach ($content['videos'] as $video): ?>
                                                                            <div class="tutorial-media-item">
                                                                                <video controls>
                                                                                    <source src="videos/tutorials/<?php echo $currentLevelDir; ?>/<?php echo h($video); ?>.mp4" type="video/mp4">
                                                                                    お使いのブラウザは動画タグをサポートしていません。
                                                                                </video>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                                
                                                                <?php if (!empty($content['subcontents'])): ?>
                                                                    <?php foreach ($content['subcontents'] as $subcontent): ?>
                                                                        <div style="margin-left: var(--spacing-lg); margin-top: var(--spacing-md);">
                                                                            <?php if (!empty($subcontent['head'])): ?>
                                                                                <h6 style="font-weight: 700; color: var(--secondary); margin-bottom: var(--spacing-sm);"><?php echo h($subcontent['head']); ?></h6>
                                                                            <?php endif; ?>
                                                                            <?php if (!empty($subcontent['text'])): ?>
                                                                                <p><?php echo $subcontent['text']; ?></p>
                                                                            <?php endif; ?>
                                                                            <?php if (!empty($subcontent['imgs'])): ?>
                                                                                <div class="tutorial-media">
                                                                                    <?php foreach ($subcontent['imgs'] as $img): ?>
                                                                                        <div class="tutorial-media-item">
                                                                                            <img src="img/tutorials/<?php echo h($img); ?>.png" 
                                                                                                alt="<?php echo h($subcontent['head'] ?? ''); ?>"
                                                                                                onerror="this.parentElement.innerHTML='<div class=&quot;tutorial-media-placeholder&quot;>画像準備中</div>'">
                                                                                        </div>
                                                                                    <?php endforeach; ?>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Next Step -->
                    <div class="next-step-cta" style="margin-top: 3rem; padding: 2rem; background: linear-gradient(135deg, rgba(0, 255, 255, 0.1) 0%, rgba(255, 0, 255, 0.1) 100%); border-radius: 12px; border: 1px solid rgba(0, 255, 255, 0.2);">
                        <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                            チュートリアルで基礎を学んだら、次は画面の見方を覚えましょう
                        </p>
                        <a href="#ui-guide" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                            <span>UI解説を見る</span>
                            <span>→</span>
                        </a>
                    </div>
                </section>