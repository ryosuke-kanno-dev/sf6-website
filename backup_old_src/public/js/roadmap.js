/**
 * roadmap.js - SF6攻略サイト 上達ロードマップ
 *
 * @description
 * 上達ロードマップページ専用JavaScript。
 * - ランクナビボタンのクリックでスムーススクロール
 * - IntersectionObserver でスクロール位置に応じてナビのアクティブ状態を更新
 * - URLハッシュ（例: roadmap.php#silver）でのアクセスをサポート
 *
 * @requires main.js（テーマ切り替え・モバイルメニュー）
 * @updated 2026-03-05
 */

(function () {
    'use strict';

    const HEADER_OFFSET = 90;

    // ==================== 初期化 ====================
    document.addEventListener('DOMContentLoaded', function () {
        initRankNav();
        initScrollSpy();
        handleInitialHash();
    });

    // ==================== ランクナビ ==================== 
    function initRankNav() {
        const btns = document.querySelectorAll('.p-roadmap__rank-btn');

        btns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const rankId = btn.dataset.rank;
                const target = document.getElementById(rankId);
                if (!target) return;

                // アクティブ切り替え
                setActiveBtn(rankId);

                // スムーススクロール
                const top = target.getBoundingClientRect().top + window.scrollY - HEADER_OFFSET;
                window.scrollTo({ top: top, behavior: 'smooth' });
            });
        });
    }

    /**
     * アクティブボタンを切り替える
     * @param {string} rankId
     */
    function setActiveBtn(rankId) {
        document.querySelectorAll('.p-roadmap__rank-btn').forEach(function (btn) {
            btn.classList.toggle('is-active', btn.dataset.rank === rankId);
        });
    }

    // ==================== スクロールスパイ ====================
    function initScrollSpy() {
        const sections = document.querySelectorAll('.p-roadmap__section');
        if (!sections.length) return;

        const observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        const rankId = entry.target.dataset.rank;
                        if (rankId) setActiveBtn(rankId);
                    }
                });
            },
            {
                rootMargin: `-${HEADER_OFFSET}px 0px -40% 0px`,
                threshold: 0,
            }
        );

        sections.forEach(function (section) {
            observer.observe(section);
        });
    }

    // ==================== URLハッシュ対応 ====================
    function handleInitialHash() {
        const hash = window.location.hash;
        if (!hash) return;

        const rankId = hash.slice(1);
        const target = document.getElementById(rankId);
        if (!target) return;

        // 少し遅延させてレンダリング後にスクロール
        setTimeout(function () {
            setActiveBtn(rankId);

            const top = target.getBoundingClientRect().top + window.scrollY - HEADER_OFFSET;
            window.scrollTo({ top: top, behavior: 'smooth' });

            // セクションに軽くハイライト演出
            target.style.transition = 'box-shadow 0.3s ease';
            target.style.boxShadow = '0 0 0 2px var(--secondary)';
            setTimeout(function () {
                target.style.boxShadow = '';
            }, 2000);
        }, 350);
    }

})();
