/**
 * glossary.js - SF6攻略サイト 用語集
 *
 * @description
 * 用語集ページ専用JavaScript。
 * - リアルタイム検索（かな/英字両対応）
 * - 50音インデックスフィルタリング
 * - URLハッシュによるアンカーハイライト
 *
 * @requires main.js（テーマ切り替え・モバイルメニュー）
 * @updated 2026-03-04
 */

(function () {
    'use strict';

    // ==================== 初期化 ====================
    document.addEventListener('DOMContentLoaded', function () {
        initSearch();
        initIndexFilter();
        initAnchorHighlight();
    });

    // ==================== ユーティリティ ====================

    /**
     * 全ての用語カードを取得
     */
    function getAllCards() {
        return Array.from(document.querySelectorAll('.p-glossary__card'));
    }

    /**
     * 全ての行グループを取得
     */
    function getAllGroups() {
        return Array.from(document.querySelectorAll('.p-glossary__group'));
    }

    /**
     * 検索カウントを更新
     */
    function updateCount(total, shown) {
        const el = document.getElementById('glossarySearchCount');
        if (!el) return;
        if (total === shown) {
            el.textContent = '';
        } else {
            el.textContent = `${total}語中 ${shown}語を表示中`;
        }
    }

    /**
     * 「該当なし」表示を切り替え
     */
    function toggleEmpty(visible, keyword) {
        const el = document.getElementById('glossaryEmpty');
        if (!el) return;
        el.style.display = visible ? '' : 'none';
        if (visible) {
            const kw = document.getElementById('glossaryEmptyKeyword');
            if (kw) kw.textContent = keyword;
        }
    }

    /**
     * 行グループ内に表示中のカードがあるかチェックし、グループ自体を出し入れする
     */
    function refreshGroupVisibility() {
        getAllGroups().forEach(function (group) {
            const visibleCards = group.querySelectorAll('.p-glossary__card:not([hidden])');
            group.hidden = visibleCards.length === 0;
        });
    }

    // ==================== リアルタイム検索 ====================
    function initSearch() {
        const input = document.getElementById('glossarySearch');
        if (!input) return;

        input.addEventListener('input', function () {
            const raw = this.value.trim();
            applySearch(raw);
        });
    }

    /**
     * キーワードで全カードをフィルタリング
     * @param {string} keyword
     */
    function applySearch(keyword) {
        const cards = getAllCards();
        const q = keyword.toLowerCase();
        let shown = 0;

        cards.forEach(function (card) {
            if (!q) {
                card.hidden = false;
                shown++;
                return;
            }

            const term = (card.dataset.term || '').toLowerCase();
            const kana = (card.dataset.kana || '').toLowerCase();
            const category = (card.dataset.category || '').toLowerCase();
            // カード内テキスト全体（説明文など）を対象に
            const bodyText = card.textContent.toLowerCase();

            const match = term.includes(q) || kana.includes(q) || category.includes(q) || bodyText.includes(q);
            card.hidden = !match;
            if (match) shown++;
        });

        refreshGroupVisibility();
        updateCount(cards.length, shown);
        toggleEmpty(shown === 0 && q !== '', keyword);

        // 検索中は50音フィルターを無効化してUIを整える
        syncIndexBtnsToSearch(q !== '');
    }

    /**
     * 検索中は50音ボタンのアクティブ表示をグレーアウト
     */
    function syncIndexBtnsToSearch(isSearching) {
        document.querySelectorAll('.p-glossary__index-btn').forEach(function (btn) {
            btn.style.opacity = isSearching ? '0.5' : '';
            btn.style.pointerEvents = isSearching ? 'none' : '';
        });
    }

    // ==================== 50音インデックスフィルター ====================
    function initIndexFilter() {
        const btns = document.querySelectorAll('.p-glossary__index-btn');
        btns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                // 検索をリセット
                const searchInput = document.getElementById('glossarySearch');
                if (searchInput) {
                    searchInput.value = '';
                    applySearch('');
                }
                syncIndexBtnsToSearch(false);

                // アクティブ切り替え
                btns.forEach(function (b) { b.classList.remove('is-active'); });
                btn.classList.add('is-active');

                const targetRow = btn.dataset.row;
                filterByRow(targetRow);
            });
        });
    }

    /**
     * 行フィルタリング
     * @param {string} row 'all' または '行ラベル'
     */
    function filterByRow(row) {
        const groups = getAllGroups();

        if (row === 'all') {
            groups.forEach(function (g) {
                g.hidden = false;
                // カードも全表示
                g.querySelectorAll('.p-glossary__card').forEach(function (c) {
                    c.hidden = false;
                });
            });
            updateCount(getAllCards().length, getAllCards().length);
            toggleEmpty(false, '');
            return;
        }

        let shown = 0;
        groups.forEach(function (g) {
            const isTarget = g.dataset.row === row;
            g.hidden = !isTarget;
            if (isTarget) {
                g.querySelectorAll('.p-glossary__card').forEach(function (c) {
                    c.hidden = false;
                    shown++;
                });
            }
        });

        updateCount(getAllCards().length, shown);
        toggleEmpty(shown === 0, row);

        // 対象グループへ滑らかにスクロール
        if (shown > 0) {
            const targetGroup = document.querySelector(`.p-glossary__group[data-row="${CSS.escape(row)}"]`);
            if (targetGroup) {
                const headerOffset = 90;
                const top = targetGroup.getBoundingClientRect().top + window.scrollY - headerOffset;
                window.scrollTo({ top, behavior: 'smooth' });
            }
        }
    }

    // ==================== アンカーハイライト ====================
    function initAnchorHighlight() {
        const hash = window.location.hash;
        if (!hash) return;

        // 少し遅延させてDOMが確実に描画された後に実行
        setTimeout(function () {
            const targetId = hash.slice(1); // '#' を除去
            const card = document.getElementById(targetId);
            if (!card) return;

            // ハイライトクラスを付与
            card.classList.add('is-highlighted');

            // スムーススクロール
            const headerOffset = 90;
            const top = card.getBoundingClientRect().top + window.scrollY - headerOffset;
            window.scrollTo({ top, behavior: 'smooth' });

            // details が閉じていたら開く
            const details = card.querySelector('details');
            if (details) details.open = true;

            // アニメーション終了後にクラスを除去
            card.addEventListener('animationend', function () {
                card.classList.remove('is-highlighted');
            }, { once: true });

        }, 300);
    }

})();
