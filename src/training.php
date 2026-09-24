<?php
require_once __DIR__ . '/includes/functions/content_blocks.php';

// ページごとの設定値
$page_title   = "2. トレモ練習メニュー | SF6 PORTAL";
$current_page = "training";

/**
 * BOM付きUTF-8 JSONファイルを安全に読み込むヘルパー。
 * 戻り値: [デコード結果(配列) or null, エラーメッセージ or null]
 */
if (!function_exists('loadJsonFile')) {
    function loadJsonFile(string $path): array {
        if (!file_exists($path)) {
            return [null, 'ファイルが見つかりません: ' . $path];
        }
        $raw = file_get_contents($path);
        if ($raw === false) {
            return [null, 'ファイルの読み込みに失敗しました: ' . $path];
        }
        $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw);
        $decoded = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [null, 'JSONの形式が不正です(' . basename($path) . '): ' . json_last_error_msg()];
        }
        return [$decoded, null];
    }
}

// 1. data/drills.json の読み込み（個々の練習メニュー）
$drills            = [];
$trainingLoadError = null;
[$drillsDecoded, $drillsErr] = loadJsonFile(__DIR__ . '/data/drills.json');
if ($drillsErr !== null) {
    $trainingLoadError = $drillsErr;
} elseif (!isset($drillsDecoded['drills']) || !is_array($drillsDecoded['drills'])) {
    $trainingLoadError = 'JSONの構造が不正です（"drills" 配列が見つかりません）。';
} else {
    $drills = $drillsDecoded['drills'];
}

// 2. data/training_guide.json の読み込み
//    構成： reference_intro / reference(タブ配列) / mindset / level_intro / level_guide(タブ配列)
$guideReferenceIntro = [];
$guideReferenceTabs  = [];
$guideMindset        = [];
$guideLevelIntro     = [];
$guideLevelTabs      = [];
$guideLoadError      = null;

[$guideDecoded, $guideErr] = loadJsonFile(__DIR__ . '/data/training_guide.json');
if ($guideErr !== null) {
    $guideLoadError = $guideErr;
} else {
    $guideReferenceIntro = $guideDecoded['reference_intro'] ?? [];
    $guideReferenceTabs  = $guideDecoded['reference']       ?? [];
    $guideMindset        = $guideDecoded['mindset']         ?? [];
    $guideLevelIntro     = $guideDecoded['level_intro']     ?? [];
    $guideLevelTabs      = $guideDecoded['level_guide']     ?? [];
}

// 3. related_systems を用語集の用語名に解決するため、glossary.json も軽量に読み込む
$glossaryTermsById = [];
[$glossaryDecoded, ] = loadJsonFile(__DIR__ . '/data/glossary.json');
if (isset($glossaryDecoded['terms']) && is_array($glossaryDecoded['terms'])) {
    foreach ($glossaryDecoded['terms'] as $term) {
        if (!empty($term['id'])) {
            $glossaryTermsById[$term['id']] = $term;
        }
    }
}

// 4. フィルター用の固定カテゴリ／難易度（データの出現順に依存させない。
//    新カテゴリを追加する場合はここも更新すること）
$categoryOptions   = ['反応系', '全対応系', '精度系', 'コンボ安定化系'];
$difficultyOptions = ['初級', '中級', '上級'];

/**
 * 反撃設定(reversal_setup)の1スロットを説明文に変換する。
 * action_category が「レコード」の場合は record_ref を records[].label から解決する。
 */
if (!function_exists('renderReversalSlot')) {
    function renderReversalSlot(array $slot, array $recordsByKey): string {
        $category = $slot['action_category'] ?? '';
        if ($category === 'レコード') {
            $ref = $slot['record_ref'] ?? '';
            $label = $recordsByKey[$ref]['label'] ?? ('記録' . $ref);
            $desc = 'レコード「' . h($label) . '」';
        } else {
            $desc = h($category) . '：' . h($slot['action'] ?? '');
        }
        $delay = $slot['delay'] ?? '';
        if ($delay !== '') {
            $desc .= '（ディレイ ' . h($delay) . '）';
        }
        return $desc;
    }
}

