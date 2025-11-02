document.addEventListener('DOMContentLoaded', function () {
  deviceList();
  additionalCharacter();//追加キャラクターを表示
});

function deviceList() {
  fetch("../data/devices.json")
    .then(response => response.json())
    .then(data => {
      const container = document.getElementById("device-list");
      container.innerHTML = ""; // 初期化

      let tocHtml = `
        <div class="list" data-section="device">
          <span class="list-label">
            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>目次
          </span>
          <ul>
      `;

      data.forEach(device => {
        tocHtml += `
          <li>
            <a href="#${device.type}">
              <span class="glyphicon glyphicon-play" aria-hidden="true"></span>${device.title}
            </a>
          </li>
        `;
      });
      tocHtml += `
          </ul>
        </div>
      `;

      let contentHtml = "";

      data.forEach(device => {
        let html = `<div class="device-section" id="${device.type}">`;
        html += `<h3>${device.title}</h3>`;

        // メリット
        if (Array.isArray(device.merit) && device.merit.length > 0) {
          html += `<h4>メリット</h4><ul>`;
          device.merit.forEach(m => {
            html += `<li>${m}</li>`;
          });
          html += `</ul>`;
        }

        // デメリット
        if (Array.isArray(device.demerit) && device.demerit.length > 0) {
          html += `<h4>デメリット</h4><ul>`;
          device.demerit.forEach(d => {
            html += `<li>${d}</li>`;
          });
          html += `</ul>`;
        }

        // おすすめポイント
        if (Array.isArray(device.recommend) && device.recommend.length > 0) {
          html += `<h4>おすすめコントローラー</h4><ul>`;
          device.recommend.forEach(r => {
            html += `<li>${r}</li>`;
          });
          html += `</ul>`;
        }

        // コントローラー紹介
        if (Array.isArray(device.controller) && device.controller.length > 0) {
          device.controller.forEach(ctrl => {
            html += `
              <div class="controller">
                <h5>${ctrl.name}</h5>
                <img class="content-img" src="../img/device/${ctrl.img}.jpg" alt="${ctrl.name}" />
                <div class="EC">
            `;

            // Amazonリンク（存在する場合のみ）
            if (ctrl.amazon) {
              html += `<a class="amazon" href="${ctrl.amazon}" target="_blank" rel="noopener noreferrer">Amazonで見る</a>`;
            }

            // 楽天リンク（存在する場合のみ）
            if (ctrl.rakuten) {
              html += `<a class="rakuten" href="${ctrl.rakuten}" target="_blank" rel="noopener noreferrer">楽天市場で見る</a>`;
            }

            // 公式サイトリンク（存在する場合のみ）
            if (ctrl.official) {
              html += `<a class="official" href="${ctrl.official}" target="_blank" rel="noopener noreferrer">公式サイトで見る</a>`;
            }

            html += `</div>`; // .EC

            if (Array.isArray(ctrl.pluspoint) && ctrl.pluspoint.length > 0) {
              html += `<div class="flex"><div><h6>良い点</h6><ul>`;
              ctrl.pluspoint.forEach(p => {
                html += `<li>${p}</li>`;
              });
              html += `</ul></div>`;
            }

            if (Array.isArray(ctrl.minuspoint) && ctrl.minuspoint.length > 0) {
              html += `<div><h6>悪い点</h6><ul>`;
              ctrl.minuspoint.forEach(m => {
                html += `<li>${m}</li>`;
              });
              html += `</ul></div></div>`;
            }
            html += `</div>`; // controller
          });
        }
        html += `</div>`; // device-section
        contentHtml += html;
      });

      container.innerHTML = tocHtml + contentHtml;
    })
    .catch(error => console.error("データ読み込みエラー:", error));
}


function additionalCharacter() {
  fetch("../data/additional-character.json")
    .then((response) => response.json())
    .then((data) => {
      const container = document.getElementById("character-years");

      data.forEach((year) => {
        // announce部分
        const announceTiming = year.announce?.find(a => a.timing)?.timing || "";
        const announceDate = year.announce?.find(a => a.date)?.date || "";

        // add部分（テーブルの行を動的に生成）
        let rowsHtml = "";
        year.add.forEach((charArr) => {
          // charArrは [{"char":..},{"season":..},{"date":..},{"text":..}] の配列
          const char = charArr.find(obj => obj.char)?.char || "";
          const season = charArr.find(obj => obj.season)?.season || "";
          const date = charArr.find(obj => obj.date)?.date || "";
          const text = charArr.find(obj => obj.text)?.text || "";

          rowsHtml += `
            <tr>
              <td>${char}</td>
              <td>${season}</td>
              <td>${date}</td>
              <td>${text}</td>
            </tr>
          `;
        });

        // 出力
        const html = `
          <div class="paragraph">
            <h4>Year${year.year}</h4>
            <img class="content-img" src="../img/official/year${year.year}-character.jpg" alt="${year.year}の追加キャラクター画像">
            <p>Year${year.year}のキャラクターは${announceDate}の${announceTiming}で発表された。</p>

            <table class="year-table">
              <thead>
                <tr><th>キャラ名</th><th>追加予定シーズン</th><th>追加日</th><th>キャラクター紹介</th></tr>
              </thead>
              <tbody>
                ${rowsHtml}
              </tbody>
            </table>
          </div>`;
        
        container.insertAdjacentHTML("beforeend", html);
      });
      bindModalToImages(); // ← modal.js 側の関数
    });
}