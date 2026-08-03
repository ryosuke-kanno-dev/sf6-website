<?php
/**
 * SF6攻略ガイド - 初心者向けスタートガイド
 * srcの1〜3ページ目を統合
 */

// 設定ファイルの読み込み
require_once __DIR__ . '/../includes/config.php';

// JSONデータの読み込み
$devicesData = loadJsonFile(DATA_PATH . '/devices.json');
$tutorialsData = loadJsonFile(DATA_PATH . '/tutorials.json');

// ページ情報
$pageTitle = 'スタートガイド | ' . h(SITE_NAME);
$pageDescription = 'SF6を始める方向けの完全ガイド。デバイス選び、操作タイプ、チュ

ートリアル、設定方法まで網羅';
$currentPage = 'guide';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <base href="<?php echo htmlspecialchars(SITE_URL, ENT_QUOTES, 'UTF-8'); ?>/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $pageDescription; ?>">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/variables.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/guide.css">
    <link rel="stylesheet" href="css/ads.css">
</head>
<body>
    <!-- ヘッダー -->
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="p-guide">
        <!-- サイドバーナビゲーション -->
        <aside class="p-guide__sidebar" id="guideSidebar">
            <h2 class="p-guide__sidebar-title">📖 目次</h2>
            <nav>
                <ul class="p-guide__nav">
                    <li class="p-guide__nav-item">
                        <a href="#overview" class="p-guide__nav-link active" data-section="overview">
                            📋 SF6概要
                        </a>
                    </li>
                    <li class="p-guide__nav-item">
                        <a href="#devices" class="p-guide__nav-link" data-section="devices">
                            🎮 デバイス紹介
                        </a>
                    </li>
                    <li class="p-guide__nav-item">
                        <a href="#operation-types" class="p-guide__nav-link" data-section="operation-types">
                            ⚙️ 操作タイプ
                        </a>
                    </li>
                    <li class="p-guide__nav-item">
                        <a href="#getting-started" class="p-guide__nav-link" data-section="getting-started">
                            🚀 始め方
                        </a>
                    </li>
                    <li class="p-guide__nav-item">
                        <a href="#tutorials" class="p-guide__nav-link" data-section="tutorials">
                            📚 チュートリアル
                        </a>
                    </li>
                    <li class="p-guide__nav-item">
                        <a href="#ui-guide" class="p-guide__nav-link" data-section="ui-guide">
                            🖥️ UI解説
                        </a>
                    </li>
                    <li class="p-guide__nav-item">
                        <a href="#settings" class="p-guide__nav-link" data-section="settings">
                            ⚡ 設定
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- メインコンテンツ -->
        <main class="p-guide__main">
            <div class="l-container">
                <!-- ページヘッダー -->
                <div class="training-header" style="margin-bottom: 3rem;">
                    <h1 style="font-size: 3rem; font-weight: 900; color: var(--accent-white); text-shadow: 0 0 20px var(--accent-gold); margin-bottom: 1rem;">
                        ガイド
                    </h1>
                    <p class="text-secondary" style="font-size: var(--font-size-lg);">
                        ゲーム概要や設定紹介などストリートファイター6を始めるうえであると便利な知識をまとめている
                    </p>
                </div>
                <!-- ヘッダー下広告 -->
                <!--
                <div class="ad-space horizontal ad-header-below">
                    広告スペース (728x90)
                </div>
                -->

                <!-- 概要セクション -->
                <?php include __DIR__ . '/../sections/guide/overview.php'; ?>

                <!-- デバイス紹介セクション -->
                <?php include __DIR__ . '/../sections/guide/devices.php'; ?>

                <!-- 操作タイプセクション -->
                <?php include __DIR__ . '/../sections/guide/operation_types.php'; ?>

                <!-- 始め方セクション -->
                <?php include __DIR__ . '/../sections/guide/getting_started.php'; ?>

                <!-- チュートリアルセクション -->
                <?php include __DIR__ . '/../sections/guide/tutorials.php'; ?>

                <!-- UI解説セクション -->
                <?php include __DIR__ . '/../sections/guide/ui_guide.php'; ?>

                <!-- 設定セクション -->
                <?php include __DIR__ . '/../sections/guide/settings.php'; ?>

                <!-- CTAセクション -->
                <section class="section" style="padding: 3rem 0;">
                    <div class="cta-section">
                        <div class="cta-content">
                            <h2 class="cta-title">さっそく始めよう！</h2>
                            <p class="cta-subtitle">設定が完了したら、まずはチュートリアルからスタート</p>
                            <a href="training" class="cta-btn-large">
                                <span>練習メニューへ</span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>
                </section>

                <!-- フッター上広告 -->
                <div class="ad-space horizontal ad-footer-above">
                    広告スペース (728x90)
                </div>
            </div>
        </main>
    </div>

    <!-- サイドバーオーバーレイ（モバイル用） -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- フッター -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="js/main.js"></script>
    <script>
        // タブ切り替え
        document.querySelectorAll('.tutorial-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const tabId = this.dataset.tab;
                
                // タブのアクティブ状態を切り替え
                document.querySelectorAll('.tutorial-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // コンテンツの表示を切り替え
                document.querySelectorAll('.tutorial-content').forEach(content => {
                    content.classList.remove('active');
                });
                document.getElementById('tab-' + tabId).classList.add('active');
            });
        });

        // サイドバーナビゲーション
        document.querySelectorAll('.p-guide__nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // アクティブ状態を切り替え
                document.querySelectorAll('.p-guide__nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                
                // モバイルの場合、サイドバーを閉じる
                if (window.innerWidth <= 1024) {
                    document.getElementById('guideSidebar').classList.remove('active');
                    document.getElementById('sidebarOverlay').classList.remove('active');
                }
            });
        });

        // スクロール時にナビゲーションをハイライト
        const sections = document.querySelectorAll('.guide-section');
        const navLinks = document.querySelectorAll('.p-guide__nav-link');

        window.addEventListener('scroll', () => {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= (sectionTop - 150)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });

        // サイドバートグル（モバイル用）
        const hamburgerBtn = document.createElement('button');
        hamburgerBtn.className = 'hamburger-btn';
        hamburgerBtn.innerHTML = '<span></span><span></span><span></span>';
        hamburgerBtn.style.cssText = `
            display: none;
            position: fixed;
            top: 80px;
            left: 20px;
            z-index: 1100;
            background: var(--accent-gold);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 0;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(255, 215, 0, 0.4);
        `;
        hamburgerBtn.querySelectorAll('span').forEach(span => {
            span.style.cssText = `
                display: block;
                width: 20px;
                height: 2px;
                background: var(--bg-primary);
                transition: all 0.3s ease;
            `;
        });

        document.body.appendChild(hamburgerBtn);

        hamburgerBtn.addEventListener('click', function() {
            const sidebar = document.getElementById('guideSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.getElementById('guideSidebar').classList.remove('active');
            this.classList.remove('active');
        });

        // レスポンシブ対応
        function checkMobile() {
            if (window.innerWidth <= 1024) {
                hamburgerBtn.style.display = 'flex';
            } else {
                hamburgerBtn.style.display = 'none';
                document.getElementById('guideSidebar').classList.remove('active');
                document.getElementById('sidebarOverlay').classList.remove('active');
            }
        }

        window.addEventListener('resize', checkMobile);
        checkMobile();


        /* === スライダー(カルーセル) ===*/
    class InfiniteSlider {
      constructor() {
        this.track = document.getElementById('sliderTrack');
        this.prevBtn = document.getElementById('prevBtn');
        this.nextBtn = document.getElementById('nextBtn');
        this.tabs = document.querySelectorAll('.tab');
        
        this.originalCards = [];
        this.currentIndex = 0;
        this.isTransitioning = false;
        this.cardsPerView = window.innerWidth <= 768 ? 1 : 2;
        
        this.touchStartX = 0;
        this.touchEndX = 0;
        
        this.init();
      }

      init() {
        this.collectOriginalCards();
        this.setupClones();
        this.attachEvents();
        this.updateTabs();
        this.updatePosition(false);
        
        window.addEventListener('resize', () => this.handleResize());
      }

      collectOriginalCards() {
        // HTML内の既存カードを取得
        const cards = this.track.querySelectorAll('.slider-card');
        this.originalCards = Array.from(cards);
        this.totalCards = this.originalCards.length;
      }

      setupClones() {
        if (this.originalCards.length === 0) return;
        
        // 最初と最後のカードのクローンを作成
        const firstClone = this.originalCards[0].cloneNode(true);
        const lastClone = this.originalCards[this.totalCards - 1].cloneNode(true);
        
        // data-index を調整
        firstClone.dataset.index = this.totalCards;
        lastClone.dataset.index = -1;
        
        // 前後に追加
        this.track.insertBefore(lastClone, this.track.firstChild);
        this.track.appendChild(firstClone);
      }

      attachEvents() {
        this.prevBtn.addEventListener('click', () => this.prev());
        this.nextBtn.addEventListener('click', () => this.next());
        
        this.tabs.forEach(tab => {
          tab.addEventListener('click', (e) => {
            const index = parseInt(e.target.dataset.index);
            this.goToSlide(index);
          });
        });
        
        // タッチイベント
        this.track.addEventListener('touchstart', (e) => {
          this.touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        
        this.track.addEventListener('touchend', (e) => {
          this.touchEndX = e.changedTouches[0].screenX;
          this.handleSwipe();
        }, { passive: true });
      }

      handleSwipe() {
        const diff = this.touchStartX - this.touchEndX;
        if (Math.abs(diff) > 50) {
          if (diff > 0) {
            this.next();
          } else {
            this.prev();
          }
        }
      }

      next() {
        if (this.isTransitioning) return;
        this.currentIndex++;
        this.slide();
      }

      prev() {
        if (this.isTransitioning) return;
        this.currentIndex--;
        this.slide();
      }

      goToSlide(index) {
        if (this.isTransitioning) return;
        this.currentIndex = index;
        this.updatePosition(true);
        this.updateTabs();
      }

      slide() {
        this.isTransitioning = true;
        this.updatePosition(true);
        this.updateTabs();
        
        setTimeout(() => {
          this.handleLoop();
          this.isTransitioning = false;
        }, 400);
      }

      handleLoop() {
        if (this.currentIndex >= this.totalCards) {
          this.currentIndex = 0;
          this.updatePosition(false);
        } else if (this.currentIndex < 0) {
          this.currentIndex = this.totalCards - 1;
          this.updatePosition(false);
        }
      }

      updatePosition(animate = true) {
        if (!animate) {
          this.track.classList.add('no-transition');
        } else {
          this.track.classList.remove('no-transition');
        }
        
        // クローンを考慮して+1
        const offset = -(this.currentIndex + 1) * (100 / this.cardsPerView);
        this.track.style.transform = `translateX(${offset}%)`;
        
        if (!animate) {
          this.track.offsetHeight; // リフロー強制
        }
      }

      updateTabs() {
        const activeIndices = [];
        
        for (let i = 0; i < this.cardsPerView; i++) {
          let index = (this.currentIndex + i) % this.totalCards;
          if (index < 0) index += this.totalCards;
          activeIndices.push(index);
        }
        
        this.tabs.forEach((tab, i) => {
          if (activeIndices.includes(i)) {
            tab.classList.add('active');
          } else {
            tab.classList.remove('active');
          }
        });
      }

      handleResize() {
        const newCardsPerView = window.innerWidth <= 768 ? 1 : 2;
        if (newCardsPerView !== this.cardsPerView) {
          this.cardsPerView = newCardsPerView;
          this.updatePosition(false);
          this.updateTabs();
        }
      }
    }

    // 初期化
    new InfiniteSlider();


// インタラクション処理
const pins = document.querySelectorAll('.pin');
const cards = document.querySelectorAll('.ui-card');

// アクティブ状態をリセット
function clearActive() {
  pins.forEach(p => p.classList.remove('active'));
  cards.forEach(c => c.classList.remove('active'));
}

// ピンクリック → カードへスクロール & 強調
pins.forEach(pin => {
  pin.addEventListener('click', () => {
    const id = pin.dataset.id;
    const targetCard = document.querySelector(`.ui-card[data-id="${id}"]`);
    
    clearActive();
    pin.classList.add('active');
    targetCard.classList.add('active');
    
    targetCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
    
    setTimeout(() => {
      pin.classList.remove('active');
    }, 600);
  });
});

// カードクリック → ピンを弾ませる
cards.forEach(card => {
  card.addEventListener('click', () => {
    const id = card.dataset.id;
    const targetPin = document.querySelector(`.pin[data-id="${id}"]`);
    
    clearActive();
    card.classList.add('active');
    targetPin.classList.add('active');
    
    setTimeout(() => {
      targetPin.classList.remove('active');
      card.classList.remove('active');
    }, 600);
  });
});

// ホバー連動
pins.forEach(pin => {
  pin.addEventListener('mouseenter', () => {
    const id = pin.dataset.id;
    const targetCard = document.querySelector(`.ui-card[data-id="${id}"]`);
    targetCard.style.borderColor = 'var(--sf6-cyan)';
  });
  
  pin.addEventListener('mouseleave', () => {
    const id = pin.dataset.id;
    const targetCard = document.querySelector(`.card[data-id="${id}"]`);
    if (!targetCard.classList.contains('active')) {
      targetCard.style.borderColor = 'transparent';
    }
  });
});

cards.forEach(card => {
  card.addEventListener('mouseenter', () => {
    const id = card.dataset.id;
    const targetPin = document.querySelector(`.pin[data-id="${id}"]`);
    targetPin.style.background = 'var(--sf6-pink)';
    targetPin.style.boxShadow = '0 0 30px var(--sf6-pink)';
  });
  
  card.addEventListener('mouseleave', () => {
    const id = card.dataset.id;
    const targetPin = document.querySelector(`.pin[data-id="${id}"]`);
    if (!targetPin.classList.contains('active')) {
      targetPin.style.background = 'var(--sf6-cyan)';
      targetPin.style.boxShadow = '0 0 20px var(--sf6-cyan)';
    }
  });
});

// チュートリアルアコーディオン機能
document.querySelectorAll('.tutorial-accordion-header').forEach(header => {
    header.addEventListener('click', function() {
        const accordionId = this.dataset.accordion;
        const body = document.getElementById('accordion-' + accordionId);
        this.classList.toggle('active');
        body.classList.toggle('active');
    });
});
    </script>
</body>
</html>
