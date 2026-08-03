/**
 * training.js
 * フィルタリング & LocalStorage管理 & タブ切り替え
 */

// LocalStorageキー
const STORAGE_KEY = 'sf6_training_mastered';

// 初期化
document.addEventListener('DOMContentLoaded', () => {
    initFilters();
    initMasteredCheckboxes();
    initTabs();
    initSidebarNavigation();
});

// ==================== フィルター機能 ====================
function initFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const menuCards = document.querySelectorAll('.menu-card');
    const noResults = document.getElementById('noResults');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const filterType = btn.closest('.filter-card').dataset.filterType;
            const filterValue = btn.dataset.filter;

            // ボタンのアクティブ状態切り替え
            const siblings = btn.parentElement.querySelectorAll('.filter-btn');
            siblings.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // カードのフィルタリング
            let visibleCount = 0;

            menuCards.forEach(card => {
                let shouldShow = filterValue === 'all';

                if (!shouldShow) {
                    shouldShow = matchesFilter(card, filterType, filterValue);
                }

                card.classList.toggle('hidden', !shouldShow);
                if (shouldShow) visibleCount++;
            });

            // 結果なしメッセージの表示/非表示
            if (noResults) {
                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }

            // フィルター状態の更新
            updateFilterStatus(filterType, filterValue);
        });
    });
}

function matchesFilter(card, filterType, filterValue) {
    if (filterType === 'problem') {
        return card.dataset.problem === filterValue;
    } else if (filterType === 'rank') {
        return card.dataset.rank === filterValue;
    } else if (filterType === 'duration') {
        return card.dataset.duration === filterValue;
    }
    return true;
}

function updateFilterStatus(filterType, filterValue) {
    const filterStatus = document.getElementById('filterStatus');
    const filterText = document.getElementById('filterText');

    if (!filterStatus || !filterText) return;

    if (filterValue === 'all') {
        filterStatus.style.display = 'none';
        return;
    }

    const labels = {
        problem: {
            defense: '防御の悩み',
            offense: '攻撃の悩み',
            finish: '勝ち切れない悩み'
        },
        rank: {
            beginner: 'ビギナー〜ブロンズ',
            silver: 'シルバー〜ゴールド',
            platinum: 'プラチナ以上'
        },
        duration: {
            '5': '5分コース',
            '10': '10分コース',
            '30': '30分コース'
        }
    };

    const label = labels[filterType]?.[filterValue] || filterValue;
    filterText.textContent = label;
    filterStatus.style.display = 'block';
}

// ==================== 習得チェックボックス ====================
function initMasteredCheckboxes() {
    const mastered = getMasteredMenus();
    const checkboxes = document.querySelectorAll('.mastered-check');

    checkboxes.forEach(checkbox => {
        const menuId = checkbox.dataset.menuId;

        // 保存済みの状態を反映
        if (mastered.includes(menuId)) {
            checkbox.checked = true;
            checkbox.closest('.menu-card').classList.add('mastered');
        }

        // 変更時の処理
        checkbox.addEventListener('change', (e) => {
            const isChecked = e.target.checked;
            toggleMastered(menuId, isChecked);
            e.target.closest('.menu-card').classList.toggle('mastered', isChecked);
        });
    });
}

function getMasteredMenus() {
    const stored = localStorage.getItem(STORAGE_KEY);
    return stored ? JSON.parse(stored) : [];
}

function toggleMastered(menuId, isChecked) {
    let mastered = getMasteredMenus();

    if (isChecked && !mastered.includes(menuId)) {
        mastered.push(menuId);
    } else if (!isChecked) {
        mastered = mastered.filter(id => id !== menuId);
    }

    localStorage.setItem(STORAGE_KEY, JSON.stringify(mastered));
}

// ==================== タブ切り替え ====================
function initTabs() {
    const tabContainers = document.querySelectorAll('.tabs-container, .routine-tabs');

    tabContainers.forEach(container => {
        const tabBtns = container.querySelectorAll('.tab-btn');
        const tabPanels = container.querySelectorAll('.tab-panel');

        tabBtns.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                // すべてのタブを非アクティブに
                tabBtns.forEach(b => b.classList.remove('active'));
                tabPanels.forEach(p => p.classList.remove('active'));

                // クリックされたタブをアクティブに
                btn.classList.add('active');
                if (tabPanels[index]) {
                    tabPanels[index].classList.add('active');
                }
            });
        });
    });
}

// ==================== サイドバーナビゲーション ====================
function initSidebarNavigation() {
    const navLinks = document.querySelectorAll('.p-guide__nav-link');
    const sections = document.querySelectorAll('.training-section, .guide-section');

    // ナビゲーションリンクのクリック
    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            // アクティブ状態を切り替え
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            // モバイルの場合、サイドバーを閉じる
            if (window.innerWidth <= 1024) {
                const sidebar = document.getElementById('guideSidebar');
                const overlay = document.getElementById('sidebarOverlay');
                if (sidebar) sidebar.classList.remove('active');
                if (overlay) overlay.classList.remove('active');
            }
        });
    });

    // スクロール時にナビゲーションをハイライト
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
            if (link.getAttribute('data-section') === current) {
                link.classList.add('active');
            }
        });
    });
}

// ==================== ユーティリティ ====================
// スムーズスクロール（main.jsで定義済みの場合は不要）
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href === '#') return;

        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
