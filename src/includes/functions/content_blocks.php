<?php
/**
 * glossary.json / training_menus.json 共通の「コンテンツブロック」形式
 * （type: text / list / table）を1件HTMLに変換する。
 * 未知の type は空文字を返す（表示崩れを防ぐ。仕様書にも同様の指示あり）。
 *
 * このファイルは glossary.php / training.php の両方から require_once される。
 */
if (!function_exists('h')) {
    function h($str): string {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('renderContentBlock')) {
    function renderContentBlock(array $block): string {
        $type = $block['type'] ?? '';

        switch ($type) {
            case 'text':
                return '<p class="glossary-block-text">' . nl2br(h($block['body'] ?? '')) . '</p>';

            case 'list':
                $html = '';
                if (!empty($block['title'])) {
                    $html .= '<div class="glossary-block-title">' . h($block['title']) . '</div>';
                }
                $html .= '<ul class="glossary-block-list">';
                foreach (($block['items'] ?? []) as $li) {
                    $html .= '<li>' . h($li) . '</li>';
                }
                $html .= '</ul>';
                return $html;

            case 'table':
                $html = '';
                if (!empty($block['title'])) {
                    $html .= '<div class="glossary-block-title">' . h($block['title']) . '</div>';
                }
                $html .= '<div class="table-container"><table class="data-table"><thead><tr>';
                foreach (($block['headers'] ?? []) as $header) {
                    $html .= '<th>' . h($header) . '</th>';
                }
                $html .= '</tr></thead><tbody>';
                foreach (($block['rows'] ?? []) as $row) {
                    $html .= '<tr>';
                    foreach ($row as $cell) {
                        $html .= '<td>' . h($cell) . '</td>';
                    }
                    $html .= '</tr>';
                }
                $html .= '</tbody></table></div>';
                return $html;

            default:
                return '';
        }
    }
}

/**
 * 後方互換用のエイリアス（glossary.php の旧関数名からの呼び出しに対応）。
 */
if (!function_exists('renderGlossaryContentBlock')) {
    function renderGlossaryContentBlock(array $block): string {
        return renderContentBlock($block);
    }
}
