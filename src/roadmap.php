<?php
// renderMarkdown() 等の共通関数を読み込む（このページ自体はDB接続不要なので db.php は読み込まない）
require_once 'includes/functions/db_helpers.php';

/**
 * JSONデコード結果が「配列(リスト)」ならそのまま返し、
 * {"menus": [...]} のようなラッパーオブジェクトだった場合は中の配列を探して返す。
 */
if (!function_exists('extractJsonList')) {
    function extractJsonList($decoded): array {
        if (!is_array($decoded)) {
            return [];
        }
        if (array_keys($decoded) === range(0, count($decoded) - 1)) {
            return $decoded;
        }
        foreach ($decoded as $value) {
            if (is_array($value) && array_keys($value) === range(0, count($value) - 1)) {
                return $value;
            }
        }
        return [];
    }
}

/**
 * ランク帯別の目標達成度に応じたフォールバックデータ。
 * data/roadmap.json が存在しない場合、この配列を使用する。
 * 各ランクは id / title / icon / color / theme / checklist / body(Markdown) / recommend_training(training_menus.jsonのID配列) を持つ。
 */
if (!function_exists('getDefaultRoadmapData')) {
    function getDefaultRoadmapData(): array {
        return [
            [
                'id'       => 'beginner',
                'title'    => 'ビギナー',
                'icon'     => '🔰',
                'color'    => '#94a3b8',
                'theme'    => '操作に慣れ、対戦の基本ルールを体に覚え込ませる段階',
                'checklist' => [
                    '自分の得意なキャラを1体決める',
                    '通常技・必殺技をコマンドで安定して出せるようになる',
                    '立ちガード／しゃがみガードを状況に応じて使い分けられる',
                    '投げ間合いで危険を感じたら投げ抜けを意識する',
                ],
                'body' => "この段階では**勝敗よりも「毎試合ひとつ新しいことを試す」意識**が大切です。\n負けが続いても、操作やコマンドに慣れることを最優先にしましょう。",
                'recommend_training' => ['anti-air-001', 'throw-escape-001'],
            ],
            [
                'id'       => 'iron_bronze',
                'title'    => 'アイアン・ブロンズ',
                'icon'     => '🥉',
                'color'    => '#b45309',
                'theme'    => 'まずは対空と確定反撃を覚える段階',
                'checklist' => [
                    'ジャンプ攻撃への対空技を1つ決めて安定させる',
                    '自分のキャラの確定反撃を2〜3個覚える',
                    '相手の起き上がりに技を重ねられるようになる',
                    'ラウンド開始直後の間合い・距離感を把握する',
                ],
                'body' => "「落とされたら悔しい」と感じる場面を1つずつ潰していく段階です。\n対空と確定反撃は**再現性の高い上達ポイント**なので、トレモで繰り返し練習しましょう。",
                'recommend_training' => [],
            ],
            [
                'id'       => 'silver_gold',
                'title'    => 'シルバー・ゴールド',
                'icon'     => '🥈',
                'color'    => '#64748b',
                'theme'    => '崩し・連携の圧を意識し、2択を仕掛けられるようになる段階',
                'checklist' => [
                    'ドライブラッシュを使った連携を1つ習得する',
                    '中段・下段の2択を仕掛けられるようになる',
                    '相手の起き上がりに攻めを継続できるようになる',
                    'ドライブゲージ管理（バーンアウト回避）を意識する',
                ],
                'body' => "受け身の対策が固まってきたら、次は**攻めの選択肢を増やす段階**です。\n1つの連携パターンに固執せず、状況に応じて崩し方を変える意識を持ちましょう。",
                'recommend_training' => ['oki-001'],
            ],
            [
                'id'       => 'platinum_diamond',
                'title'    => 'プラチナ・ダイヤ',
                'icon'     => '💎',
                'color'    => '#38bdf8',
                'theme'    => 'キャラ対策とフレーム管理で安定して勝てる試合を増やす段階',
                'checklist' => [
                    '対戦相手の主要キャラの確定反撃・弱点を把握する',
                    'フレームデータを見て有利／不利状況を判断できるようになる',
                    'ドライブゲージの読み合い（相手のバーンアウトを誘発する）を意識する',
                    '自分の負けパターンをリプレイで振り返る習慣をつける',
                ],
                'body' => "この段階からは**感覚だけでなく数値（フレーム）に基づいた判断**が重要になります。\n「なんとなく」で行動している部分を1つずつ言語化していきましょう。",
                'recommend_training' => [],
            ],
            [
                'id'       => 'master',
                'title'    => 'マスター',
                'icon'     => '👑',
                'color'    => '#f59e0b',
                'theme'    => '読み合いの精度を高め、対策を継続的にアップデートする段階',
                'checklist' => [
                    '対戦データやリプレイを継続的に見直し、対策をアップデートする',
                    '相手のクセ・傾向を読み、択の選択を変化させる',
                    '連敗時のメンタルの立て直し方を持っておく',
                    '大会・オンライン対戦会などで場数を踏む',
                ],
                'body' => "ここまで来ると、伸びしろは**「どれだけ対策をアップデートし続けられるか」**にかかっています。\n現状維持ではなく、常に新しい情報・対策を取り入れる姿勢を持ちましょう。",
                'recommend_training' => [],
            ],
        ];
    }
}

