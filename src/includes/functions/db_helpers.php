<?php
/**
 * HTMLエスケープ用ヘルパー
 * command_converter.php 内で使用されているが未定義だったため、ここで定義する。
 * （既に他所で定義されている場合はそちらを優先し、二重定義エラーを防ぐ）
 */
if (!function_exists('h')) {
    function h($str): string {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }
}

// Parsedown（Markdownパーサー）の読み込み
require_once __DIR__ . '/Parsedown.php';

/**
 * DB内のMarkdown/プレーンテキスト（combos.memo, matchup.overview 等）を安全にHTML変換する共通関数。
 * - setSafeMode(true)   : 本文中の生HTMLタグをエスケープする（XSS対策）
 * - setBreaksEnabled(true): 空行を挟まない単一の改行（実改行コード）も <br> に変換する
 * - Parsedownに渡す前に、DBに実改行ではなく文字列としての "\n"（バックスラッシュ+n）が
 *   保存されているケースを実改行に正規化する（CSVインポート等でエスケープシーケンスが
 *   文字としてそのまま登録されてしまうケースへの対処）。
 */
if (!function_exists('renderMarkdown')) {
    function renderMarkdown(?string $text): string {
        if ($text === null || $text === '') {
            return '';
        }

        // 文字列としての "\r\n" / "\n" / "\r"（バックスラッシュ+文字）を実改行に正規化
        $normalized = str_replace(['\\r\\n', '\\n', '\\r'], "\n", $text);

        $parsedown = Parsedown::instance();
        $parsedown->setSafeMode(true);
        $parsedown->setBreaksEnabled(true);
        return $parsedown->text($normalized);
    }
}

/**
 * matchup_guides.category（ENUM）を日本語ラベルに変換する。
 * summary（クイックサマリー）は専用セクションで表示するため、通常のカテゴリループには含めない。
 * character.php（閲覧側）と admin/（編集側）の両方から参照する共通定義。
 */
/**
 * matchup_guides.condition_tag（自分の使用キャラの条件に応じた補足タグ）を日本語ラベルに変換する。
 * character.php（閲覧側）と admin/（編集側）の両方から参照する共通定義。
 */
if (!function_exists('matchupConditionTagLabel')) {
    function matchupConditionTagLabel(string $tag): string {
        $map = [
            'has_dp'         => '無敵対空技持ち限定',
            'is_grappler'    => 'コマンド投げキャラ限定',
            'has_projectile' => '飛び道具持ち限定',
            'has_install'    => '強化インストール技持ち限定',
        ];
        return $map[$tag] ?? $tag;
    }
}

if (!function_exists('matchupCategoryLabel')) {
    function matchupCategoryLabel(string $category): string {
        $map = [
            'summary'        => 'クイックサマリー',
            'neutral'        => '立ち回り（ニュートラル）',
            'pressure'       => '攻め・プレッシャー対策',
            'punish'         => '確定反撃',
            'reversal'       => '切り返し・リバーサル対策',
            'oki'            => '起き攻め・受け身',
            'char_condition' => 'キャラ特有システムへの対策',
            'gap'            => '技の隙・割り込み',
        ];
        return $map[$category] ?? $category;
    }
}

// アコーディオンで表示するカテゴリの並び順（summary はクイックサマリーとして別枠表示するため含めない）
if (!function_exists('matchupCategoryOrder')) {
    function matchupCategoryOrder(): array {
        return ['neutral', 'pressure', 'punish', 'reversal', 'oki', 'char_condition', 'gap'];
    }
}

// 1. 全キャラクター一覧の取得
function getAllCharacters($pdo) {
    $stmt = $pdo->query("SELECT * FROM characters ORDER BY sort_order ASC");
    return $stmt->fetchAll();
}

// 1b. 登録キャラクター数の取得（「全N キャラ」表記を実データから自動表示するため）
function getCharacterCount($pdo) {
    return (int)$pdo->query("SELECT COUNT(*) FROM characters")->fetchColumn();
}

