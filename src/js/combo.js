let allCharacters = [];
let allTechniques = []; // 互換のため残す（現在は未使用）

// --------------------------------------------------
// HTMLサニタイズ（安全なタグのみ残す）
// --------------------------------------------------
function escapeHtmlAllowSafeTags(inputHtml) {
    if (!inputHtml) return '';

    const parser = new DOMParser();
    const doc = parser.parseFromString(inputHtml, 'text/html');
    const allowedTags = {
        'br': [],
        'a': ['href'],
        'img': ['src', 'alt']
    };

    function sanitizeNode(node) {
        if (node.nodeType === Node.TEXT_NODE) return node.textContent;

        if (node.nodeType === Node.ELEMENT_NODE) {
            const tag = node.tagName.toLowerCase();
            if (allowedTags[tag]) {
                let attrs = '';
                allowedTags[tag].forEach(attr => {
                    const value = node.getAttribute(attr);
                    if (value && !value.startsWith('javascript:')) {
                        attrs += ` ${attr}="${value}"`;
                    }
                });
                if (tag === 'br') return '<br>';
                if (tag === 'img') return `<img${attrs}>`;

                const inner = Array.from(node.childNodes).map(sanitizeNode).join('');
                return `<${tag}${attrs}>${inner}</${tag}>`;
            } else {
                return Array.from(node.childNodes).map(sanitizeNode).join('');
            }
        }
        return '';
    }

    return Array.from(doc.body.childNodes).map(sanitizeNode).join('');
}

// --------------------------------------------------
// HTMLエスケープ
// --------------------------------------------------
function escapeHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

// --------------------------------------------------
// コンボ描画関数（DBデータ対応版）
// --------------------------------------------------
function renderComboSection(comboList) {
    let html = '';

    // typeごとにグループ化
    const groups = {};
    comboList.forEach(c => {
        if (!groups[c.type]) groups[c.type] = [];
        groups[c.type].push(c);
    });

    for (const [type, list] of Object.entries(groups)) {
        html += `<div id="${list[0].char_slug}-${escapeHtml(type)}">
            <h4>${escapeHtml(typeLabel(type))}</h4>`;

        for (const combo of list) {
            html += `
                <div class="combo-entry">
                    ${buildComboBox(combo.moves)}
                    <div class="combo-info">
                        <p><strong>ダメージ:</strong> ${escapeHtml(combo.damage || '')}</p>
                        <p><strong>条件:</strong> ${escapeHtml(combo.continuation || '')}</p>
                        <p>${escapeHtmlAllowSafeTags((combo.text || '').replaceAll('|||', '<br>'))}</p>
                    </div>
                </div>
            `;
        }

        html += `</div>`;
    }

    return html;
}

// --------------------------------------------------
// コンボ手順をHTML化（;区切り / expandCommand使用）
// --------------------------------------------------
function buildComboBox(movesStr) {
    if (!movesStr) return '';
    const moveParts = movesStr.split(';').map(p => p.trim()).filter(Boolean);

    return `
        <div class="combo-box">
            ${moveParts.map(p => expandCommand(p)).join(
                `<img src="../img/command/next.png" alt="▶" class="command">`
            )}
        </div>
    `;
}

// --------------------------------------------------
// タイプ名を日本語化
// --------------------------------------------------
function typeLabel(type) {
    const map = {
        general: '汎用コンボ',
        rush: 'ラッシュ攻撃',
        fourF: '4F始動',
        jump: 'ジャンプ攻撃',
        impact: 'インパクト始動',
        shimmy: 'シミー始動'
    };
    return map[type] || type;
}

