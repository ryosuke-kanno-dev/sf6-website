document.addEventListener('DOMContentLoaded', function () {
  highlightCurrentPage();//開いているサイトの背景色
  setupDynamicNist();//ページごとのセクションナビゲーション表示
  setupDynamicList();//セクションごとのリスト表示
  modalImageSetup();//画像クリックで拡大表示
  bindModalToImages();//2度目の拡大表示
  //characterTable();キャラクター一覧表の表示
});

function highlightCurrentPage() {
  const currentPath = window.location.pathname.split('/').pop();
  const links = document.querySelectorAll('.prologue-table a');
  links.forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPath) {
      link.parentElement.style.backgroundColor = '#FFE136';
      link.parentElement.style.fontWeight = 'bold';
    }
  });
}

function setupDynamicNist() {
  const sectionNav = document.querySelector("nav.section-nav");
  const termList = document.querySelector("div.term-index");
  const topSticky = document.querySelector(".top-sticky");

  if ((sectionNav || termList) && topSticky) {
    // 既に追加済みのナビがあれば削除
    const oldClone = topSticky.querySelector(".dynamic-nist");
    if (oldClone) {
      oldClone.remove();
    }

    // 優先度：sectionNav → termList
    const source = sectionNav || termList;
    const clone = source.cloneNode(true);

    // 識別用クラスを付与
    clone.classList.add("dynamic-nist");
    topSticky.appendChild(clone);

    // 複製された nav 内のリンクを取得
    const navLinks = clone.querySelectorAll("a[href^='#']");
    const sections = [];

    navLinks.forEach(link => {
      const targetId = link.getAttribute("href");
      const targetEl = document.querySelector(targetId);
      if (targetEl) {
        sections.push({ link, targetEl });
      }
    });

    // スクロール監視
    window.addEventListener("scroll", () => {
      let currentSection = null;

      sections.forEach(({ link, targetEl }) => {
        const rect = targetEl.getBoundingClientRect();
        if (rect.top <= 100 && rect.bottom > 100) {
          currentSection = link;
        }
      });

      navLinks.forEach(l => l.classList.remove("active-section"));
      if (currentSection) {
        currentSection.classList.add("active-section");
      }
    });
  }
}



function setupDynamicList() {
  const firstSticky = document.querySelector('.top-sticky'); // 上に固定するもの（旧 right-table）
  const secondSticky = document.querySelector('.sticky-secod'); // サイドのナビ

  const rightNav = document.querySelector('.right-list'); // 出力先コンテナ
  const sections = document.querySelectorAll('section'); // すべてのsectionを対象にする

  // 高さを監視して secondSticky をずらす
  const observer = new ResizeObserver(() => {
    if (firstSticky && secondSticky) {
      const height = firstSticky.offsetHeight;
      const offset = 15;
      secondSticky.style.top = (height + offset) + 'px';
    }
  });

  if (firstSticky) {
    observer.observe(firstSticky);
  }

  if (!rightNav || sections.length === 0) return;

  // list全体を取る（ラベル＋ul）
  const getListFrom = (section) => {
    const list = section.querySelector('.list');
    if (!list) return null;
    return list;
  };

  function updateSectionNav() {
    let currentSection = null;
    const midpoint = window.scrollY + window.innerHeight / 2;

    sections.forEach(section => {
      const rect = section.getBoundingClientRect();
      const top = window.scrollY + rect.top;
      const bottom = top + rect.height;

      if (midpoint >= top && midpoint < bottom) {
        currentSection = section;
      }
    });

    if (currentSection) {
      const list = getListFrom(currentSection);

      if (list) {
        if (rightNav.innerHTML !== list.innerHTML) {
          rightNav.innerHTML = '';
          rightNav.appendChild(list.cloneNode(true)); // .list 全体をコピー
        }
      } else {
        rightNav.innerHTML = '';
      }
    } else {
      rightNav.innerHTML = '';
    }
  }

  updateSectionNav();
  window.addEventListener('scroll', updateSectionNav);
}


let modalOverlay, modalImg;
function modalImageSetup() {
  if (!modalOverlay) {
    modalOverlay = document.createElement('div');
    modalOverlay.className = 'modal-overlay';
    modalImg = document.createElement('img');
    modalImg.className = 'modal-content';
    modalOverlay.appendChild(modalImg);
    document.body.appendChild(modalOverlay);

    modalOverlay.addEventListener('click', () => {
      modalOverlay.style.display = 'none';
    });
  }
}

