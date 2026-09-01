<?php
// 1. DB接続・共通関数の読み込み
require_once 'includes/db.php';
require_once 'includes/functions/db_helpers.php';
require_once 'includes/functions/command_converter.php';

/**
 * combos.title が未設定の場合に、position / hit_type / hit_position / special_state
 * のENUM値から簡易的な状況ラベルを組み立てるフォールバック関数。
 */
if (!function_exists('buildComboSituationLabel')) {
    function buildComboSituationLabel(array $combo): string {
        if (!empty($combo['title'])) {
            return $combo['title'];
        }

        $positionMap = ['Any' => '位置問わず', 'Mid' => '中央', 'Corner' => '画面端'];
        $hitTypeMap  = ['Normal' => '通常ヒット', 'Counter' => 'カウンターヒット', 'Punish' => 'パニカン'];
        $hitPosMap   = ['Ground' => '地上ヒット', 'Air' => '空中ヒット'];
        $stateMap    = ['WallSplat' => '壁バウンド', 'Stun' => 'スタン中'];

        $parts = [];
        $parts[] = $positionMap[$combo['position']] ?? $combo['position'];
        if (($combo['hit_type'] ?? 'Normal') !== 'Normal') {
            $parts[] = $hitTypeMap[$combo['hit_type']] ?? $combo['hit_type'];
        }
        if (($combo['hit_position'] ?? 'Ground') !== 'Ground') {
            $parts[] = $hitPosMap[$combo['hit_position']] ?? $combo['hit_position'];
        }
        if (($combo['special_state'] ?? 'None') !== 'None') {
            $parts[] = $stateMap[$combo['special_state']] ?? $combo['special_state'];
        }

        return implode(' / ', $parts);
    }
}

/**
 * combos.difficulty（Beginner/Intermediate/Advanced）を日本語ラベルに変換する。
 */
if (!function_exists('translateDifficulty')) {
    function translateDifficulty(string $difficulty): string {
        $map = [
            'Beginner'     => '初級',
            'Intermediate' => '中級',
            'Advanced'     => '上級',
        ];
        return $map[$difficulty] ?? $difficulty;
    }
}

// 2. URLパラメータからキャラクタースラッグを取得（未指定・不正時は 'luke' をデフォルトに）
$char_slug = isset($_GET['char']) ? trim($_GET['char']) : 'luke';

$character = getCharacterBySlug($pdo, $char_slug);

// 指定スラッグが存在しない場合は 'luke' にフォールバック
if (!$character) {
    $character = getCharacterBySlug($pdo, 'luke');
}

// それでも取得できない場合（DBが空 等）は致命的エラーとして停止
if (!$character) {
    die('キャラクターデータが見つかりませんでした。DBの初期データを確認してください。');
}

// 3. 取得したキャラクター情報をページ変数へバインド
$selected_char      = $character['name_jp'] . ' (' . $character['name_en'] . ')';
$selected_char_icon = mb_strtoupper(mb_substr($character['name_en'], 0, 1, 'UTF-8'), 'UTF-8');
$page_title          = "3. {$selected_char} 攻略まとめ | SF6 PORTAL";
$current_page        = "character";

// 4. 関連データの取得
$combos        = getCombosByCharId($pdo, $character['id']);
$punish_frames = getPunishableFramesByCharId($pdo, $character['id']);

// 5. Head部分の読み込み
include 'includes/head.php';
?>

<!-- 6. ヘッダー読み込み -->
<?php include 'includes/header.php'; ?>