// --------------------------------------------------
// 技名テーブル（APIから取得）
// --------------------------------------------------
async function renderTechTable(charSlug) {
    try {
        const res = await fetch(`../api/get_combo.php?char_slug=${encodeURIComponent(charSlug)}`);
        const data = await res.json();

        if (!res.ok || data.error) {
            console.warn('API error for', charSlug, data);
            const msg = data.error ? data.error : `HTTP ${res.status}`;
            return `<tr><td colspan="4">データ取得エラー: ${escapeHtml(msg)}</td></tr>`;
        }

        let html = '';

        const specials = data.special_moves || [];
        for (const tech of specials) {
            html += `
                <tr>
                    <td>${escapeHtml(tech.jp || '')}</td>
                    <td>${expandCommand(tech.command || '')}</td>
                    <td><img src="../img/technique/${escapeHtml(charSlug)}/${escapeHtml(tech.img || '')}.jpg" alt="${escapeHtml(tech.jp || '')}"></td>
                    <td>${escapeHtml(tech.supplement || '')}</td>
                </tr>
            `;
            const derivatives = tech.derivatives || tech.derivativeList || [];
            for (const d of derivatives) {
                html += `
                    <tr>
                        <td>→${escapeHtml(d.jp || '')}</td>
                        <td>${expandCommand(d.command || '')}</td>
                        <td><img src="../img/technique/${escapeHtml(charSlug)}/${escapeHtml(d.img || '')}.jpg" alt="${escapeHtml(d.jp || '')}"></td>
                        <td>${escapeHtml(d.supplement || '')}</td>
                    </tr>
                `;
            }
        }

        const supers = data.super_arts || [];
        if (supers.length > 0) {
            html += `<tr><td>SA</td><td></td><td></td><td></td></tr>`;
            for (const tech of supers) {
                html += `
                    <tr>
                        <td>${escapeHtml(tech.jp || '')}</td>
                        <td>${expandCommand(tech.command || '')}</td>
                        <td><img src="../img/technique/${escapeHtml(charSlug)}/${escapeHtml(tech.img || '')}.jpg" alt="${escapeHtml(tech.jp || '')}"></td>
                        <td>${escapeHtml(tech.supplement || '')}</td>
                    </tr>
                `;
            }
        }

        if (html.trim() === '') {
            html = `<tr><td colspan="4">技データが存在しません</td></tr>`;
        }

        return html;

    } catch (err) {
        console.error('renderTechTable error for', charSlug, err);
        return `<tr><td colspan="4">データ取得エラー（内部）</td></tr>`;
    }
}

