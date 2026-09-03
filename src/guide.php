<?php
// HTMLエスケープ用ヘルパー（他ファイルの h() と衝突しないようガード）
if (!function_exists('h')) {
    function h($str): string {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * デバイスタイプ（gamepad/lever/leverless/keyboard）に対応する絵文字アイコンを返す。
 */
if (!function_exists('deviceTypeIcon')) {
    function deviceTypeIcon(string $type): string {
        $map = [
            'gamepad'   => '🎮',
            'lever'     => '🕹️',
            'leverless' => '🔲',
            'keyboard'  => '⌨️',
        ];
        return $map[$type] ?? '🎮';
    }
}

// devices.json の読み込み（glossary.php / training.php と同じBOM対策込みのパターン）
$devicesJsonPath  = __DIR__ . '/data/devices.json';
$devicesData      = [];
$devicesLoadError = null;

if (!file_exists($devicesJsonPath)) {
    $devicesLoadError = 'ファイルが見つかりません: ' . $devicesJsonPath;
} else {
    $jsonRaw = file_get_contents($devicesJsonPath);
    if ($jsonRaw === false) {
        $devicesLoadError = 'ファイルの読み込みに失敗しました。';
    } else {
        // UTF-8 BOMが先頭にあれば除去する
        $jsonRaw = preg_replace('/^\xEF\xBB\xBF/', '', $jsonRaw);
        $decoded = json_decode($jsonRaw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $devicesLoadError = 'JSONの形式が不正です: ' . json_last_error_msg();
        } elseif (!is_array($decoded)) {
            $devicesLoadError = 'JSONのルートが配列ではありません。';
        } else {
            $devicesData = $decoded;
        }
    }
}

// tutorials.json の読み込み（同上のパターン）
$tutorialsJsonPath  = __DIR__ . '/data/tutorials.json';
$tutorialsData      = [];
$tutorialsLoadError = null;

if (!file_exists($tutorialsJsonPath)) {
    $tutorialsLoadError = 'ファイルが見つかりません: ' . $tutorialsJsonPath;
} else {
    $jsonRaw = file_get_contents($tutorialsJsonPath);
    if ($jsonRaw === false) {
        $tutorialsLoadError = 'ファイルの読み込みに失敗しました。';
    } else {
        $jsonRaw = preg_replace('/^\xEF\xBB\xBF/', '', $jsonRaw);
        $decoded = json_decode($jsonRaw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $tutorialsLoadError = 'JSONの形式が不正です: ' . json_last_error_msg();
        } elseif (!is_array($decoded)) {
            $tutorialsLoadError = 'JSONのルートが配列ではありません。';
        } else {
            $tutorialsData = $decoded;
        }
    }
}

/**
 * tutorials.json のレベル英語名（beginner等）を日本語ラベルに変換する（jpが無い場合のフォールバック）。
 */
if (!function_exists('tutorialLevelLabel')) {
    function tutorialLevelLabel(array $level): string {
        if (!empty($level['jp'])) {
            return $level['jp'];
        }
        $map = ['beginner' => '初級', 'intermediate' => '中級', 'advanced' => '上級'];
        return $map[$level['en'] ?? ''] ?? ($level['en'] ?? '');
    }
}

/**
 * tutorials.json のレベルに対応する絵文字アイコンを返す。
 */
if (!function_exists('tutorialLevelIcon')) {
    function tutorialLevelIcon(string $levelEn): string {
        $map = ['beginner' => '🔰', 'intermediate' => '🥈', 'advanced' => '💎'];
        return $map[$levelEn] ?? '📘';
    }
}

/**
 * tutorials.json の画像スラッグ配列を、存在チェック付きの<img>タグ群としてレンダリングする。
 * 実ファイルが無い場合は "画像準備中" のプレースホルダーにフォールバックする。
 */
if (!function_exists('renderTutorialImages')) {
    function renderTutorialImages(array $imgs, string $altText): string {
        $html = '<div class="tutorial-media-row">';
        foreach ($imgs as $imgSlug) {
            $relPath = 'img/tutorials/' . $imgSlug . '.png';
            $fsPath  = __DIR__ . '/img/tutorials/' . $imgSlug . '.png';
            if (file_exists($fsPath)) {
                $html .= '<div class="tutorial-media-item"><img src="' . h($relPath) . '" alt="' . h($altText) . '"></div>';
            } else {
                $html .= '<div class="tutorial-media-item"><div class="tutorial-media-placeholder">🖼️ 画像準備中</div></div>';
            }
        }
        $html .= '</div>';
        return $html;
    }
}

/**
 * tutorials.json の動画スラッグ配列を、存在チェック付きの<video>タグ群としてレンダリングする。
 * 実ファイルが無い場合は "動画準備中" のプレースホルダーにフォールバックする。
 */
if (!function_exists('renderTutorialVideos')) {
    function renderTutorialVideos(array $videos, string $levelEn, ?string $operation): string {
        $html = '<div class="tutorial-media-row">';
        foreach ($videos as $videoSlug) {
            $relPath = 'videos/tutorials/' . $levelEn . '/' . $videoSlug . '.mp4';
            $fsPath  = __DIR__ . '/videos/tutorials/' . $levelEn . '/' . $videoSlug . '.mp4';
            if (file_exists($fsPath)) {
                $loopAttrs = ($operation === 'play') ? 'autoplay loop muted playsinline' : 'controls';
                $html .= '<div class="tutorial-media-item"><video ' . $loopAttrs . '><source src="' . h($relPath) . '" type="video/mp4">お使いのブラウザは動画タグをサポートしていません。</video></div>';
            } else {
                $html .= '<div class="tutorial-media-item"><div class="tutorial-media-placeholder">🎬 動画準備中</div></div>';
            }
        }
        $html .= '</div>';
        return $html;
    }
}

/**
 * tutorials.json の1件の subcontent（head/text/imgs）をレンダリングする。
 * text はサイト側で意図的に <strong>/<span class="weak"> 等のHTMLタグを含めて保存しているため、
 * エスケープせずそのまま出力する（ユーザー投稿ではなく、サイト側で用意した固定コンテンツのため）。
 */
if (!function_exists('renderTutorialSubcontent')) {
    function renderTutorialSubcontent(array $subcontent, string $levelEn): string {
        $html = '<div class="tutorial-subcontent">';
        if (!empty($subcontent['head'])) {
            $html .= '<div class="tutorial-subcontent-head">' . h($subcontent['head']) . '</div>';
        }
        if (!empty($subcontent['text'])) {
            $html .= '<p>' . $subcontent['text'] . '</p>';
        }
        if (!empty($subcontent['imgs'])) {
            $html .= renderTutorialImages($subcontent['imgs'], $subcontent['head'] ?? '');
        }
        $html .= '</div>';
        return $html;
    }
}

/**
 * tutorials.json の1件の content（subtitle/text/videos/operation/subcontents）をレンダリングする。
 */
if (!function_exists('renderTutorialContent')) {
    function renderTutorialContent(array $content, string $levelEn): string {
        $html = '<div style="margin-bottom:16px;">';
        if (!empty($content['subtitle'])) {
            $html .= '<h4 style="font-size:0.9rem; color:var(--text-primary); margin:0 0 6px;">' . h($content['subtitle']) . '</h4>';
        }
        if (!empty($content['text'])) {
            $html .= '<p>' . $content['text'] . '</p>';
        }
        if (!empty($content['videos'])) {
            $html .= renderTutorialVideos($content['videos'], $levelEn, $content['operation'] ?? null);
        }
        if (!empty($content['subcontents'])) {
            foreach ($content['subcontents'] as $subcontent) {
                $html .= renderTutorialSubcontent($subcontent, $levelEn);
            }
        }
        $html .= '</div>';
        return $html;
    }
}

// ページごとの設定値
$page_title   = "1. 初期設定・環境 | SF6 PORTAL";
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

    <!-- ============================================================ -->
    <!-- ① 操作タイプ比較（クラシック / モダン） -->
    <!-- ============================================================ -->
    <div id="operation-types">
      <h2 class="glossary-block-title" style="font-size:1.1rem;">⚙️ 操作タイプを選ぶ</h2>
      <p class="hero-header-desc" style="margin-bottom:14px;">
        SF6には複数の操作方式があります。まずは「クラシック」と「モダン」の違いを比較して、自分に合う方を選びましょう。
      </p>

      <div class="comparison-container">
        <!-- クラシック -->
        <div class="comp-box con">
          <div class="comp-title">🅲 クラシック操作</div>
          <p style="font-size:0.85rem; color:var(--text-secondary); margin-bottom:10px;">
            従来のシリーズ同様、レバー（方向キー）とボタンの組み合わせでコマンドを入力する操作方式。
          </p>

          <div class="comp-sub-title frame-plus">✓ メリット</div>
          <ul class="comp-list">
            <li>自由にボタン配置をカスタマイズできる</li>
            <li>技の性能をフルに引き出せる（威力補正を受けない）</li>
            <li>プロや上級者の大半が使用しており、対戦の表現の幅が広い</li>
          </ul>

          <div class="comp-sub-title frame-minus">✕ デメリット</div>
          <ul class="comp-list">
            <li>コマンド入力の習得に時間がかかる</li>
            <li>とっさの入力ミスが起きやすく、初心者には難易度が高い</li>
          </ul>

          <div class="comp-recommend">
            💡 <strong>おすすめな人：</strong>格闘ゲーム経験者や、コマンド入力にじっくり慣れて表現の幅を広げたい人
          </div>
        </div>

        <!-- モダン -->
        <div class="comp-box pro">
          <div class="comp-title">🅼 モダン操作</div>
          <p style="font-size:0.85rem; color:var(--text-secondary); margin-bottom:10px;">
            方向キーと1ボタンの組み合わせで必殺技やコンボが出せる、初心者向けに設計された操作方式。
          </p>

          <div class="comp-sub-title frame-plus">✓ メリット</div>
          <ul class="comp-list">
            <li>コマンド入力を覚えなくても必殺技・コンボが出せる</li>
            <li>初めての格闘ゲームでもすぐに対戦を楽しめる</li>
            <li>プロプレイヤーの使用者もいる、実戦的な操作方式</li>
          </ul>

          <div class="comp-sub-title frame-minus">✕ デメリット</div>
          <ul class="comp-list">
            <li>簡易コマンドを使用すると、技の威力に補正がかかる（例：ダメージ80%）</li>
          </ul>

          <div class="comp-recommend">
            💡 <strong>おすすめな人：</strong>初めて格闘ゲームに触れる人や、コマンド入力より読み合いをすぐ楽しみたい人
          </div>
        </div>
      </div>

      <div class="alert-box">
        <div class="alert-title">💡 補足：ダイナミック操作について</div>
        <div class="alert-content">
          上記2種類のほかに、オフライン対戦専用の「ダイナミック操作」もあります。方向キー＋1ボタンで自動的に技を選んでくれる方式で、友人・家族とのカジュアルな対戦や、初めて触るキャラクターの動きを試すのに向いています（オンライン対戦では使用できません）。
        </div>
      </div>
    </div>

    <!-- ============================================================ -->
    <!-- ② 推奨ゲーム内設定（キーコンフィグ / グラフィック / サウンド） -->
    <!-- ============================================================ -->
    <div id="settings" style="margin-top:28px;">
      <h2 class="glossary-block-title" style="font-size:1.1rem;">⚡ 最初に変えておきたいゲーム内設定</h2>
      <p class="hero-header-desc" style="margin-bottom:14px;">
        対戦を快適にするために、最初に確認しておきたい設定のポイントです。
      </p>

      <!-- キーコンフィグ -->
      <h3 style="font-size:0.95rem; color:var(--text-primary); margin:16px 0 8px;">🎮 キーコンフィグ・操作設定</h3>
      <div class="card-grid">
        <div class="grid-card">
          <div class="grid-card-title"><span>🤝</span> 投げ・ドライブインパクトの同時押し割り当て</div>
          <div class="grid-card-desc">
            パッド・アケコンともに L1/R1（またはそれに相当するボタン）へ「投げ」や「ドライブインパクト」を割り当てるのが一般的です。とっさの同時押しがしやすくなります。
          </div>
        </div>
        <div class="grid-card">
          <div class="grid-card-title"><span>👆</span> 離し入力設定：基本OFF</div>
          <div class="grid-card-desc">
            ONにするとコマンドの正確性が上がりますが、意図せず技が出にくくなる場合もあります。まずはOFFのまま慣れて、必要に応じてONを試しましょう。
          </div>
        </div>
      </div>

      <!-- グラフィック設定 -->
      <h3 style="font-size:0.95rem; color:var(--text-primary); margin:20px 0 8px;">🖥️ グラフィック設定（入力遅延軽減など）</h3>
      <div class="card-grid">
        <div class="grid-card">
          <div class="grid-card-title">
            <span>⚡</span> 入力遅延の軽減
            <span class="combo-badge" style="margin-left:6px; font-size:0.7rem;">推奨：ON</span>
          </div>
          <div class="grid-card-desc">
            ボタンを押してから技が出るまでのラグを減らせます。ただしPCスペックが不足していると画面が乱れることがあるため、その場合はOFFにしてください。
          </div>
        </div>
        <div class="grid-card">
          <div class="grid-card-title"><span>🎞️</span> MAXフレームレート：120</div>
          <div class="grid-card-desc">
            120FPS対応モニターであれば動きがより滑らかになります。対応していない、または動作が重い場合はPCスペックに合わせて下げてください。
          </div>
        </div>
      </div>

      <!-- サウンド設定 -->
      <h3 style="font-size:0.95rem; color:var(--text-primary); margin:20px 0 8px;">🔊 サウンド設定</h3>
      <div class="card-grid">
        <div class="grid-card">
          <div class="grid-card-title"><span>🔔</span> SA・ドライブ関連SEの音量を上げる</div>
          <div class="grid-card-desc">
            ドライブインパクトやSA（スーパーアーツ）の発生を「音」で察知しやすくなります。特にとっさの反応が求められる場面で有効です。
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================ -->
    <!-- ③ 推奨デバイス比較（ゲームパッド / アケコン / レバーレス / キーボード） -->
    <!-- ============================================================ -->
    <div id="devices" style="margin-top:28px;">
      <h2 class="glossary-block-title" style="font-size:1.1rem;">🎮 デバイス（操作機器）を選ぶ</h2>
      <p class="hero-header-desc" style="margin-bottom:14px;">
        SF6で使われる主なデバイスの特徴です。まずは手持ちのゲームパッドから始めて、慣れてきたら他のデバイスも検討するのがおすすめです。
      </p>

      <?php if ($devicesLoadError !== null): ?>
        <div class="alert-box warning">
          <div class="alert-title">⚠️ デバイスデータの読み込みエラー</div>
          <div class="alert-content"><?php echo h($devicesLoadError); ?></div>
        </div>
      <?php elseif (empty($devicesData)): ?>
        <div class="alert-box">
          <div class="alert-title">💡 Notice</div>
          <div class="alert-content">現在、デバイスデータは登録されていません。</div>
        </div>
      <?php else: ?>

        <?php foreach ($devicesData as $device): ?>
          <?php
            $type      = $device['type'] ?? '';
            $title     = $device['title'] ?? '(名称未設定)';
            $merits    = $device['merit'] ?? [];
            $demerits  = $device['demerit'] ?? [];
            $recommend = $device['recommend'] ?? [];
            $controllers = $device['controller'] ?? [];
          ?>
          <div style="margin-top:20px;">
            <h3 style="font-size:0.95rem; color:var(--text-primary); margin:0 0 10px;">
              <?php echo h(deviceTypeIcon($type)); ?> <?php echo h($title); ?>
            </h3>

            <div class="comp-box pro" style="max-width:none;">
              <?php if (!empty($merits)): ?>
                <div class="comp-sub-title frame-plus">✓ メリット</div>
                <ul class="comp-list">
                  <?php foreach ($merits as $point): ?>
                    <li><?php echo h($point); ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>

              <?php if (!empty($demerits)): ?>
                <div class="comp-sub-title frame-minus">✕ デメリット</div>
                <ul class="comp-list">
                  <?php foreach ($demerits as $point): ?>
                    <li><?php echo h($point); ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>

              <?php foreach ($recommend as $tip): ?>
                <div class="comp-recommend">💡 <?php echo h($tip); ?></div>
              <?php endforeach; ?>
            </div>

            <!-- おすすめモデル（製品カード） -->
            <?php if (!empty($controllers)): ?>
              <div class="device-product-grid">
                <?php foreach ($controllers as $product): ?>
                  <?php
                    $productName = $product['name'] ?? '(製品名未設定)';
                    $imgSlug     = $product['img'] ?? '';

                    // サムネイル画像（例: img/device/hori-pad.jpg）。存在しない場合はプレースホルダー表示にフォールバック。
                    $thumbRelPath = 'img/device/' . $imgSlug . '.jpg';
                    $thumbFsPath  = __DIR__ . '/img/device/' . $imgSlug . '.jpg';
                    $hasThumbnail = ($imgSlug !== '' && file_exists($thumbFsPath));
                  ?>
                  <div class="device-product-card">
                    <?php if ($hasThumbnail): ?>
                      <img class="device-product-thumb" src="<?php echo h($thumbRelPath); ?>" alt="<?php echo h($productName); ?>">
                    <?php else: ?>
                      <div class="device-product-thumb-placeholder"><?php echo h(deviceTypeIcon($type)); ?></div>
                    <?php endif; ?>

                    <div class="device-product-name"><?php echo h($productName); ?></div>

                    <?php if (!empty($product['pluspoint'])): ?>
                      <ul class="device-product-points frame-plus">
                        <?php foreach ($product['pluspoint'] as $point): ?>
                          <li><?php echo h($point); ?></li>
                        <?php endforeach; ?>
                      </ul>
                    <?php endif; ?>

                    <?php if (!empty($product['minuspoint'])): ?>
                      <ul class="device-product-points frame-minus">
                        <?php foreach ($product['minuspoint'] as $point): ?>
                          <li><?php echo h($point); ?></li>
                        <?php endforeach; ?>
                      </ul>
                    <?php endif; ?>

                    <div class="device-product-links">
                      <?php if (!empty($product['amazon'])): ?>
                        <a href="<?php echo h($product['amazon']); ?>" target="_blank" rel="noopener noreferrer nofollow sponsored"
                           class="next-step-btn" style="padding:5px 12px; font-size:0.75rem;">Amazon</a>
                      <?php endif; ?>
                      <?php if (!empty($product['rakuten'])): ?>
                        <a href="<?php echo h($product['rakuten']); ?>" target="_blank" rel="noopener noreferrer nofollow sponsored"
                           class="next-step-btn" style="padding:5px 12px; font-size:0.75rem;">楽天市場</a>
                      <?php endif; ?>
                      <?php if (!empty($product['official'])): ?>
                        <a href="<?php echo h($product['official']); ?>" target="_blank" rel="noopener noreferrer"
                           class="next-step-btn" style="padding:5px 12px; font-size:0.75rem;">公式サイト</a>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>

      <?php endif; ?>

      <div class="alert-box" style="margin-top:20px;">
        <div class="alert-title">💡 まずは今持っているデバイスで</div>
        <div class="alert-content">
          最初から高価なデバイスを揃える必要はありません。まずは手持ちのコントローラー（パッド）で操作タイプやゲームの基本に慣れ、必要性を感じてからアケコン・レバーレスへの移行を検討するのがおすすめです。
        </div>
      </div>
    </div>

    <!-- ============================================================ -->
    <!-- ④ SF6 基本システム・チュートリアル解説 -->
    <!-- ============================================================ -->
    <div id="tutorials" style="margin-top:28px;">
      <h2 class="glossary-block-title" style="font-size:1.1rem;">📘 SF6 基本システム・チュートリアル解説</h2>
      <p class="hero-header-desc" style="margin-bottom:14px;">
        ゲーム内チュートリアルに対応した、レベル別の基本システム解説です。まずは初級から順番に確認しましょう。
      </p>

      <?php if ($tutorialsLoadError !== null): ?>
        <div class="alert-box warning">
          <div class="alert-title">⚠️ チュートリアルデータの読み込みエラー</div>
          <div class="alert-content"><?php echo h($tutorialsLoadError); ?></div>
        </div>
      <?php elseif (empty($tutorialsData)): ?>
        <div class="alert-box">
          <div class="alert-title">💡 Notice</div>
          <div class="alert-content">現在、チュートリアルデータは登録されていません。</div>
        </div>
      <?php else: ?>

        <!-- レベル別タブ切り替え（character.php と同じ tab-navigation / tab-content の仕組みを再利用） -->
        <div class="tab-navigation">
          <?php foreach ($tutorialsData as $i => $level): ?>
            <button class="tab-btn<?php echo $i === 0 ? ' active' : ''; ?>" type="button"
                    data-tab-target="tutorial-tab-<?php echo h($level['en'] ?? $i); ?>">
              <?php echo h(tutorialLevelIcon($level['en'] ?? '')); ?> <?php echo h(tutorialLevelLabel($level)); ?>
            </button>
          <?php endforeach; ?>
        </div>

        <?php foreach ($tutorialsData as $i => $level): ?>
          <?php $levelEn = $level['en'] ?? (string)$i; ?>
          <div class="tab-content<?php echo $i === 0 ? ' active' : ''; ?>" id="tutorial-tab-<?php echo h($levelEn); ?>">

            <?php if (!empty($level['text'])): ?>
              <div class="alert-box">
                <div class="alert-title"><?php echo h(tutorialLevelIcon($levelEn)); ?> <?php echo h(tutorialLevelLabel($level)); ?>の進め方</div>
                <div class="alert-content"><?php echo h($level['text']); ?></div>
              </div>
            <?php endif; ?>

            <?php if (!empty($level['item'])): ?>
              <div style="margin-top:14px;">
                <?php foreach ($level['item'] as $item): ?>
                  <details class="accordion-item">
                    <summary class="accordion-title">
                      📝 <?php echo h($item['title'] ?? ''); ?>
                    </summary>
                    <div class="accordion-content">
                      <?php foreach (($item['contents'] ?? []) as $content): ?>
                        <?php echo renderTutorialContent($content, $levelEn); ?>
                      <?php endforeach; ?>
                    </div>
                  </details>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

          </div>
        <?php endforeach; ?>

      <?php endif; ?>
    </div>

    <!-- 注意事項ボックス -->
    <div class="alert-box">
      <div class="alert-title">💡 通信環境のチェック</div>
      <div class="alert-content">
        快適な対戦環境のために、可能な限り<strong>有線LAN接続</strong>でのプレイを強く推奨します。
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

<!-- チュートリアルセクション：レベル別タブ切り替えJS（character.php と同じ仕組み） -->
<script>
  (function () {
    var tabButtons  = document.querySelectorAll('#tutorials .tab-btn[data-tab-target]');
    var tabContents = document.querySelectorAll('#tutorials .tab-content');

    tabButtons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var targetId = btn.dataset.tabTarget;

        tabButtons.forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');

        tabContents.forEach(function (content) {
          content.classList.toggle('active', content.id === targetId);
        });
      });
    });
  })();
</script>

<!-- 4. フッター読み込み -->
<?php include 'includes/footer.php'; ?>