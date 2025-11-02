// ============================
// ページ全体を描画
// ============================
async function renderCounterPage() {
    const container = document.getElementById('main-text');

    // キャラ一覧と技表示用JSON（フォールバック）を並列で取得
    const [characters, techData] = await Promise.all([
        fetch('../data/character.json').then(r => r.json()),
        fetch('../data/techniques.json').then(r => {
            if (!r.ok) return [];
            return r.json();
        })
    ]);

    let html = '';

    for (const char of characters) {
        const techniquedeta = await loadMoves(char.slug, techData);

        html += `
            <section id="${char.slug}-section">
                <h2>${escapeHtml(char.jp)}</h2>
                <div class="listflex">
                    <div>
                        <div class="name-img">
                            <img width="360" src="../img/character/${encodeURIComponent(char.slug)}_ss01.jpg" alt="${escapeHtml(char.jp)}">
                        </div>
                    </div>
                    <div class="list char-list" data-section="${escapeHtml(char.slug)}">
                        <span class="list-label"><span class="glyphicon glyphicon-th-list"></span>目次</span>
                        <ul class="scrollable">
                            <li><a href="#${escapeHtml(char.slug)}-techniquedeta"><span class="glyphicon glyphicon-play"></span>技データ</a></li>
                            <li><a href="#${escapeHtml(char.slug)}-technique"><span class="glyphicon glyphicon-play"></span>立ち回り</a></li>
                            <li><a href="#${escapeHtml(char.slug)}-intrinsic"><span class="glyphicon glyphicon-play"></span>連携崩し</a></li>
                            <li><a href="#${escapeHtml(char.slug)}-combo"><span class="glyphicon glyphicon-play"></span>確定反撃</a></li>
                        </ul>
                    </div>
                </div>
                ${techniquedeta}
            </section>
        `;
    }

    container.innerHTML = html;
}

renderCounterPage();

// ============================
// 技データ読込（DBから取得）
// ============================
async function loadMoves(slug, techData = []) {
    const res = await fetch(`../api/get_countermeasure.php?char_slug=${encodeURIComponent(slug)}`);
    if (!res.ok) {
        console.warn(`${slug}: API fetch failed (${res.status})`);
        return '';
    }

    const data = await res.json();

    if (!Array.isArray(data) || data.length === 0) {
        console.warn(`${slug}: 技データが空のためスキップされました`);
        return `<div id="${escapeHtml(slug)}-techniquedeta"><h3>技データ</h3><p>まだ技データが登録されていません。</p></div>`;
    }

    const charTech = (Array.isArray(techData) && techData.find(t => t.slug === slug)) ? techData.find(t => t.slug === slug) : null;

    const grouped = {};
    data.forEach(row => {
        const key = (row.move_type || '').trim().toLowerCase();
        if (!grouped[key]) grouped[key] = [];
        grouped[key].push(row);
    });

    const moveTypeOrder = [
        { key: 'normal_moves', label: '通常技' },
        { key: 'unique_attacks', label: '特殊技' },
        { key: 'special_moves', label: '必殺技' },
        { key: 'super_arts', label: 'スーパーアーツ' },
        { key: 'throws', label: '通常投げ' },
        { key: 'common_moves', label: '共通システム' }
    ];

    let html = `
        <div id="${escapeHtml(slug)}-techniquedeta">
            <h3>技データ</h3>
            <div class="scroll">
                <table class="technique-data-table">
                    <thead>
                        <tr>
                            <th>技名</th>
                            <th>発生</th>
                            <th>持続</th>
                            <th>硬直</th>
                            <th>ヒット</th>
                            <th>ガード</th>
                            <th>キャンセル</th>
                            <th>属性</th>
                            <th>備考</th>
                        </tr>
                    </thead>
                    <tbody>
    `;

    for (const type of moveTypeOrder) {
        const rows = grouped[type.key];
        if (!rows || rows.length === 0) continue;

        html += `
            <tr class="move-type-header">
                <th colspan="9">${escapeHtml(type.label)}</th>
            </tr>
        `;

        rows.forEach(row => {
            let commandHtml = '';
            if (row.command && String(row.command).trim() !== '') {
                commandHtml = expandCommand(String(row.command).trim());
            } else {
                if (charTech && charTech[type.key]) {
                    const moveInfo = charTech[type.key].find(m => m.slug === String(row.technique_slug || row.move_slug).trim());
                    if (moveInfo && moveInfo.command) {
                        commandHtml = expandCommand(moveInfo.command);
                    }
                }
                if (!commandHtml && row.move_slug) {
                    const slugKey = String(row.move_slug).trim();
                    if (moveMap[slugKey]) {
                        commandHtml = expandCommand(moveMap[slugKey]);
                    } else {
                        // 直接 move_slug が "PP" や "HPHK" のような場合も splitButtons に通す
                        commandHtml = String(slugKey).replace(/[A-Za-z0-9]+/g, token => {
                            return splitButtons(token).join('') || `<span class="cmd-text">${escapeHtml(token)}</span>`;
                        });
                    }
                }
            }

            const miscText = row.miscellaneous
                ? escapeHtml(row.miscellaneous).replace(/\|\|\|/g, '<br>')
                : '';

            html += `
                <tr>
                    <td>
                        <div class="move-name">${escapeHtml(row.move_name_jp || row.move_name || '')}</div>
                        <div class="move-command">${commandHtml}</div>
                    </td>
                    <td>${escapeHtml(row.startup || '')}</td>
                    <td>${escapeHtml(row.active || '')}</td>
                    <td>${escapeHtml(row.recovery || '')}</td>
                    <td>${escapeHtml(row.hit_adv || '')}</td>
                    <td>${escapeHtml(row.guard_adv || '')}</td>
                    <td>${escapeHtml(row.cancel || '')}</td>
                    <td>${escapeHtml(row.properies || '')}</td>
                    <td><span>${miscText}</td>
                </tr>
            `;
        });
    }

    html += `
                    </tbody>
                </table>
            </div>
        </div>
    `;
    return html;
}


