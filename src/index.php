<?php
// 1. ページ固有の設定値
$page_title = "SF6 PORTAL | ストリートファイター6 攻略ポータル";
$current_page = "home";

// 2. トップページ専用CSSの追加指定
$extra_css = ['css/layouts/pattern-a-layout.css'];

// 3. Head部分の読み込み
include 'includes/head.php';

// 4. DB接続・ヘルパー関数（ピックアップキャラのサムネイル表示用）
require_once 'includes/db.php';
require_once 'includes/functions/db_helpers.php';

// 5. 更新情報データの読み込み（BOM付きUTF-8ファイルに対応）
$updatesJsonRaw = file_get_contents(__DIR__ . '/data/updates.json');
$updatesJsonRaw = preg_replace('/^\xEF\xBB\xBF/', '', $updatesJsonRaw);
$allUpdates = json_decode($updatesJsonRaw, true) ?: [];

// 豪鬼特設ページの案内バナー用データ（url: "akuma" のエントリを専用に使う）
$akumaUpdate = null;
foreach ($allUpdates as $u) {
    if (($u['url'] ?? '') === 'akuma') { $akumaUpdate = $u; break; }
}

// 「最新更新情報」欄には、豪鬼の分を除いた直近3件を表示する
$listUpdates = array_values(array_filter($allUpdates, fn($u) => ($u['url'] ?? '') !== 'akuma'));
$listUpdates = array_slice($listUpdates, 0, 3);

// updates.json の url は combo.php / matchup.php など旧ページ構成のままのため、
// character.php への統合後の構成にマッピングする
function mapUpdateUrl(string $url): string {
    if ($url === 'akuma') return 'akuma.php';
    if (preg_match('/^combo\?chara=(.+)$/', $url, $m)) return 'character.php?char=' . urlencode($m[1]);
    if (preg_match('/^matchup\?opponent=(.+)$/', $url, $m)) return 'character.php?char=' . urlencode($m[1]) . '#tab-matchup';
    if (preg_match('/^training\?/', $url)) return 'training.php';
    if (preg_match('/^roadmap\?rank=(.+)$/', $url, $m)) return 'roadmap.php#rank-' . $m[1];
    if (preg_match('/^guide#(.+)$/', $url, $m)) return 'guide.php#' . $m[1];
    return h($url) . '.php';
}

// カテゴリ名 → タグバッジの表示（「コンボ」系だけアクセントカラーにする）
function updateTagClass(string $category): string {
    return (mb_strpos($category, 'コンボ') !== false) ? 'update-tag tag-combo' : 'update-tag';
}

// ピックアップキャラ（先頭4キャラを表示。サムネイルは file_exists() で自動フォールバック）
$pickupCharacters = array_slice(getAllCharacters($pdo), 0, 4);
?>

<!-- 6. 共通ヘッダー読み込み -->
<?php include 'includes/header.php'; ?>

<!-- 7. SF6本編風 ヒーローメインエリア -->
<section class="hero-container">

  <div class="hero-tagline">STREET FIGHTER 6 まとめ攻略データベース</div>
  <div class="hero-title">FIGHTING PORTAL MENU</div>

  <!-- メインメニュー（カルーセルではなく常時5件表示。ホバー/クリックでQUICK JUMPの中身が切り替わる） -->
  <div class="menu-carousel">
    <div class="carousel-track">
      <div class="menu-card" data-menu="1" onmouseover="updateMenu(1)" onclick="updateMenu(1)">
        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="7" width="18" height="11" rx="1"/><path d="M7 11h.01M11 11h.01M15 11h.01M7 14h10"/></svg>
        <span class="menu-num">01. SETTINGS</span>
        <span class="menu-name">初期設定</span>
      </div>

      <div class="menu-card" data-menu="2" onmouseover="updateMenu(2)" onclick="updateMenu(2)">
        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
        <span class="menu-num">02. PRACTICE</span>
        <span class="menu-name">トレモ練習</span>
      </div>

      <div class="menu-card active" data-menu="3" onmouseover="updateMenu(3)" onclick="updateMenu(3)">
        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="3.2"/><path d="M5.5 20c1-4 4-6 6.5-6s5.5 2 6.5 6"/></svg>
        <span class="menu-num">03. CHARACTERS</span>
        <span class="menu-name">キャラ攻略</span>
      </div>

      <div class="menu-card" data-menu="4" onmouseover="updateMenu(4)" onclick="updateMenu(4)">
        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 6l6-2 6 2 4-2v14l-4 2-6-2-6 2z"/><path d="M10 4v14M16 6v14"/></svg>
        <span class="menu-num">04. ROADMAP</span>
        <span class="menu-name">ロードマップ</span>
      </div>

      <div class="menu-card" data-menu="5" onmouseover="updateMenu(5)" onclick="updateMenu(5)">
        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M5 4h11a3 3 0 013 3v13H8a3 3 0 01-3-3z"/><path d="M5 17a3 3 0 003 3h11"/></svg>
        <span class="menu-num">05. GLOSSARY</span>
        <span class="menu-name">用語集</span>
      </div>
    </div>
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

