<?php
// ページごとの設定値
$page_title = "5. 格ゲー用語集 | SF6 PORTAL";
$current_page = "glossary";

include 'includes/head.php';
?>

<?php include 'includes/header.php'; ?>

<div class="main-wrapper">
  
  <?php include 'includes/sidebar.php'; ?>

  <main class="content-area">
    
    <div class="page-header">
      <div class="breadcrumb">ホーム &gt; 用語集</div>
      <h1 class="page-title">5. 格ゲー用語・システム辞書</h1>
      <p class="page-desc">ストリートファイター6のシステムや、格ゲー界隈で使われる用語の解説。</p>
    </div>

    <!-- 検索バー -->
    <div class="filter-bar">
      <input type="text" class="filter-input" placeholder="用語名で検索 (例: キャンセル, 確反)...">
    </div>

    <!-- アコーディオン形式の用語一覧 -->
    <details class="accordion-item">
      <summary class="accordion-title">❓ キャンセル（Cancel）</summary>
      <div class="accordion-content">
        通常技の硬直モーションを途中でキャンセルし、必殺技やドライブラッシュなどの次の行動へ即座に移行させるテクニック。
      </div>
    </details>

    <details class="accordion-item">
      <summary class="accordion-title">❓ 確定反撃（確反 / Punish）</summary>
      <div class="accordion-content">
        相手の技をガードした際、相手の硬直時間に対してこちらの技の発生が間に合い、確実に攻撃をヒットさせられる状況。
      </div>
    </details>

    <details class="accordion-item">
      <summary class="accordion-title">❓ パニッシュカウンター（パニカン）</summary>
      <div class="accordion-content">
        相手の技の隙（硬直）や失敗した無敵技に対して攻撃を当てた際に発生する特殊なカウンターヒット。ダメージやフレーム性能が強化される。
      </div>
    </details>

  </main>
</div>

<?php include 'includes/footer.php'; ?>