/**
 * ドリル1件の「設定手順」全体（ダミー設定／レコード設定／反撃設定／パラメーター設定）を
 * 実際のトレモ画面のメニュー構成に合わせてHTML化する。空の区分は表示しない。
 */
if (!function_exists('renderDrillSetup')) {
    function renderDrillSetup(array $drill): string {
        $html = '';

        // --- ダミー設定 ---
        if (!empty($drill['dummy_setting'])) {
            $html .= '<div class="drill-screen-group"><div class="drill-screen-header"><span class="drill-screen-header-icon">🎮</span>ダミー設定</div><div class="drill-screen-rows">';
            foreach ($drill['dummy_setting'] as $s) {
                $html .= '<div class="drill-screen-row"><span class="drill-screen-label">' . h($s['item'] ?? '') . '</span><span class="drill-screen-value">' . h($s['value'] ?? '') . '</span></div>';
            }
            $html .= '</div></div>';
        }

        // --- レコード設定 ---
        $recordsByKey = [];
        if (!empty($drill['records'])) {
            foreach ($drill['records'] as $r) {
                if (!empty($r['key'])) {
                    $recordsByKey[$r['key']] = $r;
                }
            }
            $html .= '<div class="drill-screen-group"><div class="drill-screen-header"><span class="drill-screen-header-icon">⏺</span>レコード設定</div><div class="drill-screen-rows">';
            foreach ($drill['records'] as $r) {
                $html .= '<div class="drill-screen-row"><span class="drill-screen-label">記録「' . h($r['key'] ?? '') . '」</span><span class="drill-screen-value">' . h($r['label'] ?? '') . '</span></div>';
            }
            $html .= '</div></div>';
        }

        // --- 反撃設定（tabごとにグルーピングし、スロット番号を振る） ---
        if (!empty($drill['reversal_setup'])) {
            foreach ($drill['reversal_setup'] as $group) {
                $tab = $group['tab'] ?? '';
                $html .= '<div class="drill-screen-group"><div class="drill-screen-header"><span class="drill-screen-header-icon">🛡</span>反撃設定<span class="drill-screen-tab">' . h($tab) . '</span></div><div class="drill-screen-rows">';
                $slotNum = 0;
                foreach (($group['slots'] ?? []) as $slot) {
                    $slotNum++;
                    $html .= '<div class="drill-screen-row"><span class="drill-screen-label">スロット' . $slotNum . '</span><span class="drill-screen-value">' . renderReversalSlot($slot, $recordsByKey) . '</span></div>';
                }
                $html .= '</div></div>';
            }
        }

        // --- パラメーター設定 ---
        if (!empty($drill['parameter_setting'])) {
            $html .= '<div class="drill-screen-group"><div class="drill-screen-header"><span class="drill-screen-header-icon">📊</span>パラメーター設定</div><div class="drill-screen-rows">';
            foreach ($drill['parameter_setting'] as $s) {
                $html .= '<div class="drill-screen-row"><span class="drill-screen-label">' . h($s['item'] ?? '') . '</span><span class="drill-screen-value">' . h($s['value'] ?? '') . '</span></div>';
            }
            $html .= '</div></div>';
        }

        return $html;
    }
}

/**
 * タブグループ（reference / level_guide）を tab-navigation + tab-content として描画する。
 * character.php / guide.php のタブ切り替え(.tab-navigation/.tab-btn/.tab-content)を再利用する。
 */