// 2. スラッグ指定によるキャラクター単体情報の取得（例: 'luke', 'akuma'）
function getCharacterBySlug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT * FROM characters WHERE char_slug = ?");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

// 2b. ID指定によるキャラクター単体情報の取得（admin/ 側は slug ではなく id でリンクするため）
function getCharacterById($pdo, $char_id) {
    $stmt = $pdo->prepare("SELECT * FROM characters WHERE id = ?");
    $stmt->execute([$char_id]);
    return $stmt->fetch();
}

// 3. キャラクターID指定によるコンボ一覧の取得
function getCombosByCharId($pdo, $char_id) {
    $stmt = $pdo->prepare("SELECT * FROM combos WHERE character_id = ? ORDER BY id ASC");
    $stmt->execute([$char_id]);
    return $stmt->fetchAll();
}

/**
 * combos.title が未設定の場合に、position / hit_type / hit_position / special_state
 * のENUM値から簡易的な状況ラベルを組み立てるフォールバック関数。
 * character.php（閲覧側）と admin/（編集側）の両方から参照する共通定義。
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

/**
 * combos を「中央コンボ」「画面端コンボ」「パニカン・確定反撃始動」の3カテゴリに分類する。
 * 優先順位：hit_type='Punish' を最優先（確定反撃・パニカン始動という文脈が最も重要なため）、
 * 次に position='Corner'、それ以外は「中央コンボ」扱い。
 */
if (!function_exists('comboCategoryKey')) {
    function comboCategoryKey(array $combo): string {
        if (($combo['hit_type'] ?? '') === 'Punish') {
            return 'punish';
        }
        if (($combo['position'] ?? '') === 'Corner') {
            return 'corner';
        }
        return 'center';
    }
}

if (!function_exists('comboCategoryLabel')) {
    function comboCategoryLabel(string $key): string {
        $map = [
            'center' => '中央コンボ',
            'corner' => '画面端コンボ',
            'punish' => 'パニカン・確定反撃始動',
        ];
        return $map[$key] ?? $key;
    }
}

if (!function_exists('comboCategoryOrder')) {
    function comboCategoryOrder(): array {
        return ['center', 'corner', 'punish'];
    }
}

/**
 * combos.memo（コンボ注釈・補足コメント）表示用のレンダラー。
 * renderMarkdown()（Parsedown経由）でHTML変換した上で、先頭に「※」を付与する。
 * Parsedownの出力は <p>...</p> で始まるブロック要素のため、単純に文字列連結すると
 * "※" が段落の外側に浮いてしまう。そのため最初の <p> タグの直後に "※" を挿し込む。
 */
if (!function_exists('renderComboMemo')) {
    function renderComboMemo(string $memo): string {
        $html = renderMarkdown($memo);
        if (preg_match('/^<p>/', $html)) {
            $html = preg_replace('/^<p>/', '<p>※', $html, 1);
        } else {
            $html = '※' . $html;
        }
        return $html;
    }
}

// 3b. ID指定によるコンボ単体情報の取得（admin/ の編集フォーム用）
function getComboById($pdo, $combo_id) {
    $stmt = $pdo->prepare("SELECT * FROM combos WHERE id = ?");
    $stmt->execute([$combo_id]);
    return $stmt->fetch();
}

/**
 * frame.guard_adv / frame.hit_adv（VARCHAR、'-3' 等の数値表記や 'D'・'—' を含む）の
 * 先頭数値を判定し、プラスなら緑、マイナスなら赤のCSSクラス名を返す。
 * 'D'（ダウン）や '—'（該当なし）は先頭に数値が無いため、(int)キャストで 0 扱いとなり中立表示になる。
 * character.php（閲覧側）と admin/（編集側）の両方から参照する共通定義。
 */
