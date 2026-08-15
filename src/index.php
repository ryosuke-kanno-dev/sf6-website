<?php
// 1. ページ固有の設定値
$page_title = "SF6 PORTAL | ストリートファイター6 攻略ポータル";
$current_page = "home";

// 2. トップページ専用CSSの追加指定
$extra_css = ['css/layouts/pattern-a-layout.css'];

// 3. Head部分の読み込み
include 'includes/head.php';
?>

<!-- 4. 共通ヘッダー読み込み -->
<?php include 'includes/header.php'; ?>

<!-- 5. SF6本編風 ヒーローメインエリア -->
<section class="hero-container">
  
  <div class="hero-title">FIGHTING PORTAL MENU</div>

  <!-- カルーセルメニュー -->
  <div class="menu-carousel">
    <div class="carousel-arrow">&laquo;</div>
    
    <div class="carousel-track">
      <div class="menu-card" data-menu="1" onmouseover="updateMenu(1)" onclick="updateMenu(1)">
        <span class="menu-num">01. SETTINGS</span>
        <span class="menu-name">初期設定</span>
      </div>

      <div class="menu-card" data-menu="2" onmouseover="updateMenu(2)" onclick="updateMenu(2)">
        <span class="menu-num">02. PRACTICE</span>
        <span class="menu-name">トレモ練習</span>
      </div>

      <div class="menu-card active" data-menu="3" onmouseover="updateMenu(3)" onclick="updateMenu(3)">
        <span class="menu-num">03. CHARACTERS</span>
        <span class="menu-name">キャラ攻略</span>
      </div>

      <div class="menu-card" data-menu="4" onmouseover="updateMenu(4)" onclick="updateMenu(4)">
        <span class="menu-num">04. ROADMAP</span>
        <span class="menu-name">ロードマップ</span>
      </div>

      <div class="menu-card" data-menu="5" onmouseover="updateMenu(5)" onclick="updateMenu(5)">
        <span class="menu-num">05. GLOSSARY</span>
        <span class="menu-name">用語集</span>
      </div>
    </div>

    <div class="carousel-arrow">&raquo;</div>
  </div>

  <!-- 中央下：選択中メニューのサブ展開枠 -->
  <div class="sub-menu-box">
    <div class="sub-menu-title" id="subMenuTitle">3. キャラ攻略 - QUICK JUMP</div>
    <div class="sub-menu-links" id="subMenuLinks"></div>
  </div>

  <!-- 最下部：ガイドメッセージ -->
  <div class="guide-bar">
    <span class="icon">💬</span>
    <span id="guideText">全キャラクターのコンボレシピ・確定反撃・フレームデータを検索できます。</span>
  </div>

</section>

<!-- 6. 下部サブエリア -->
<div class="bottom-section">
  <div class="section-box">
    <div class="section-title">最新更新情報 / 注目のコンボレシピ</div>
    <ul class="info-list">
      <li>・[2026/08/14] ルークの基本〜応用コンボ動画を更新しました</li>
      <li>・[2026/08/10] 初心者向け「1. 初期おすすめキーコンフィグ」を追加</li>
      <li>・[2026/08/05] 格ゲー用語集に「パニカン」「ドライブリバーサル」を追加</li>
    </ul>
  </div>

  <div class="section-box">
    <div class="section-title">ピックアップキャラ</div>
    <div class="char-tag-wrapper">
      <a href="character.php?char=luke" class="char-tag">ルーク</a>
      <a href="character.php?char=ryu" class="char-tag">リュウ</a>
      <a href="character.php?char=ken" class="char-tag">ケン</a>
      <a href="character.php?char=chunli" class="char-tag">春麗</a>
    </div>
  </div>
</div>

<!-- 7. トップページ専用カルーセル動作用JavaScript -->
<script>
  const menuData = {
    1: {
      title: "1. 初期設定・環境構想 - QUICK JUMP",
      links: [
        { name: "キーコンフィグ設定", url: "guide.php#keyconfig" },
        { name: "画面・グラフィック", url: "guide.php#graphics" },
        { name: "サウンド設定", url: "guide.php#sound" }
      ],
      guide: "グラフィック設定や入力遅延軽減など、スト6を始める前にやっておくべき必須設定です。"
    },
    2: {
      title: "2. トレモ練習メニュー - QUICK JUMP",
      links: [
        { name: "対空練習", url: "training.php#anti-air" },
        { name: "確定反撃練習", url: "training.php#punish" },
        { name: "画面端抜け練習", url: "training.php#corner" }
      ],
      guide: "トレーニングモードのダミー設定や、効率的な反復練習レシピをまとめています。"
    },
    3: {
      title: "3. キャラ攻略 - QUICK JUMP",
      links: [
        { name: "ルーク", url: "character.php?char=luke" },
        { name: "リュウ", url: "character.php?char=ryu" },
        { name: "ケン", url: "character.php?char=ken" },
        { name: "春麗", url: "character.php?char=chunli" },
        { name: "全30+キャラ一覧...", url: "character.php" }
      ],
      guide: "全キャラクターのコンボレシピ・確定反撃・フレームデータを検索できます。"
    },
    4: {
      title: "4. 上達ロードマップ - QUICK JUMP",
      links: [
        { name: "ルーキー〜シルバー", url: "roadmap.php#step1" },
        { name: "ゴールド〜プラチナ", url: "roadmap.php#step2" },
        { name: "ダイヤ〜マスター", url: "roadmap.php#step3" }
      ],
      guide: "自分のランクに合わせた目標・立ち回りの考え方・練習メニューのロードマップです。"
    },
    5: {
      title: "5. 格ゲー用語集 - QUICK JUMP",
      links: [
        { name: "50音検索", url: "glossary.php#index" },
        { name: "システム用語", url: "glossary.php#system" },
        { name: "フレーム知識", url: "glossary.php#frame" }
      ],
      guide: "「パニカン」「キャンセル」「フレーム」など、スト6や格ゲーで使われる用語の辞書です。"
    }
  };

  function updateMenu(id) {
    document.querySelectorAll('.menu-card').forEach(card => card.classList.remove('active'));
    const activeCard = document.querySelector(`.menu-card[data-menu="${id}"]`);
    if(activeCard) activeCard.classList.add('active');

    const data = menuData[id];
    document.getElementById('subMenuTitle').textContent = data.title;
    document.getElementById('guideText').textContent = data.guide;

    const linksContainer = document.getElementById('subMenuLinks');
    linksContainer.innerHTML = '';
    data.links.forEach(link => {
      const a = document.createElement('a');
      a.href = link.url;
      a.textContent = link.name;
      linksContainer.appendChild(a);
    });
  }

  // 初期表示（3. キャラ攻略を選択状態に）
  updateMenu(3);
</script>

<!-- 8. 共通フッター読み込み -->
<?php include 'includes/footer.php'; ?>