// --------------------------------------------------
// 全キャラデータをロード（DB対応）
// --------------------------------------------------
async function loadAllData() {
    try {
        const [characters, intrinsic] = await Promise.all([
            fetch('../data/character.json').then(res => res.json()),
            fetch('../data/intrinsic.json').then(res => res.json())
        ]);

        allCharacters = characters;
        allTechniques = [];

        const conboContainer = document.getElementById('conbo');
        let allHtml = '';

        for (const char of characters) {
            const intrinsicData = intrinsic.find(i => i.slug === char.slug);

            // コンボデータをDBから取得
            const comboRes = await fetch(`../api/get_combo.php?char_slug=${encodeURIComponent(char.slug)}&mode=combo`);
            const comboList = await comboRes.json();

            allHtml += `
                <section id="${escapeHtml(char.slug)}-section">
                    <h2>${escapeHtml(char.jp)}</h2>
                    <div class="listflex">
                        <div>
                            <div class="name-img">
                                <img width="360" src="../img/character/${escapeHtml(char.slug)}_ss01.jpg" alt="${escapeHtml(char.jp)}">
                            </div>
                        </div>
                        <div class="list char-list" data-section="${escapeHtml(char.slug)}">
                            <span class="list-label"><span class="glyphicon glyphicon-th-list"></span>目次</span>
                            <ul class="scrollable">
                                <li><a href="#${escapeHtml(char.slug)}-annotation">注釈</a></li>
                                <li><a href="#${escapeHtml(char.slug)}-technique">技名（コマンド）</a></li>
                                ${intrinsicData ? `<li><a href="#${escapeHtml(char.slug)}-intrinsic">${escapeHtml(intrinsicData.title)}について</a></li>` : ''}
                                <li><a href="#${escapeHtml(char.slug)}-combo">コンボ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="${escapeHtml(char.slug)}-annotation">
                        <h3>注釈</h3>
                        <table class="annotation-table">
                            <tbody>
                                <tr><th>画像</th><th>10キー</th><th>日本語(1P側)</th><th>画像</th><th>10キー</th><th>日本語(1P側)</th></tr>
                                <tr><td><img src="../img/command/arrow1.png" alt="1"></td><td>1</td><td>左下</td><td><img src="../img/command/arrow2.png" alt="2"></td><td>2</td><td>下/屈</td></tr>
                                <tr><td><img src="../img/command/charge_arrow2.png" alt="2"></td><td>2</td><td>下(長押し/溜め)</td><td><img src="../img/command/arrow3.png" alt="3"></td><td>3</td><td>右下</td></tr>
                                <tr><td><img src="../img/command/arrow4.png" alt="4"></td><td>4</td><td>左/引</td><td><img src="../img/command/charge_arrow4.png" alt="4"></td><td>4</td><td>左(長押し/溜め)</td></tr>
                                <tr><td><img src="../img/command/neutral.png" alt="ニュートラル"></td><td>5</td><td>ニュートラル</td><td><img src="../img/command/arrow6.png" alt="6"></td><td>6</td><td>右/前</td></tr>
                                <tr><td><img src="../img/command/charge_arrow6.png" alt="6"></td><td>6</td><td>前(長押し/溜め)</td><td><img src="../img/command/arrow7.png" alt="7"></td><td>7</td><td>左上</td></tr>
                                <tr><td><img src="../img/command/arrow8.png" alt="8"></td><td>8</td><td>上/ジャンプ/J</td><td><img src="../img/command/arrow9.png" alt="9"></td><td>9</td><td>右上</td></tr>
                                <tr><td><img src="../img/command/ikkai.png" alt="1回転"></td><td>1~9</td><td>1回転</td><td><img src="../img/command/nikai.png" alt="2回転"></td><td>1~9×2</td><td>2回転</td></tr>
                                <tr><th>画像</th><th>日本語</th><th>補足解説</th><th>画像</th><th>日本語</th><th>補足解説</th></tr>
                                <tr><td><img src="../img/command/p.png" alt="パンチ"></td><td>パンチ</td><td>弱中強のパンチどれでも大丈夫</td><td><img src="../img/command/lp.png" alt="弱パンチ"></td><td>弱パンチ</td><td>弱P/LP</td></tr>
                                <tr><td><img src="../img/command/mp.png" alt="中パンチ"></td><td>中パンチ</td><td>中P/MP</td><td><img src="../img/command/hp.png" alt="強パンチ"></td><td>強パンチ</td><td>強P/HP</td></tr>
                                <tr><td><img src="../img/command/k.png" alt="キック"></td><td>キック</td><td>弱中強のキックどれでも大丈夫</td><td><img src="../img/command/lk.png" alt="弱キック"></td><td>弱キック</td><td>弱K/LK</td></tr>
                                <tr><td><img src="../img/command/mk.png" alt="中キック"></td><td>中キック</td><td>中K/MK</td><td><img src="../img/command/hk.png" alt="強キック"></td><td>強キック</td><td>強K/HK</td></tr>
                                <tr><td><img src="../img/command/naga.png" alt="長押し"></td><td>長押し</td><td>ボタン長押し/溜め</td></tr>
                            </tbody>
                        </table>
                    </div>
            `;

            // 技表
            const techTableHTML = await renderTechTable(char.slug);
            allHtml += `
                <div id="${escapeHtml(char.slug)}-technique">
                    <h3>技名（コマンド）</h3>
                    <div class="scroll">
                        <table class="comand-table" data-char="${escapeHtml(char.slug)}">
                            <thead>
                                <tr><th>技名</th><th>コマンド</th><th>画像</th><th>補足解説</th></tr>
                            </thead>
                            <tbody>${techTableHTML}</tbody>
                        </table>
                    </div>
                </div>
            `;

            // 固有能力
            if (intrinsicData) {
                allHtml += `
                    <div id="${escapeHtml(char.slug)}-intrinsic">
                        <h3>${escapeHtml(intrinsicData.title)}</h3>
                        <p>${escapeHtmlAllowSafeTags(intrinsicData.text)}</p>
                    </div>
                `;
            }

            // コンボ
            if (Array.isArray(comboList) && comboList.length > 0) {
                allHtml += `
                    <div id="${escapeHtml(char.slug)}-combo">
                        <h3>コンボ紹介</h3>
                        ${renderComboSection(comboList)}
                    </div>
                `;
            }

            allHtml += `</section>`;
        }

        conboContainer.innerHTML = allHtml;

        if (typeof bindModalToImages === 'function') bindModalToImages();
        if (typeof setupDynamicList === 'function') setupDynamicList();

    } catch (err) {
        console.error('データ読み込みエラー:', err);
    }
    characterTable();
}

// --------------------------------------------------
// 実行
// --------------------------------------------------
loadAllData();
