document.addEventListener('DOMContentLoaded', function () {
    tutorialDiv();//チュートリアルの表示
});

function tutorialDiv(){
    fetch("../data/tutorials.json")
    .then(response => response.json())
    .then(data => {
        const tutorialDiv = document.getElementById("tutorial");

        // --- 切り替えボタン作成 ---
        const nav = document.createElement("div");
        nav.className = "tutorial-nav";
        data.forEach(section => {
        const btn = document.createElement("button");
        btn.className = section.en;
        btn.textContent = section.jp;
        btn.onclick = () => showSection(section.en);
        nav.appendChild(btn);
        });
        tutorialDiv.appendChild(nav);

        // --- セクション出力 ---
        data.forEach((section, secIndex) => {
        const sectionEl = document.createElement("section");
        sectionEl.id = section.en;
        sectionEl.style.display = (secIndex === 0 ? "block" : "none"); // 初期は beginnerのみ

        // h3
        
        const h3 = document.createElement("h3");
        h3.textContent = section.jp;
        sectionEl.appendChild(h3);

        // --- リスト作成 ---
        const listDiv = document.createElement("div");
        listDiv.className = "list";
        listDiv.dataset.section = section.en;

        const spanLabel = document.createElement("span");
        spanLabel.className = "list-label";
        spanLabel.innerHTML = `<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>${section.jp}`;
        listDiv.appendChild(spanLabel);

        const ul = document.createElement("ul");

        // --- itemごとの処理 ---
        section.item.forEach((item, idx) => {
            const chapterId = `chapter${secIndex + 1}-${idx + 1}`;

            // リスト用 li
            const li = document.createElement("li");
            const a = document.createElement("a");
            a.className = "link";
            a.href = `#${chapterId}`;
            a.textContent = `${idx + 1}.${item.title}`;
            li.appendChild(a);
            ul.appendChild(li);

            // h4（title）
            const h4 = document.createElement("h4");
            h4.id = chapterId;
            h4.textContent = item.title;
            sectionEl.appendChild(h4);

            // contents
            item.contents.forEach(content => {
            const h5 = document.createElement("h5");
            h5.textContent = content.subtitle;
            sectionEl.appendChild(h5);

            // subcontents がある場合
            if (content.subcontents) {
                content.subcontents.forEach((sub, subIdx) => {
                if (sub.head) {
                    const h6 = document.createElement("h6");
                    h6.textContent = sub.head;
                    sectionEl.appendChild(h6);
                }

                // imgs
                if (sub.imgs) {
                    sub.imgs.forEach((img, i) => {
                    const imgEl = document.createElement("img");
                    imgEl.className = "content-img";
                    imgEl.src = `../img/tutorial/${img}.png`;
                    imgEl.alt = `${sub.head || content.subtitle}-${i+1}`;
                    sectionEl.appendChild(imgEl);
                    });
                }

                // videos
                if (sub.videos) {
                    sub.videos.forEach(video => {
                        const videoWrapper = document.createElement("div"); // ← div作成
                        videoWrapper.className = "video";

                        const videoEl = document.createElement("video");
                        videoEl.autoplay = true;
                        videoEl.loop = true;
                        videoEl.muted = true;
                        videoEl.width = 650;

                        const sourceEl = document.createElement("source");
                        sourceEl.src = `../video/tutorial/${section.en}/${video}.mp4`;
                        sourceEl.type = "video/mp4";

                        videoEl.appendChild(sourceEl);
                        videoWrapper.appendChild(videoEl); // ← videoをdivに入れる
                        sectionEl.appendChild(videoWrapper); // ← divをsectionに入れる
                    });
                }

                // text
                if (sub.text) {
                    const p = document.createElement("p");
                    p.innerHTML = sub.text;
                    sectionEl.appendChild(p);
                }
                });
            } else {
                // subcontents が無い場合
                if (content.imgs) {
                content.imgs.forEach((img, i) => {
                    const imgEl = document.createElement("img");
                    imgEl.className = "content-img";
                    imgEl.src = `../img/tutorial/${img}.png`;
                    imgEl.alt = `${content.subtitle}-${i+1}`;
                    sectionEl.appendChild(imgEl);
                });
                }
                if (content.videos) {
                    content.videos.forEach(video => {
                        const videoWrapper = document.createElement("div"); // ← div作成
                        videoWrapper.className = "video";

                        const videoEl = document.createElement("video");
                        videoEl.autoplay = true;
                        videoEl.loop = true;
                        videoEl.muted = true;
                        videoEl.width = 650;

                        const sourceEl = document.createElement("source");
                        sourceEl.src = `../video/tutorial/${section.en}/${video}.mp4`;
                        sourceEl.type = "video/mp4";

                        videoEl.appendChild(sourceEl);
                        videoWrapper.appendChild(videoEl); // ← videoをdivに入れる
                        sectionEl.appendChild(videoWrapper); // ← divをsectionに入れる
                    });
                }
                if (content.text) {
                const p = document.createElement("p");
                p.innerHTML = content.text;
                sectionEl.appendChild(p);
                }
            }
            });
        });

        listDiv.appendChild(ul);
        sectionEl.insertBefore(listDiv, sectionEl.children[1]); // h3の直後にリスト挿入
        tutorialDiv.appendChild(sectionEl);
        });

        // --- 表示切り替え関数 ---
        function showSection(id) {
        data.forEach(section => {
            const el = document.getElementById(section.en);
            el.style.display = (section.en === id ? "block" : "none");
            setupDynamicList();
        });
        }
    })
    .catch(err => console.error("Error loading tutorials.json:", err));
}