<!-- 7. メインレイアウト領域 -->
<div class="main-wrapper">

  <!-- 左サイドバー読み込み -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- 右メインコンテンツ領域 -->
  <main class="content-area">

    <div class="page-header">
      <div class="breadcrumb">ホーム &gt; キャラ攻略 &gt; <?php echo h($selected_char); ?></div>
      <h1 class="page-title">3. <?php echo h($selected_char); ?> 攻略まとめ</h1>
      <p class="page-desc"><?php echo h($character['name_jp']); ?>のコンボ・確定反撃・フレームデータの統合ガイド</p>
    </div>

    <!-- タブナビゲーション -->
    <div class="tab-navigation">
      <button class="tab-btn active">【自キャラ用】コンボ集</button>
      <button class="tab-btn">【対策用】キャラ対策・確反</button>
      <button class="tab-btn">【データ】フレーム表</button>
    </div>

    <!-- ヒーローヘッダー -->
    <div class="hero-header">
      <h1 class="hero-header-title">🔰 <?php echo h($selected_char); ?> 概要</h1>
      <p class="hero-header-desc">
        <?php echo h($character['profile_text'] ?? 'キャラクター紹介文は準備中です。'); ?>
      </p>
    </div>

    <!-- コンボ一覧（DB連携） -->
    <?php if (empty($combos)): ?>
      <div class="alert-box">
        <div class="alert-title">💡 Notice</div>
        <div class="alert-content">現在、<?php echo h($selected_char); ?> のコンボデータは登録されていません。</div>
      </div>
    <?php else: ?>
      <div id="combo">
        <?php foreach ($combos as $combo): ?>
          <div class="combo-card">
            <div class="combo-header">
              <span class="combo-title">
                <?php echo h(buildComboSituationLabel($combo)); ?>
                <?php if (!empty($combo['is_recommended'])): ?>
                  <span class="combo-badge" style="margin-left:6px;">おすすめ</span>
                <?php endif; ?>
              </span>
              <span class="combo-badge">難易度：<?php echo h(translateDifficulty($combo['difficulty'])); ?></span>
            </div>

            <div class="combo-command">
              <?php echo convertCommandToIcons($combo['recipe']); ?>
            </div>

            <div class="combo-meta" style="display:flex; gap:16px; margin-bottom:8px; font-size:0.85rem; color:var(--text-secondary);">
              <span>ダメージ：<strong style="color:var(--text-primary);"><?php echo (int)$combo['damage']; ?></strong></span>
              <span>消費ドライブ：<strong style="color:var(--text-primary);"><?php echo (int)$combo['drive_gauge']; ?></strong></span>
              <?php if (!empty($combo['sa_gauge'])): ?>
                <span>消費SA：<strong style="color:var(--text-primary);"><?php echo (int)$combo['sa_gauge']; ?></strong></span>
              <?php endif; ?>
            </div>

            <?php if (!empty($combo['memo'])): ?>
              <p class="combo-note">※<?php echo h($combo['memo']); ?></p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- 確定反撃・フレーム表（DB連携） -->
    <?php if (empty($punish_frames)): ?>
      <div class="alert-box">
        <div class="alert-title">💡 Notice</div>
        <div class="alert-content">現在、<?php echo h($selected_char); ?> の確定反撃データは登録されていません。</div>
      </div>
    <?php else: ?>
      <div class="table-container" id="anti-air">
        <table class="data-table">
          <thead>
            <tr>
              <th>技名</th>
              <th>発生</th>
              <th>持続</th>
              <th>ガード時</th>
              <th>確定反撃の目安</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($punish_frames as $frame): ?>
              <tr>
                <td><?php echo h($frame['move_name_jp']); ?></td>
                <td><?php echo h($frame['startup']); ?></td>
                <td><?php echo h($frame['active']); ?></td>
                <td><?php echo h($frame['guard_adv']); ?></td>
                <td>
                  <?php
                    // guard_adv は VARCHAR（'-3' 等の数値表記）。
                    // (int) キャストは先頭の数値部分のみを解釈するため 'D' や '—' は 0 として扱われる。
                    $guardAdv = (int)$frame['guard_adv'];
                    echo $guardAdv <= -4 ? '確定反撃あり' : '状況次第';
                  ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

    <!-- ポイント注記 -->
    <div class="alert-box">
      <div class="alert-title">💡 Point</div>
      <div class="alert-content">
        モダン操作の場合、簡易コマンドで使用すると威力が80%に補正されます。状況に応じてコマンド入力と使い分けるのがおすすめです。
      </div>
    </div>

  </main>
</div>

<!-- 8. フッター読み込み -->
<?php include 'includes/footer.php'; ?>