if (!function_exists('renderGuideTabGroup')) {
    function renderGuideTabGroup(string $groupKey, array $tabs): string {
        if (empty($tabs)) {
            return '';
        }
        $html = '<div class="tab-group" data-tab-group="' . h($groupKey) . '">';
        $html .= '<div class="tab-navigation">';
        foreach ($tabs as $i => $tab) {
            $tabId = $groupKey . '-tab-' . ($tab['id'] ?? $i);
            $icon  = $tab['icon'] ?? '';
            $label = $tab['label'] ?? '';
            $html .= '<button class="tab-btn' . ($i === 0 ? ' active' : '') . '" type="button" data-tab-target="' . h($tabId) . '">'
                   . h($icon) . ' ' . h($label) . '</button>';
        }
        $html .= '</div>';

        foreach ($tabs as $i => $tab) {
            $tabId = $groupKey . '-tab-' . ($tab['id'] ?? $i);
            $html .= '<div class="tab-content' . ($i === 0 ? ' active' : '') . '" id="' . h($tabId) . '">';
            if (!empty($tab['subtitle'])) {
                $html .= '<div class="tab-subtitle">' . h($tab['subtitle']) . '</div>';
            }
            foreach (($tab['guide'] ?? []) as $block) {
                $html .= renderContentBlock($block);
            }
            $html .= '</div>';
        }

        $html .= '</div>';
        return $html;
    }
}

// 5. Head部分の読み込み
include 'includes/head.php';
?>

<?php include 'includes/header.php'; ?>