if (!function_exists('frameAdvClass')) {
    function frameAdvClass(?string $value): string {
        if ($value === null || $value === '') {
            return '';
        }
        $num = (int)$value;
        if ($num > 0) {
            return 'frame-plus';
        }
        if ($num < 0) {
            return 'frame-minus';
        }
        return '';
    }
}

/**
 * frame.move_type（ENUM）を日本語ラベルに変換する。
 */
if (!function_exists('translateMoveType')) {
    function translateMoveType(string $moveType): string {
        $map = [
            'normal_moves'   => '通常技',
            'unique_attacks' => '特殊技',
            'special_moves'  => '必殺技',
            'super_arts'     => 'SA',
            'throws'         => '投げ技',
            'common_moves'   => '共通技',
        ];
        return $map[$moveType] ?? $moveType;
    }
}

// 3c. ID指定によるフレームデータ単体情報の取得（admin/ の編集フォーム用）
function getFrameById($pdo, $frame_id) {
    $stmt = $pdo->prepare("SELECT * FROM frame WHERE id = ?");
    $stmt->execute([$frame_id]);
    return $stmt->fetch();
}

// 4. ガード時硬直差がマイナスの技（確定反撃候補）を取得
//    frame.guard_adv は VARCHAR（'-3' 等の数値のほか 'D'（ダウン）や '—'（該当なし）を含む）のため、
//    CAST(... AS SIGNED) で数値変換した上で比較・ソートする。
//    'D' や '—' は数値変換すると 0 になるため、この条件では自然に除外される。
//    ASC ソートにより、マイナスが大きい（＝確定反撃が取りやすい）技から順に並ぶ（例: -12, -8, -3...）。
function getPunishableFramesByCharId($pdo, $char_id) {
    $stmt = $pdo->prepare(
        "SELECT * FROM frame
         WHERE character_id = ?
           AND CAST(guard_adv AS SIGNED) < 0
         ORDER BY CAST(guard_adv AS SIGNED) ASC"
    );
    $stmt->execute([$char_id]);
    return $stmt->fetchAll();
}

// 5. 指定キャラクターの全技フレームデータを取得（通常技・特殊技・必殺技・SA すべて）
//    frame.sort_order は「100きざみ推奨」の表示順カラム（frame テーブル定義書より）のため、これで整列する。
function getFrameDataByCharId($pdo, $char_id) {
    $stmt = $pdo->prepare("SELECT * FROM frame WHERE character_id = ? ORDER BY sort_order ASC");
    $stmt->execute([$char_id]);
    return $stmt->fetchAll();
}

// 6. キャラクターの対策総評（matchup）を取得（character_id につき1行）
function getMatchupByCharId($pdo, $char_id) {
    $stmt = $pdo->prepare("SELECT * FROM matchup WHERE character_id = ?");
    $stmt->execute([$char_id]);
    $result = $stmt->fetch();
    return $result !== false ? $result : null;
}

// 7. キャラクターに対する対策コラム一覧（matchup_guides）を取得
//    opponent_char_id ＝「このガイドが対策として書かれている対象キャラ」のID。
//    sort_order で整列（同カラム内での表示順もこれに従う想定）。
function getMatchupGuidesByCharId($pdo, $char_id) {
    $stmt = $pdo->prepare("SELECT * FROM matchup_guides WHERE opponent_char_id = ? ORDER BY sort_order ASC");
    $stmt->execute([$char_id]);
    return $stmt->fetchAll();
}

// 8. 上記2つ（総評＋コラム一覧）をまとめて取得するオーケストレーター関数
//    ['matchup' => 総評データ（無ければ null）, 'guides' => コラム配列]
function getMatchupGuideByCharId($pdo, $char_id) {
    return [
        'matchup' => getMatchupByCharId($pdo, $char_id),
        'guides'  => getMatchupGuidesByCharId($pdo, $char_id),
    ];
}