function bindModalToImages(selector = '.content-img') {
  document.querySelectorAll(selector).forEach(img => {
    img.addEventListener('click', () => {
      modalImg.src = img.src;
      modalOverlay.style.display = 'flex';
    });
  });
}


function characterTable() {
  fetch('../data/character.json')
    .then(response => response.json())
    .then(characters => {
      const targets = document.querySelectorAll('.character-table');

      targets.forEach(container => {
        const table = document.createElement("table");
        const header = document.createElement("tr");
        const th = document.createElement("th");
        th.setAttribute("colspan", "4");

        const headerWrapper = document.createElement("div");
        headerWrapper.className = "characterHeaderWrapper";

        const titleSpan = document.createElement("span");
        titleSpan.textContent = "キャラクター一覧";

        const toggleWrapper = toggleButton();
        headerWrapper.appendChild(titleSpan);
        headerWrapper.appendChild(toggleWrapper);
        th.appendChild(headerWrapper);
        header.appendChild(th);
        table.appendChild(header);

        for (let i = 0; i < characters.length; i += 4) {
          const row = document.createElement("tr");
          for (let j = 0; j < 4; j++) {
            const char = characters[i + j];
            const td = document.createElement("td");
            if (char) {
              const a = document.createElement("a");
              a.className = "link";
              a.href = `#${char.slug}-section`;

              const img = document.createElement("img");
              img.className = "rightLink";
              img.src = `../img/character/${char.slug}_ss02.jpg`;
              img.alt = char.jp;

              a.appendChild(img);
              a.appendChild(document.createTextNode(char.jp));
              td.appendChild(a);
            }
            row.appendChild(td);
          }
          table.appendChild(row);
        }
        container.appendChild(table);
      });

      // ▼ イベント設定
      setupToggleSync();
      setupCharacterClick();

      // 🔽 ここを追加：初期表示処理をDOM生成後に行う
      initializeCharacterView(); // ★追加
    })
    .catch(error => {
      console.error("キャラクターデータの読み込みに失敗しました:", error);
    });
}

function initializeCharacterView() {
  const toggle = document.querySelector('.characterViewToggleInput');
  const label = document.querySelector('.toggleLabelText');
  const sections = document.querySelectorAll('section[id$="-section"]');

  if (!toggle || sections.length === 0) return;

  // トグルOFFに設定
  toggle.checked = false;
  if (label) label.textContent = ''//単;

  // 最初のキャラだけ表示
  const firstSlug = sections[0].id.replace('-section', '');
  showSingleCharacter(firstSlug);
}


function toggleButton() {
  // トグルボタンを生成して返す
  const toggleWrapper = document.createElement("div");
  toggleWrapper.className = "characterViewToggle";
  toggleWrapper.innerHTML = `
    <label class="toggle-button-2">
      <input type="checkbox" class="characterViewToggleInput">
      <span class="toggleLabelText"></span>
      <span class="circle"><span class="circleText"></span></span>
    </label>
  `;
  return toggleWrapper;
}

//すべてのトグルを連動させる処理
function setupToggleSync() {
  const toggles = document.querySelectorAll('.characterViewToggleInput');
  const labels = document.querySelectorAll('.toggleLabelText');

  toggles.forEach(toggle => {
    toggle.addEventListener('change', e => {
      const isChecked = e.target.checked;

      // すべてのトグルを同じ状態に更新
      toggles.forEach(t => (t.checked = isChecked));
      labels.forEach(label => {
        label.textContent = isChecked
          ? ''//全
          : ''//単;
      });

      // 実際の表示切り替え処理
      toggleCharacterView(isChecked);
    });
  });
}

