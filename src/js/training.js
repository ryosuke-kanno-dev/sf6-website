document.addEventListener('DOMContentLoaded', () => {
  Promise.all([
    fetch('../data/trainings.json').then(res => res.json()),
    fetch('../data/training-slots.json').then(res => res.json())
  ])
  .then(([trainings, slots]) => {
    const container = document.getElementById('training-container');
    trainings.forEach((item, i) => {
      // ★ sampleデータはスキップ
      if (item.title === "sample") return;

      container.appendChild(createSection(item, `section${i+1}`, slots));
    });
    generateNav();
    bindModalToImages();
  })
  .catch(err => console.error("データ読み込み失敗:", err));
});

/** キャラ名でスロットデータを取得 */
function getCharacterSlots(slotsData, character) {
  return slotsData.find(c => c.character === character) || null;
}

/** セクション生成 */
function createSection(item, id, slotsData) {
  const section = document.createElement('section');
  section.className = 'training-section';
  section.id = id;

  const charSlots = getCharacterSlots(slotsData, item.character);
  const settingsHtml = generateSettings(item.settings, charSlots);

  // 🎥 動画のカスタマイズ
  const videoHtml = item.video ? `
    <div class="training-video">
      <h4 class="h4-training">実践動画</h4>
      <video 
        controls 
        muted 
        width="50%" 
        disablePictureInPicture 
        controlsList="nodownload noplaybackrate noremoteplayback" 
        oncontextmenu="return false;"
      >
        <source src="../video/trainings/${item.video.file}.mp4" type="video/mp4">
        このブラウザは動画再生に対応していません
      </video>
    </div>` : '';

  const tableHtml = item.table ? `
    <div class="training-table-block">
      <h4 class="h4-training">詳細行動表</h4>
      ${generateTable(item.table)}
    </div>` : '';

  section.innerHTML = `
    <h3 class="training-head">${item.title}</h3>
    <div class="training-body">
      <div class="training-char">
        <img src="${item.image.src}" alt="${item.character}画像">
        <span>相手キャラ: ${item.character}</span>
      </div>
      <p class="training-explain">${item.text}</p>

      <div class="training-tags">
        ${item.tags?.map(t => `<span class="tag">${t}</span>`).join('') || ''}
      </div>

      ${settingsHtml}
      ${videoHtml}
      ${tableHtml}
    </div>
  `;
  return section;
}

/** 設定項目生成 */
function generateSettings(settings, charSlots) {
  if (!settings || !charSlots) return "";
  let html = `<div class="training-settings">`;

  // ダミー
  if (settings.dummy) {
    html += `
      <div class="setting-block">
        <h4 class="h4-training">ダミー設定</h4>
        <p>${settings.dummy.note || "変更なし"}</p>
        ${settings.dummy.image ? `<img class="content-img" src="${settings.dummy.image}" alt="ダミー設定">` : ''}
      </div>`;
  }

  // レコード
  if (settings.record) {
    html += `
      <div class="setting-block">
        <h4 class="h4-training">レコード設定</h4>
        <p>${settings.record.note || "変更なし"}</p>
    `;
    if (settings.record.slots && settings.record.slots.length > 0) {
      html += `<div class="counter-block"><h5 class="h5-training">レコード</h5>
        <table class="record-table counter-table"><tbody>`;
      settings.record.slots.forEach(slotNum => {
        const match = charSlots.record.find(s => s.slots === slotNum);
        if (match) {
          html += `<tr><td>スロット${match.slots}</td><td>${match.action}</td></tr>`;
        }
      });
      html += `</tbody></table>`;
    }
    html += `</div></div>`;
  }

  // 反撃設定
  if (settings.counter) {
    html += `
      <div class="setting-block">
        <h4 class="h4-training">反撃設定</h4>
        <div class="counter-group">`;

    const categories = {
      down: "ダウンリバーサル",
      guard: "ガードリバーサル",
      damage: "ダメージ復帰リバーサル"
    };

    Object.entries(categories).forEach(([key, label]) => {
      const slotNums = settings.counter[key] || [];
      if (slotNums.length > 0) {
        html += `<div class="counter-block"><h5 class="h5-training">${label}</h5>
                 <table class="counter-table"><tbody>`;
        slotNums.forEach(num => {
          const match = charSlots[key]?.find(s => s.slots === num);
          if (match) {
            html += `<tr><td>スロット${match.slots}</td><td>${match.action}</td></tr>`;
          }
        });
        html += `</tbody></table></div>`;
      }
    });

    html += `</div></div>`;
  }

  html += `</div>`;
  return html;
}

/** 詳細行動表 */
function generateTable(rows) {
  let html = `<table class="training-table">
    <thead><tr><th>No</th><th>相手の行動</th><th></th><th>対応行動</th></tr></thead><tbody>`;
  rows.forEach((r, i) => {
    html += `<tr><td>${i+1}</td><td>${r.action}</td><td>=</td><td>${r.response}</td></tr>`;
  });
  html += `</tbody></table>`;
  return html;
}

/** ナビ生成 */
function generateNav() {
  const navContainers = document.querySelectorAll('.training-nav');
  const sections = document.querySelectorAll('section.training-section');
  const ul = document.createElement('ul');
  sections.forEach(sec => {
    const id = sec.id;
    const title = sec.querySelector('.training-head')?.textContent.trim();
    if (!id || !title) return;
    const li = document.createElement('li');
    const a = document.createElement('a');
    a.href = `#${id}`;
    a.textContent = title;
    li.appendChild(a);
    ul.appendChild(li);
  });
  navContainers.forEach(c => c.appendChild(ul.cloneNode(true)));
}