function initScrollTable(scroll) {
  if (!scroll || scroll.dataset.initialized === "true") return;
  scroll.dataset.initialized = "true";

  const table = scroll.querySelector("table");
  if (!table) return;

  // === 横スクロールをドラッグで実現 ===
  let isDown = false;
  let startX;
  let scrollLeft;

  table.addEventListener("mousedown", (e) => {
    if (e.button !== 0) return; // 左クリックのみ
    isDown = true;
    scroll.classList.add("dragging");
    startX = e.pageX;
    scrollLeft = scroll.scrollLeft;
    e.preventDefault();
  });

  table.addEventListener("mouseleave", () => {
    isDown = false;
    scroll.classList.remove("dragging");
  });

  table.addEventListener("mouseup", () => {
    isDown = false;
    scroll.classList.remove("dragging");
  });

  table.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX;
    const walk = (x - startX) * 1.2;
    scroll.scrollLeft = scrollLeft - walk;
  });

  // === 影の表示制御 ===
  const updateShadow = () => {
    const isAtLeft = Math.floor(scroll.scrollLeft) <= 0;
    if (isAtLeft) {
      scroll.classList.add("left-edge");
    } else {
      scroll.classList.remove("left-edge");
    }
  };

  scroll.addEventListener("scroll", updateShadow);
  updateShadow(); // 初期実行
  syncScrollShadowHeight();
}

function observeScrollTables() {
  // 初期の.scrollを登録
  document.querySelectorAll(".scroll").forEach(initScrollTable);

  // 新たに.scrollが追加された時を監視
  const observer = new MutationObserver((mutations) => {
    for (const mutation of mutations) {
      mutation.addedNodes.forEach(node => {
        if (node.nodeType !== 1) return;
        if (node.classList && node.classList.contains("scroll")) {
          initScrollTable(node);
        } else {
          // 内部に.scrollがある場合も検出
          node.querySelectorAll?.(".scroll").forEach(initScrollTable);
        }
      });
    }
  });

  observer.observe(document.body, {
    childList: true,
    subtree: true
  });
}

function syncScrollShadowHeight() {
  const scrolls = document.querySelectorAll('.scroll');
  scrolls.forEach(scroll => {
    const table = scroll.querySelector('.technique-data-table');
    if (!table) return;

    // 初回設定
    scroll.style.setProperty('--scroll-shadow-height', `${table.offsetHeight}px`);

    // 高さ変化を監視（テーブルの内容変化・ロード遅延対応）
    const resizeObserver = new ResizeObserver(() => {
      scroll.style.setProperty('--scroll-shadow-height', `${table.offsetHeight}px`);
    });
    resizeObserver.observe(table);
  });
}

// ページ読み込み完了後に監視を開始
document.addEventListener("DOMContentLoaded", observeScrollTables);