// ページごとの設定値
$page_title   = "4. 上達ロードマップ | SF6 PORTAL";
$current_page = "roadmap";

// 1. data/roadmap.json の読み込み（存在しない場合はフォールバックデータを使用）
$roadmapJsonPath  = __DIR__ . '/data/roadmap.json';
$roadmapData      = [];
$roadmapLoadError = null;
$usingFallbackData = false;

if (!file_exists($roadmapJsonPath)) {
    $roadmapData = getDefaultRoadmapData();
    $usingFallbackData = true;
} else {
    $jsonRaw = file_get_contents($roadmapJsonPath);
    if ($jsonRaw === false) {
        $roadmapLoadError = 'ファイルの読み込みに失敗しました。';
        $roadmapData = getDefaultRoadmapData();
        $usingFallbackData = true;
    } else {
        $jsonRaw = preg_replace('/^\xEF\xBB\xBF/', '', $jsonRaw);
        $decoded = json_decode($jsonRaw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $roadmapLoadError = 'JSONの形式が不正です: ' . json_last_error_msg();
            $roadmapData = getDefaultRoadmapData();
            $usingFallbackData = true;
        } else {
            $roadmapData = extractJsonList($decoded);
            if (empty($roadmapData)) {
                $roadmapData = getDefaultRoadmapData();
                $usingFallbackData = true;
            }
        }
    }
}

// 2. data/training_menus.json の読み込み（「おすすめ練習メニュー」の紐付けに使用）
$trainingJsonPath = __DIR__ . '/data/training_menus.json';
$trainingMenusById = [];

if (file_exists($trainingJsonPath)) {
    $jsonRaw = file_get_contents($trainingJsonPath);
    if ($jsonRaw !== false) {
        $jsonRaw = preg_replace('/^\xEF\xBB\xBF/', '', $jsonRaw);
        $decoded = json_decode($jsonRaw, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $menus = extractJsonList($decoded);
            foreach ($menus as $menu) {
                if (!empty($menu['id'])) {
                    $trainingMenusById[$menu['id']] = $menu;
                }
            }
        }
    }
}

// 3. Head部分の読み込み
include 'includes/head.php';
?>

<!-- 4. ヘッダー読み込み -->
<?php include 'includes/header.php'; ?>