//キャラクターリンククリックで単キャラを選択する処理
function setupCharacterClick() {
  const charLinks = document.querySelectorAll('.character-table a.link');
  const sections = Array.from(document.querySelectorAll('section[id$="-section"]'));

  charLinks.forEach(link => {
    link.addEventListener('click', e => {
      const href = link.getAttribute('href'); // #luke-section
      const targetId = href.replace('#', '');
      const targetSection = document.getElementById(targetId);
      if (!targetSection) return;

      // 現在のトグル状態を確認
      const toggle = document.querySelector('.characterViewToggleInput');
      const isChecked = toggle ? toggle.checked : false;

      if (!isChecked) {
        // OFF時 → 単キャラ表示に切り替え
        e.preventDefault();
        showSingleCharacter(targetId.replace('-section', ''));
        targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
}

//トグルのオン・オフでキャラ表示切り替え
function toggleCharacterView(isChecked) {
  const sections = Array.from(document.querySelectorAll('section[id$="-section"]'));
  if (isChecked) {
    // ON → 全キャラ表示
    sections.forEach(sec => (sec.style.display = ''));
  } else {
    // OFF → 直前にクリックされたキャラがあればそれを表示
    const current = window.currentCharacter;
    if (current) {
      showSingleCharacter(current);
    } else if (sections.length > 0) {
      // 初回などは最初のキャラだけ表示
      const first = sections[0].id.replace('-section', '');
      showSingleCharacter(first);
    }
  }
}

//単キャラ表示
function showSingleCharacter(slug) {
  const sections = Array.from(document.querySelectorAll('section[id$="-section"]'));
  window.currentCharacter = slug; // 現在選択中キャラを記録
  sections.forEach(sec => {
    sec.style.display = sec.id === `${slug}-section` ? '' : 'none';
  });
}





// =========================================
// ======= コマンド省略マップ（先に定義） =======
// =========================================
const moveMap = {
    hadou: "236",
    tatsu: "214",
    shoryu: "623",
    hankai: "63214",
    sinhadou: "236236",
    sintatsu: "214214"
};

// ======= 画像対応マップ（先に定義） =======
const imageMap = {
    // 矢印
    "1": "arrow1.png",
    "2": "arrow2.png",
    "3": "arrow3.png",
    "4": "arrow4.png",
    "5": "arrow5.png",
    "6": "arrow6.png",
    "7": "arrow7.png",
    "8": "arrow8.png",
    "9": "arrow9.png",
    "+": "plus.png",

    // ボタン（小文字・大文字の両方入れておく）
    "lp": "lp.png",
    "lk": "lk.png",
    "mp": "mp.png",
    "mk": "mk.png",
    "hp": "hp.png",
    "hk": "hk.png",
    "p": "p.png",
    "k": "k.png",
    "LP": "lp.png",
    "LK": "lk.png",
    "MP": "mp.png",
    "MK": "mk.png",
    "HP": "hp.png",
    "HK": "hk.png",
    "P": "p.png",
    "K": "k.png",

    // その他
    "ikkai": "ikkai.png",
    "nikai": "nikai.png",
    "N": "neutral.png",
    "(or)": "or.png",
    "(長押し)": "naga.png",
    "(溜め2)": "charge_arrow2.png",
    "(溜め4)": "charge_arrow4.png",
    "(溜め6)": "charge_arrow6.png"
};

// ======= ヘルパー: 正規表現エスケープ =======
function escapeRegex(s) {
    return String(s).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

function expandMoveKeywordsInText(text) {
    if (!text) return text;
    let result = text;
    // キーの長いものから置換する（sintatsu のような長いキーが先に置換されるべきため）
    const keys = Object.keys(moveMap).sort((a,b) => b.length - a.length);
    for (const key of keys) {
        const value = moveMap[key];
        // (^|[^A-Za-z0-9]) (key) (?=[^A-Za-z0-9]|$)
        // 前に英数字がない or 先頭、後ろに英数字がない or 末尾 の場合に置換（日本語隣接もOK）
        const pattern = new RegExp(`(^|[^A-Za-z0-9])(${escapeRegex(key)})(?=[^A-Za-z0-9]|$)`, 'gi');
        result = result.replace(pattern, (match, pre, k) => {
            return pre + value;
        });
    }
    return result;
}

// ======= コマンド展開ヘルパー =======
function expandCommand(cmd) {
    if (!cmd) return '';

    // ★文中の moveMap キーワードも展開（改良版）
    cmd = expandMoveKeywordsInText(cmd);

    // ;「次の入力(▶)」の区切りとして使う仕様
    const parts = cmd.split(';').map(part => processSingleCommand(part.trim()));
    return parts.join(`<img src="../img/command/next.png" alt="▶" class="command">`);
}

function processSingleCommand(seq) {
    let output = '';
    if (!seq) return '';

    // 同時押しは '.' で区切る（例 hadou.P）
    if (seq.includes('.')) {
        const [moveKeyRaw, buttonSeqRaw] = seq.split('.');
        const moveKey = moveKeyRaw.trim();
        const buttonSeq = buttonSeqRaw ? buttonSeqRaw.trim() : '';
        let base = '';

        // まず moveKey が imageMap に直接あれば画像を使う
        if (imageMap[moveKey]) {
            base = `<img src="../img/command/${imageMap[moveKey]}" alt="${escapeHtml(moveKey)}" class="command">`;
        }
        // moveMap にマップされているキー（例 tatsu 等）は展開して矢印にする
        else if (moveMap[moveKey]) {
            base = convertDigitsToArrows(moveMap[moveKey]);
        }
        // 1-9 の数字列なら矢印に変換
        else if (/^[1-9]+$/.test(moveKey)) {
            base = convertDigitsToArrows(moveKey);
        }
        // 溜め表記や (or) 等は含まれるトークンを画像に置換
        else if (/\(溜め[2-6]\)/.test(moveKey) || /(\(or\)|[1-9]|N)/.test(moveKey)) {
            base = moveKey.replace(/\(or\)|\(溜め[2-6]\)|[1-9]|N/g, token => {
                if (imageMap[token]) {
                    return `<img src="../img/command/${imageMap[token]}" alt="${escapeHtml(token)}" class="command">`;
                }
                return escapeHtml(token);
            });
        } else {
            // ★ここを改良：moveKey の中の英数字列は splitButtons にかけて画像化する
            base = moveKey.replace(/[A-Za-z0-9]+/g, token => {
                // splitButtons は画像タグ配列を返すので join して挿入
                const imgs = splitButtons(token).join('');
                // splitButtons が何も変換できなかった場合はエスケープ文字列を返す
                return imgs || escapeHtml(token);
            });
        }

        const buttonImgs = splitButtons(buttonSeq).join('');
        output = base + `<img src="../img/command/plus.png" alt="+" class="command">` + buttonImgs;
    } else {
        // '.' がない場合（単純列）
        if (/^[1-9]+$/.test(seq)) {
            output = convertDigitsToArrows(seq);
        } else if (/\(溜め[2-6]\)/.test(seq) || /(\(or\)|[1-9]|N)/.test(seq)) {
            output = seq.replace(/\(or\)|\(溜め[2-6]\)|[1-9]|N/g, token => {
                if (imageMap[token]) {
                    return `<img src="../img/command/${imageMap[token]}" alt="${escapeHtml(token)}" class="command">`;
                }
                return escapeHtml(token);
            });
        } else {
            // ★ここも同様に文中の hadou/tatsu/shoryu 展開対応（既に expandCommand で実行済みだが二重対応で安全）
            seq = expandMoveKeywordsInText(seq);

            // 全体を、英数字の塊ごとに splitButtons で処理する（PP や HPHK を分割）
            output = seq.replace(/[A-Za-z0-9]+/g, token => {
                const imgs = splitButtons(token).join('');
                return imgs || escapeHtml(token);
            });
        }
    }

    return output;
}

function convertDigitsToArrows(numStr) {
    return numStr.replace(/[1-9]/g, n =>
        `<img src="../img/command/${imageMap[n]}" alt="${n}" class="command">`
    );
}

function splitButtons(seq) {
    // seq が空なら空配列
    if (!seq) return [];

    const result = [];
    let i = 0;
    // 長いキーを先に検出するため長さ順にソート（例 "HP" が "H"+"P" より優先）
    const keys = Object.keys(imageMap).sort((a, b) => b.length - a.length);

    while (i < seq.length) {
        let matched = false;
        for (let key of keys) {
            // ここは大文字小文字を区別して判定するため、直接 startsWith を使う
            if (seq.startsWith(key, i)) {
                result.push(`<img src="../img/command/${imageMap[key]}" alt="${escapeHtml(key)}" class="command">`);
                i += key.length;
                matched = true;
                break;
            }
            // 小文字・大文字の混在を意識して、キーをケース無視で照合する（例 seq="pp" でも "P" にマッチ）
            if (seq.substr(i, key.length).toUpperCase() === key.toUpperCase()) {
                // キーの大文字小文字バリエーションのうち imageMap に実際あるキーを探す
                let actualKey = Object.keys(imageMap).find(k => k.toUpperCase() === key.toUpperCase());
                if (actualKey) {
                    result.push(`<img src="../img/command/${imageMap[actualKey]}" alt="${escapeHtml(actualKey)}" class="command">`);
                    i += key.length;
                    matched = true;
                    break;
                }
            }
        }
        if (!matched) {
            // マッチしない単文字はそのままテキストで出す（安全のためエスケープ）
            result.push(`<span class="cmd-text">${escapeHtml(seq[i])}</span>`);
            i++;
        }
    }
    return result;
}

// HTMLエスケープ（XSS予防のため）
function escapeHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#39;');
}