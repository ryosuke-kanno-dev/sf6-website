<?php
// ページごとの設定値
$page_title = "2. トレモ練習メニュー | SF6 PORTAL";
$current_page = "training";

include 'includes/head.php';
?>

<?php include 'includes/header.php'; ?>

<div class="main-wrapper">
  
  <?php include 'includes/sidebar.php'; ?>

  <main class="content-area">
    
    <div class="page-header">
      <div class="breadcrumb">ホーム &gt; トレモ練習</div>
      <h1 class="page-title">2. トレモ練習メニュー</h1>
      <p class="page-desc">レベルに応じたトレーニングモードの活用法と、効率的な練習メニュー。</p>
    </div>

    <!-- 検索・フィルターバー -->
    <div class="filter-bar">
      <input type="text" class="filter-input" placeholder="練習項目を検索...">
      <div class="filter-btn-group">
        <button class="filter-btn active" type="button">すべて</button>
        <button class="filter-btn" type="button">初級</button>
        <button class="filter-btn" type="button">中級</button>
        <button class="filter-btn" type="button">上級</button>
      </div>
    </div>

    <!-- 練習項目カード例 -->
    <div class="card-grid">
      <div class="grid-card">
        <div class="grid-card-title"><span>🎯</span> 対空昇竜の自動反復</div>
        <div class="grid-card-desc">相手のジャンプ攻撃に対して安定して対空技を出すためのダミー設定方法。</div>
      </div>
      <div class="grid-card">
        <div class="grid-card-title"><span>🛡️</span> ドライブインパクト返し</div>
        <div class="grid-card-desc">インパクト音を聞いてから正確に返し返すための反応速度トレーニング。</div>
      </div>
    </div>

    <!-- ポイント解説 -->
    <div class="alert-box">
      <div class="alert-title">💡 効率的な練習のコツ</div>
      <div class="alert-content">
        長時間の練習よりも、毎日15分〜30分の「トレモルーティン」を継続する方が定着率が高まります。
      </div>
    </div>

  </main>
</div>

<?php include 'includes/footer.php'; ?>