document.addEventListener('DOMContentLoaded', function () {
  termsDisplay();//用語の表示
});

function termsDisplay() {
  fetch('../data/terms.json')
    .then(response => response.json())
    .then(data => {
      const listContainers = document.querySelectorAll('.term-index');  
      const termContainer = document.getElementById('terms-container');

      // 行ごとのグルーピング定義
      const gojuonGroups = {
        "a-line": { label: "あ行", chars: "あいうえお" },
        "ka-line": { label: "か行", chars: "かきくけこ" },
        "sa-line": { label: "さ行", chars: "さしすせそ" },
        "ta-line": { label: "た行", chars: "たちつてと" },
        "na-line": { label: "な行", chars: "なにぬねの" },
        "ha-line": { label: "は行", chars: "はひふへほ" },
        "ma-line": { label: "ま行", chars: "まみむめも" },
        "ya-line": { label: "や行", chars: "やゆよ" },
        "ra-line": { label: "ら行", chars: "らりるれろ" },
        "wa-line": { label: "わ行", chars: "わをん" }
      };

      // 複数の .term-index に同じリストを出力
      listContainers.forEach(listContainer => {
        listContainer.insertAdjacentHTML('beforeend', `<span class="index-head">用語リスト</span>`);
        for (const [groupId, { label, chars }] of Object.entries(gojuonGroups)) {
          const termsInGroup = data.filter(term => chars.includes(term.kana.charAt(0)));
          
          if (termsInGroup.length > 0) {
            listContainer.insertAdjacentHTML('beforeend', `
              <div class="li-head"><a href="#${groupId}">${label}</a></div>
              <ul class="line50">
                ${termsInGroup.map(term => `<li><a href="#${term.slug}">${term.term}</a></li>`).join('')}
              </ul>
            `);
          }
        }
      });

      // --- 以下 termContainer の処理はそのまま ---
      for (const [groupId, { label, chars }] of Object.entries(gojuonGroups)) {
        const termsInGroup = data.filter(term => chars.includes(term.kana.charAt(0)));

        if (termsInGroup.length > 0) {
          let groupHtml = `<section class="term-group"><h3 id="${groupId}">${label}</h3>`;

          termsInGroup.forEach(term => {
            let html = `
              <div class="term-block">
                <h4 id="${term.slug}">${term.term}</h4>
                <p>${term.text}</p>
            `;

            if (term.list) {
              term.list.forEach(section => {
                html += `<span class="list-head">${section.title}</span><ul class="term-list">`;
                section.rows.forEach(row => {
                  if (row.length === 1) {
                    html += `<li>${row[0]}</li>`;
                  } else {
                    html += `<li>${row[0]}: ${row.slice(1).join(", ")}</li>`;
                  }
                });
                html += `</ul>`;
              });
            }

            if (term.table) {
              const tables = Array.isArray(term.table) ? term.table : [term.table];
              tables.forEach(tableData => {
                let tableHtml = '';
                if (tableData.title) {
                  tableHtml += `<span class="table-head">${tableData.title}</span>`;
                }
                tableHtml += `<div class="term-table"><table>`;
                if (tableData.headers?.length) {
                  tableHtml += `<thead><tr>`;
                  tableData.headers.forEach(h => tableHtml += `<th>${h}</th>`);
                  tableHtml += `</tr></thead>`;
                }
                tableHtml += `<tbody>`;
                tableData.rows.forEach(row => {
                  tableHtml += `<tr>${row.map(cell => `<td>${cell}</td>`).join("")}</tr>`;
                });
                tableHtml += `</tbody></table></div>`;
                html += tableHtml;
              });
            }

            if (term.php) {
              html += `<div class="php-block" id="php-${term.slug}">読み込み中...</div>`;
            }

            html += `</div>`;
            groupHtml += html;

            if (term.php) {
              fetch(`../partials/${term.php}.php`)
                .then(r => r.text())
                .then(phpContent => {
                  document.getElementById(`php-${term.slug}`).innerHTML = phpContent;
                })
                .catch(err => {
                  document.getElementById(`php-${term.slug}`).innerHTML = `<p>読み込み失敗: ${err}</p>`;
                });
            }
          });

          groupHtml += `</section>`;
          termContainer.insertAdjacentHTML('beforeend', groupHtml);
        }
      }
    });
}