<div class="main-wrapper">

  <?php include 'includes/training-sidebar.php'; ?>

  <main class="content-area">

    <div class="page-header">
      <div class="breadcrumb">ホーム &gt; トレモ練習</div>
      <h1 class="page-title">2. トレモ練習メニュー</h1>
      <p class="page-desc">レベルに応じたトレーニングモードの活用法と、効率的な反復練習メニュー。</p>
    </div>

    <?php if ($guideLoadError !== null): ?>
      <div class="alert-box warning" style="margin-bottom:24px;">
        <div class="alert-title">⚠️ 使い方ガイドの読み込みエラー</div>
        <div class="alert-content"><?php echo h($guideLoadError); ?></div>
      </div>
    <?php else: ?>

      <!-- ① 設定項目リファレンス（トレモ画面のメニュー順タブ） -->
      <section id="guide-reference" style="margin-bottom:28px;">
        <h2 class="glossary-block-title" style="font-size:1.1rem;">📘 設定項目リファレンス</h2>
        <?php foreach ($guideReferenceIntro as $block): ?>
          <?php echo renderContentBlock($block); ?>
        <?php endforeach; ?>
        <?php echo renderGuideTabGroup('ref', $guideReferenceTabs); ?>
      </section>

      <!-- 練習に取り組む際の心構え（タブ化しない、レベル非依存の内容） -->
      <?php if (!empty($guideMindset)): ?>
        <div class="alert-box" style="margin-bottom:28px;">
          <div class="alert-title">🧠 練習に取り組む際の心構え</div>
          <?php foreach ($guideMindset as $block): ?>
            <?php echo renderContentBlock($block); ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <!-- ② レベル別・上達の指針（MR帯タブ） -->
      <section id="guide-level" style="margin-bottom:28px;">
        <h2 class="glossary-block-title" style="font-size:1.1rem;">📈 レベル別・上達の指針</h2>
        <?php foreach ($guideLevelIntro as $block): ?>
          <?php echo renderContentBlock($block); ?>
        <?php endforeach; ?>
        <?php echo renderGuideTabGroup('level', $guideLevelTabs); ?>
      </section>

    <?php endif; ?>

    <!-- 検索・フィルターバー（サイドバー側と状態を同期） -->
    <div class="filter-bar" style="flex-direction:column; align-items:stretch; gap:10px;">
      <input type="text" id="trainingSearchInput" class="filter-input" placeholder="練習項目を検索...">

      <div>
        <div style="font-size:0.75rem; color:var(--text-secondary); margin-bottom:6px;">目的から探す</div>
        <div class="filter-btn-group" data-filter-group="category" data-filter-scope="main">
          <button class="filter-btn active" type="button" data-filter="all">すべて</button>
          <?php foreach ($categoryOptions as $cat): ?>
            <button class="filter-btn" type="button" data-filter="<?php echo h($cat); ?>"><?php echo h($cat); ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <div>
        <div style="font-size:0.75rem; color:var(--text-secondary); margin-bottom:6px;">難易度から探す</div>
        <div class="filter-btn-group" data-filter-group="difficulty" data-filter-scope="main">
          <button class="filter-btn active" type="button" data-filter="all">すべて</button>
          <?php foreach ($difficultyOptions as $diff): ?>
            <button class="filter-btn" type="button" data-filter="<?php echo h($diff); ?>"><?php echo h($diff); ?></button>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- ドリルカード（JSON連携） -->
    <?php if ($trainingLoadError !== null): ?>
      <div class="alert-box warning">
        <div class="alert-title">⚠️ 練習メニューの読み込みエラー</div>
        <div class="alert-content"><?php echo h($trainingLoadError); ?></div>
      </div>
    <?php elseif (empty($drills)): ?>
      <div class="alert-box">
        <div class="alert-title">💡 Notice</div>
        <div class="alert-content">現在、登録されている練習メニューがありません。</div>
      </div>
    <?php else: ?>
      <div class="drill-list" id="trainingCardGrid">
        <?php foreach ($drills as $item): ?>
          <?php
            $name          = $item['name'] ?? '(名称未設定)';
            $purpose       = $item['purpose'] ?? '';
            $category      = $item['category'] ?? '';
            $difficulty    = $item['difficulty'] ?? '';
            $recommendedOp = $item['recommended_opponent'] ?? '';
            $relatedSys    = $item['related_systems'] ?? [];
            $successCrit   = $item['success_criteria'] ?? '';
            $tips          = $item['tips'] ?? '';
            $setupHtml     = renderDrillSetup($item);
          ?>
          <div class="drill-card" id="<?php echo h($item['id'] ?? ''); ?>" data-category="<?php echo h($category); ?>" data-difficulty="<?php echo h($difficulty); ?>">

            <div class="drill-card-title">
              <span>🎯</span> <?php echo h($name); ?>
            </div>

            <div class="drill-card-badges">
              <?php if ($category !== ''): ?>
                <span class="combo-badge"><?php echo h($category); ?></span>
              <?php endif; ?>
              <?php if ($difficulty !== ''): ?>
                <span class="combo-badge">難易度：<?php echo h($difficulty); ?></span>
              <?php endif; ?>
              <?php if ($recommendedOp !== '' && $recommendedOp !== '任意'): ?>
                <span class="combo-badge">推奨対戦相手：<?php echo h($recommendedOp); ?></span>
              <?php endif; ?>
            </div>

            <?php if ($purpose !== ''): ?>
              <div class="grid-card-desc"><?php echo nl2br(h($purpose)); ?></div>
            <?php endif; ?>

            <?php if ($successCrit !== ''): ?>
              <div class="combo-note" style="margin-top:10px;">
                <strong class="training-block-heading">■習得の目安</strong><br>
                <?php echo nl2br(h($successCrit)); ?>
              </div>
            <?php endif; ?>

            <?php if ($tips !== ''): ?>
              <div class="combo-note" style="margin-top:10px;">
                <strong class="training-block-heading">■ワンポイント</strong><br>
                <?php echo nl2br(h($tips)); ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($relatedSys)): ?>
              <div class="related-terms-box">
                <span class="related-label">関連用語:</span>
                <?php foreach ($relatedSys as $relId): ?>
                  <?php if (isset($glossaryTermsById[$relId])): ?>
                    <a href="glossary.php#<?php echo h($relId); ?>"><?php echo h($glossaryTermsById[$relId]['term'] ?? $relId); ?></a>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <?php if ($setupHtml !== ''): ?>
              <details class="drill-setup-toggle">
                <summary class="drill-setup-summary">設定手順を見る（トレモ画面での設定）</summary>
                <div class="drill-setup-screen">
                  <?php echo $setupHtml; ?>
                </div>
              </details>
            <?php endif; ?>

          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- ポイント解説 -->
    <div class="alert-box" style="margin-top:20px;">
      <div class="alert-title">💡 効率的な練習のコツ</div>
      <div class="alert-content">
        長時間の練習よりも、毎日15分〜30分の「トレモルーティン」を継続する方が定着率が高まります。
      </div>
    </div>

  </main>