<!-- 豪鬼特設ページ 案内バナー -->
<?php if ($akumaUpdate): ?>
<div class="akuma-promo-banner">
  <span class="promo-badge">SPECIAL</span>
  <div style="flex:1;">
    <div class="promo-title">豪鬼を極める者へ</div>
    <div class="promo-sub"><?php echo h($akumaUpdate['excerpt']); ?></div>
  </div>
  <a href="<?php echo h(mapUpdateUrl($akumaUpdate['url'])); ?>" class="promo-btn">特設ページへ →</a>
</div>
<?php endif; ?>

<!-- パッチノート要約 -->
<div class="patch-note-box">
  <div class="patch-note-head">
    <span class="patch-ver">Ver.2.030 対応済み</span>
    <span class="patch-status">✔ フレームデータ・キャラ対策を最新Verに反映済み</span>
  </div>
  <ul>
    <li>ドライブラッシュのガード硬直差を調整（+2F → +1F）</li>
    <li>春麗のEX百裂脚のダメージが減少</li>
    <li>新システム調整に伴う共通の立ち回り変化を反映</li>
  </ul>
</div>

<!-- 8. 下部サブエリア -->
<div class="bottom-section">
  <div class="section-box">
    <div class="section-title">最新更新情報 / 注目のコンボレシピ</div>
    <ul class="info-list">
      <?php foreach ($listUpdates as $u): ?>
        <li>
          <span class="<?php echo h(updateTagClass($u['category'] ?? '')); ?>"><?php echo h($u['category'] ?? ''); ?></span>
          <span class="update-date"><?php echo h(str_replace('-', '/', $u['date'] ?? '')); ?></span>
          <a href="<?php echo h(mapUpdateUrl($u['url'] ?? '')); ?>" style="color:inherit; text-decoration:none;"><?php echo h($u['title'] ?? ''); ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <div class="section-box">
    <div class="section-title">ピックアップキャラ</div>
    <div class="char-tag-wrapper">
      <?php foreach ($pickupCharacters as $char): ?>
        <?php
          $slug   = $char['char_slug'] ?? '';
          $nameJp = $char['name_jp'] ?? '';
          $nameEn = $char['name_en'] ?? $nameJp;
          $icon   = mb_strtoupper(mb_substr($nameEn !== '' ? $nameEn : $nameJp, 0, 1, 'UTF-8'), 'UTF-8');
          $thumbRelPath = 'img/character/' . $slug . '_ss02.jpg';
          $thumbFsPath  = __DIR__ . '/img/character/' . $slug . '_ss02.jpg';
          $hasThumbnail = ($slug !== '' && file_exists($thumbFsPath));
        ?>
        <a href="character.php?char=<?php echo urlencode($slug); ?>" class="char-tag">
          <?php if ($hasThumbnail): ?>
            <img class="char-tag-thumb" src="<?php echo h($thumbRelPath); ?>" alt="">
          <?php else: ?>
            <span class="char-tag-thumb-fallback"><?php echo h($icon); ?></span>
          <?php endif; ?>
          <?php echo h($nameJp); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- 9. トップページ専用カルーセル動作用JavaScript -->
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
        { name: "対空練習", url: "training.php#anti-air-001" },
        { name: "投げ抜け練習", url: "training.php#throw-escape-001" },
        { name: "起き攻め練習", url: "training.php#oki-001" }
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
        { name: "ビギナー", url: "roadmap.php#rank-beginner" },
        { name: "アイアン・ブロンズ", url: "roadmap.php#rank-iron_bronze" },
        { name: "シルバー・ゴールド", url: "roadmap.php#rank-silver_gold" },
        { name: "プラチナ・ダイヤ〜マスター", url: "roadmap.php#rank-platinum_diamond" }
      ],
      guide: "自分のランクに合わせた目標・立ち回りの考え方・練習メニューのロードマップです。"
    },
    5: {
      title: "5. 格ゲー用語集 - QUICK JUMP",
      links: [
        { name: "システム用語", url: "glossary.php#system" },
        { name: "基礎用語", url: "glossary.php#basic" },
        { name: "立ち回り用語", url: "glossary.php#neutral" }
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

<!-- 10. 共通フッター読み込み -->
<?php include 'includes/footer.php'; ?>