<?php
// ページごとの設定値
$page_title = "1. 初期設定・環境 | SF6 PORTAL";
$current_page = "guide";

// 1. Head部分の読み込み
include 'includes/head.php';
?>

<!-- 2. ヘッダー読み込み -->
<?php include 'includes/header.php'; ?>

<!-- 3. メインレイアウト領域 -->
<div class="main-wrapper">
  
  <!-- 左サイドバー読み込み -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- 右メインコンテンツ領域 -->
  <main class="content-area">
    
    <div class="page-header">
      <div class="breadcrumb">ホーム &gt; 初期設定</div>
      <h1 class="page-title">1. スタートガイド・初期設定</h1>
      <p class="page-desc">プレイ環境の準備、推奨デバイス、ゲーム内のおすすめ設定を解説します。</p>
    </div>

    <!-- ヒーローヘッダー -->
    <div class="hero-header">
      <h1 class="hero-header-title">🔰 まず最初に整えるべきプレイ環境</h1>
      <p class="hero-header-desc">対戦でストレスなく上達するために、最初に行っておきたい設定をまとめました。</p>
    </div>

    <!-- メリット・デメリット対比（コントローラー選定など） -->
    <div class="comparison-container">
      <div class="comp-box pro">
        <div class="comp-title">Pad（パッド）のメリット</div>
        <ul class="comp-list">
          <li>・手軽に始められ、導入コストが低い</li>
          <li>・移動や移動中のコマンド入力が直感的</li>
        </ul>
      </div>
      <div class="comp-box con">
        <div class="comp-title">レバーレスのメリット</div>
        <ul class="comp-list">
          <li>・コマンド入力の正確性と速度が圧倒的</li>
          <li>・慣れるまでに少し練習が必要</li>
        </ul>
      </div>
    </div>

    <!-- 注意事項ボックス -->
    <div class="alert-box">
      <div class="alert-title">💡 通信環境のチェック</div>
      <div class="alert-content">
        快適な対戦環境のために、可能な限り**有線LAN接続**でのプレイを強く推奨します。
      </div>
    </div>

    <!-- ネクストステップ導線 -->
    <div class="next-step-card">
      <div class="next-step-info">
        <div class="next-step-label">NEXT STEP</div>
        <div class="next-step-title">環境が整ったら、トレモでの効率的な練習方法を確認しましょう</div>
      </div>
      <a href="training.php" class="next-step-btn">2. トレモ練習ガイドへ →</a>
    </div>

  </main>
</div>

<!-- 4. フッター読み込み -->
<?php include 'includes/footer.php'; ?>