</div>

<!-- ①タブ切り替え（設定項目リファレンス／レベル別指針、両グループ共通の汎用JS） -->
<script>
  (function () {
    document.querySelectorAll('.tab-group').forEach(function (group) {
      var buttons  = group.querySelectorAll('.tab-btn[data-tab-target]');
      var contents = group.querySelectorAll('.tab-content');

      buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
          var targetId = btn.dataset.tabTarget;
          buttons.forEach(function (b) { b.classList.remove('active'); });
          btn.classList.add('active');
          contents.forEach(function (c) { c.classList.toggle('active', c.id === targetId); });
        });
      });
    });
  })();
</script>

<!-- ②検索・カテゴリ／難易度フィルター：コンテンツエリアとサイドバーの2箇所のUIを同一状態に同期する -->
<script>
  (function () {
    var searchInputs  = [document.getElementById('trainingSearchInput'), document.getElementById('trainingSearchInputSidebar')].filter(Boolean);
    var cards         = document.querySelectorAll('#trainingCardGrid .drill-card');
    var sidebarItems  = document.querySelectorAll('#trainingSidebarIndex .sidebar-index-item');
    var sidebarCats   = document.querySelectorAll('#trainingSidebarIndex .sidebar-index-category');
    var sidebarCount  = document.getElementById('trainingSidebarCount');
    var filterGroups  = document.querySelectorAll('[data-filter-group]');
    var currentFilters = { category: 'all', difficulty: 'all' };
    var currentKeyword = '';

    function matchesItem(el) {
      var matchesCategory   = currentFilters.category === 'all' || el.dataset.category === currentFilters.category;
      var matchesDifficulty = currentFilters.difficulty === 'all' || el.dataset.difficulty === currentFilters.difficulty;
      var matchesKeyword    = el.textContent.toLowerCase().includes(currentKeyword);
      return matchesCategory && matchesDifficulty && matchesKeyword;
    }

    function applyFilters() {
      var visibleCount = 0;

      cards.forEach(function (card) {
        card.style.display = matchesItem(card) ? '' : 'none';
      });

      sidebarItems.forEach(function (item) {
        var match = matchesItem(item);
        item.style.display = match ? '' : 'none';
        if (match) visibleCount++;
      });

      // カテゴリ見出しは、配下の項目が1件も表示されていなければ隠す
      sidebarCats.forEach(function (catEl) {
        var cat = catEl.dataset.category;
        var hasVisibleChild = Array.prototype.some.call(sidebarItems, function (item) {
          return item.dataset.category === cat && item.style.display !== 'none';
        });
        catEl.style.display = hasVisibleChild ? '' : 'none';
      });

      if (sidebarCount) {
        sidebarCount.textContent = visibleCount + '件を表示中';
      }
    }

    // 検索窓：メイン／サイドバーどちらに入力しても、もう片方にも反映して同期する
    searchInputs.forEach(function (input) {
      input.addEventListener('input', function () {
        currentKeyword = input.value.trim().toLowerCase();
        searchInputs.forEach(function (other) {
          if (other !== input) other.value = input.value;
        });
        applyFilters();
      });
    });

    // フィルターボタン：メイン／サイドバー両方の同名グループのactive状態を揃える
    filterGroups.forEach(function (group) {
      var groupName = group.dataset.filterGroup;
      group.querySelectorAll('.filter-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          currentFilters[groupName] = btn.dataset.filter;

          document.querySelectorAll('[data-filter-group="' + groupName + '"]').forEach(function (g) {
            g.querySelectorAll('.filter-btn').forEach(function (b) {
              b.classList.toggle('active', b.dataset.filter === btn.dataset.filter);
            });
          });

          applyFilters();
        });
      });
    });
  })();
</script>

<?php include 'includes/footer.php'; ?>
