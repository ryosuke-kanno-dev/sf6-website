<?php
/**
 * 用語集ナビゲーション
 * 50音インデックスボタン + 検索窓
 * 変数 $glossaryRows（行ラベル => かな文字配列）がglossary.phpで定義済みであることを前提とする
 */
?>
<div class="p-guide__section" id="glossary-nav" style="padding-bottom: 0;">
    <!-- 検索ボックス -->
    <div class="p-glossary__search-wrap">
        <label for="glossarySearch" class="p-glossary__search-label">🔍 用語を検索</label>
        <div class="p-glossary__search-box">
            <span class="p-glossary__search-icon">🔍</span>
            <input
                type="search"
                id="glossarySearch"
                class="p-glossary__search-input"
                placeholder="例: ドライブ、frame、アーマー…"
                autocomplete="off"
                aria-label="用語を検索"
            >
        </div>
        <p class="p-glossary__search-count" id="glossarySearchCount" aria-live="polite"></p>
    </div>

    <!-- 50音インデックス -->
    <div class="p-glossary__index-wrap">
        <span class="p-glossary__index-label">📖 行から探す</span>
        <div class="p-glossary__index" role="group" aria-label="50音インデックス">
            <button
                type="button"
                class="p-glossary__index-btn p-glossary__index-btn--all is-active"
                data-row="all"
                id="indexBtn-all"
            >全て</button>

            <?php foreach ($glossaryRows as $label => $chars): ?>
                <?php
                    // この行に実際に用語があるかチェック
                    $hasTerms = isset($glossaryGrouped[$label]) && count($glossaryGrouped[$label]) > 0;
                ?>
                <button
                    type="button"
                    class="p-glossary__index-btn"
                    data-row="<?php echo h($label); ?>"
                    id="indexBtn-<?php echo h($label); ?>"
                    <?php echo !$hasTerms ? 'disabled' : ''; ?>
                    aria-label="<?php echo h($label); ?>を表示"
                ><?php echo h(mb_substr($label, 0, 1)); ?>行</button>
            <?php endforeach; ?>
        </div>
    </div>
</div>
