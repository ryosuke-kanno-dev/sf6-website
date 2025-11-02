
document.addEventListener('DOMContentLoaded', function () {
    adviceDisplay();//用語の表示
});

function adviceDisplay() {
    fetch('../data/advice.json')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('advice-container');

            data.forEach((rankData, index) => {
                //テンプレートだったら読み込まない
                if (rankData.enabled === false) return;

                const sectionId = `section${index + 2}`;



                // セクションのHTML生成
                const sectionHTML = `
                <section class="section" id="${sectionId}">
                    <h2>${rankData.rank}の人向け</h2>
                    <div class="list">
                    <span class="list-label"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>目次(${rankData.rank})</span>
                    <ul>
                        ${rankData.sections.map((s, i) =>
                    `<li><a href="#${sectionId}-${i + 1}"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>${s.title}</a></li>`
                ).join('')}
                    </ul>
                    </div>
                    ${rankData.sections.map((section, sIndex) =>
                    `<div class="subsection" id="${sectionId}-${sIndex + 1}">
                        <h3>${section.title}</h3>
                        ${section.items.map(item =>
                        `<div class="advice-content">
                            <h4>${item.subtitle}</h4>
                            <p>${item.content}</p>

                            ${item.subheading ? `<h5>${item.subheading}</h5>` : ""}
                            ${item.subcontent ? `<p>${item.subcontent}</p>` : ""}

                            ${item.image ? `
                                <img src="${item.image.src}" alt="${item.image.caption || ''}" class="content-img">
                            ` : ""}
                        </div>`
                    ).join('')}
                    </div>`
                ).join('')}
                </section>
                
                `;

                container.insertAdjacentHTML('beforeend', sectionHTML);
            });
            bindModalToImages(); // ← modal.js 側の関数
            setupDynamicNist();
            setupDynamicList();
        })
        .catch(error => {
            console.error("データの読み込みに失敗しました:", error);
        });
}