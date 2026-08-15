<?php
// ページごとの設定値
$page_title = "3. ルーク (LUKE) 攻略まとめ | SF6 PORTAL";
$current_page = "character";
$selected_char = "ルーク (LUKE)";
$selected_char_icon = "L";

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
      <div class="breadcrumb">ホーム &gt; キャラ攻略 &gt; <?php echo $selected_char; ?></div>
      <h1 class="page-title">3. <?php echo $selected_char; ?> 攻略まとめ</h1>
      <p class="page-desc">ルークのコンボ・確定反撃・フレームデータの統合ガイド</p>
    </div>

    <!-- タブナビゲーション -->
    <div class="tab-navigation">
      <button class="tab-btn active">【自キャラ用】コンボ集</button>
      <button class="tab-btn">【対策用】キャラ対策・確反</button>
      <button class="tab-btn">【データ】フレーム表</button>
    </div>

    <!-- ヒーローヘッダー -->
    <div class="hero-header">
      <h1 class="hero-header-title">🔰 <?php echo $selected_char; ?> 概要</h1>
      <p class="hero-header-desc">スタンダードで強力な牽制技と、火力の高いコンボを併せ持つ万能キャラクター。</p>
    </div>

    <!-- コンボカード例 -->
    <div class="combo-card" id="combo">
      <div class="combo-header">
        <span class="combo-title">中央ノーゲージ基本コンボ</span>
        <span class="combo-badge">難易度：★☆☆</span>
      </div>
      <div class="combo-command">しゃがみ弱P > 立ち弱P > 弱レイジングブル</div>
      <p class="combo-note">※ヒット確認が容易な基本コンボ。ガード時は技を出し切らずに途中で止めましょう。</p>
    </div>

    <!-- データテーブル -->
    <div class="table-container" id="anti-air">
      <table class="data-table">
        <thead>
          <tr>
            <th>技名</th>
            <th>発生</th>
            <th>ガード時</th>
            <th>確定反撃</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>立ち中P</td>
            <td>6F</td>
            <td>-2F</td>
            <td>なし</td>
          </tr>
          <tr>
            <td>強レイジングブル</td>
            <td>18F</td>
            <td>-12F</td>
            <td>しゃがみ中P等</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- ポイント注記 -->
    <div class="alert-box">
      <div class="alert-title">💡 Point</div>
      <div class="alert-content">
        モダン操作の場合、簡易コマンドで使用すると威力が80%に補正されます。状況に応じてコマンド入力と使い分けるのがおすすめです。
      </div>
    </div>

  </main>
</div>

<!-- 4. フッター読み込み -->
<?php include 'includes/footer.php'; ?>