<!-- 5. メインレイアウト領域 -->
<div class="main-wrapper">

  <!-- 左サイドバー読み込み -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- 右メインコンテンツ領域 -->
  <main class="content-area">

    <div class="page-header">
      <div class="breadcrumb">ホーム &gt; 上達ロードマップ</div>
      <h1 class="page-title">4. 上達ロードマップ</h1>
      <p class="page-desc">自分のランク帯を選び、次のステージへの最短ルートを確認しよう。</p>
    </div>

    <!-- ヒーローヘッダー -->
    <div class="hero-header">
      <h1 class="hero-header-title">🗺️ ランク帯別ロードマップ</h1>
      <p class="hero-header-desc">考え方・課題・練習メニューをセットで確認できます。まずは今の自分のランク帯から見てみましょう。</p>
    </div>

    <?php if ($roadmapLoadError !== null): ?>
      <div class="alert-box warning">
        <div class="alert-title">⚠️ ロードマップデータの読み込みエラー</div>
        <div class="alert-content">
          <?php echo h($roadmapLoadError); ?>（フォールバックデータで表示しています）
        </div>
      </div>
    <?php elseif ($usingFallbackData): ?>
      <div class="alert-box">
        <div class="alert-title">💡 Notice</div>
        <div class="alert-content">
          <code>data/roadmap.json</code> が未配置のため、暫定のランク別ガイドを表示しています。
        </div>
      </div>
    <?php endif; ?>

    <!-- ランク帯クイックナビ -->
    <div class="filter-bar">
      <?php foreach ($roadmapData as $rank): ?>
        <a href="#rank-<?php echo h($rank['id']); ?>" class="filter-btn" style="text-decoration:none;">
          <?php echo h($rank['icon'] ?? ''); ?> <?php echo h($rank['title'] ?? ''); ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- ランク帯別カード一覧 -->
    <div style="margin-top:20px;">
      <?php foreach ($roadmapData as $rank): ?>
        <?php
          $rankColor = $rank['color'] ?? 'var(--accent-color)';
        ?>
        <div class="combo-card roadmap-rank-card" id="rank-<?php echo h($rank['id']); ?>"
             style="margin-bottom:16px; border-left-color:<?php echo h($rankColor); ?>;">

          <!-- ランクバッジ + テーマ -->
          <div class="combo-header">
            <span class="combo-title">
              <span class="rank-badge" style="background-color:<?php echo h($rankColor); ?>;">
                <?php echo h($rank['icon'] ?? ''); ?> <?php echo h($rank['title'] ?? ''); ?>
              </span>
            </span>
          </div>
          <p class="hero-header-desc" style="margin:8px 0 4px;">
            <?php echo h($rank['theme'] ?? ''); ?>
          </p>

          <details class="accordion-item" style="margin-top:10px;">
            <summary class="accordion-title">📋 このランクでやること・詳細を見る</summary>
            <div class="accordion-content">

              <!-- マスターすべき要素・課題リスト -->
              <?php if (!empty($rank['checklist'])): ?>
                <div class="glossary-block-title">✅ マスターすべき要素・課題</div>
                <ul class="roadmap-checklist">
                  <?php foreach ($rank['checklist'] as $checkItem): ?>
                    <li><span class="roadmap-check-icon">✅</span> <span><?php echo h($checkItem); ?></span></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>

              <!-- Markdown本文 -->
              <?php if (!empty($rank['body'])): ?>
                <div class="glossary-block-title">📖 この段階の考え方</div>
                <div><?php echo renderMarkdown($rank['body']); ?></div>
              <?php endif; ?>

              <!-- おすすめ練習メニュー -->
              <?php
                $recommendIds = $rank['recommend_training'] ?? [];
                $recommendMenus = [];
                foreach ($recommendIds as $trainingId) {
                    if (isset($trainingMenusById[$trainingId])) {
                        $recommendMenus[] = $trainingMenusById[$trainingId];
                    }
                }
              ?>
              <?php if (!empty($recommendMenus)): ?>
                <div class="glossary-block-title">💪 おすすめ練習メニュー</div>
                <div class="card-grid">
                  <?php foreach ($recommendMenus as $menu): ?>
                    <a href="training.php#<?php echo h($menu['id']); ?>" class="grid-card" style="text-decoration:none; color:inherit;">
                      <div class="grid-card-title"><span>🎯</span> <?php echo h($menu['title'] ?? ''); ?></div>
                      <div class="grid-card-desc">
                        <?php echo h($menu['category_label'] ?? ''); ?>
                        <?php if (!empty($menu['duration'])): ?>
                          ・<?php echo (int)$menu['duration']; ?>分
                        <?php endif; ?>
                      </div>
                      <?php if (!empty($menu['objective'])): ?>
                        <div class="grid-card-desc" style="margin-top:6px;"><?php echo h($menu['objective']); ?></div>
                      <?php endif; ?>
                      <p style="margin-top:10px; color:var(--accent-color); font-size:0.85rem; font-weight:bold;">練習を始める →</p>
                    </a>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <div class="alert-box" style="margin-top:10px;">
                  <div class="alert-content">
                    このランク帯向けの個別メニューは準備中です。まずは
                    <a href="training.php" class="next-step-btn" style="padding:4px 12px; font-size:0.8rem;">トレモ練習メニュー一覧</a>
                    から気になるものを試してみましょう。
                  </div>
                </div>
              <?php endif; ?>

            </div>
          </details>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- ネクストステップ導線 -->
    <div class="next-step-card">
      <div class="next-step-info">
        <div class="next-step-label">NEXT STEP</div>
        <div class="next-step-title">課題が見えてきたら、キャラ攻略ページで実践的なコンボ・確定反撃を確認しよう</div>
      </div>
      <a href="character.php" class="next-step-btn">3. キャラ攻略へ →</a>
    </div>

  </main>
</div>

<!-- 6. フッター読み込み -->
<?php include 'includes/footer.php'; ?>