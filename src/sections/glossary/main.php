<?php
/**
 * 用語集メインコンテンツ
 * 50音グループ別に用語カードをループ出力する。
 * content配列の type（text / list / table）に応じてHTMLを分岐生成。
 * 変数 $glossaryGrouped（行ラベル => 用語配列）がglossary.phpで定義済みであることを前提とする。
 */
?>

<?php if (empty($glossaryGrouped)): ?>
    <!-- データなし -->
    <div class="p-glossary__empty">
        <span class="p-glossary__empty-icon">📭</span>
        <p class="p-glossary__empty-text">用語データを読み込めませんでした。</p>
        <p class="p-glossary__empty-sub">data/glossary.json を確認してください。</p>
    </div>

<?php else: ?>

    <?php foreach ($glossaryGrouped as $rowLabel => $terms): ?>

        <!-- 行グループ（例: あ行） -->
        <div
            class="p-glossary__group"
            id="row-<?php echo h($rowLabel); ?>"
            data-row="<?php echo h($rowLabel); ?>"
        >
            <div class="p-glossary__group-header">
                <h2 class="p-glossary__group-title"><?php echo h($rowLabel); ?></h2>
                <span class="p-glossary__group-count"><?php echo count($terms); ?>語</span>
            </div>

            <!-- 用語カードグリッド -->
            <div class="p-glossary__grid" id="grid-<?php echo h($rowLabel); ?>">

                <?php foreach ($terms as $entry): ?>

                    <article
                        class="c-card p-glossary__card"
                        id="<?php echo h($entry['id']); ?>"
                        data-term="<?php echo h($entry['term']); ?>"
                        data-kana="<?php echo h($entry['kana']); ?>"
                        data-category="<?php echo h($entry['category']); ?>"
                    >
                        <!-- カードヘッダー -->
                        <div class="p-glossary__card-header">
                            <div class="p-glossary__term-group">
                                <h3 class="p-glossary__term"><?php echo h($entry['term']); ?></h3>
                                <p class="p-glossary__kana"><?php echo h($entry['kana']); ?></p>
                            </div>
                            <span class="p-glossary__category p-glossary__category--<?php echo h($entry['category']); ?>">
                                <?php echo h($entry['category']); ?>
                            </span>
                        </div>

                        <!-- 説明文 -->
                        <p class="p-glossary__description"><?php echo h($entry['description']); ?></p>

                        <!-- 詳細コンテンツ（contentが存在する場合のみ） -->
                        <?php if (!empty($entry['content'])): ?>
                            <details>
                                <summary class="p-glossary__detail-toggle">
                                    📖 詳しく見る
                                </summary>
                                <div class="p-glossary__detail">

                                    <?php foreach ($entry['content'] as $block): ?>

                                        <div class="p-glossary__content-block">

                                            <?php switch ($block['type']):
                                                case 'text': ?>
                                                    <?php if (!empty($block['title'])): ?>
                                                        <p class="p-glossary__content-title"><?php echo h($block['title']); ?></p>
                                                    <?php endif; ?>
                                                    <p class="p-glossary__content-text"><?php echo h($block['body']); ?></p>

                                                <?php break;
                                                case 'list': ?>
                                                    <?php if (!empty($block['title'])): ?>
                                                        <p class="p-glossary__content-title"><?php echo h($block['title']); ?></p>
                                                    <?php endif; ?>
                                                    <ul class="p-glossary__content-list">
                                                        <?php foreach ($block['items'] as $item): ?>
                                                            <li><?php echo h($item); ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>

                                                <?php break;
                                                case 'table': ?>
                                                    <?php if (!empty($block['title'])): ?>
                                                        <p class="p-glossary__content-title"><?php echo h($block['title']); ?></p>
                                                    <?php endif; ?>
                                                    <div class="p-glossary__table-wrap">
                                                        <table class="p-glossary__table">
                                                            <?php if (!empty($block['headers'])): ?>
                                                                <thead>
                                                                    <tr>
                                                                        <?php foreach ($block['headers'] as $header): ?>
                                                                            <th><?php echo h($header); ?></th>
                                                                        <?php endforeach; ?>
                                                                    </tr>
                                                                </thead>
                                                            <?php endif; ?>
                                                            <tbody>
                                                                <?php foreach ($block['rows'] as $row): ?>
                                                                    <tr>
                                                                        <?php foreach ($row as $cell): ?>
                                                                            <td><?php echo h($cell); ?></td>
                                                                        <?php endforeach; ?>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                <?php break;
                                            endswitch; ?>

                                        </div><!-- /.p-glossary__content-block -->

                                    <?php endforeach; ?>

                                </div><!-- /.p-glossary__detail -->
                            </details>
                        <?php endif; ?>

                    </article><!-- /.p-glossary__card -->

                <?php endforeach; ?>

            </div><!-- /.p-glossary__grid -->
        </div><!-- /.p-glossary__group -->

    <?php endforeach; ?>

    <!-- 検索結果なし表示（JS制御） -->
    <div class="p-glossary__empty" id="glossaryEmpty" style="display: none;">
        <span class="p-glossary__empty-icon">🔍</span>
        <p class="p-glossary__empty-text">「<span id="glossaryEmptyKeyword"></span>」に該当する用語はありません。</p>
        <p class="p-glossary__empty-sub">別のキーワードで検索してみてください。</p>
    </div>

<?php endif; ?>
