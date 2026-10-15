# フレームデータ表（共通部品）定義書

`character.php` の「【データ】フレーム表」タブと、`akuma.php` の「データ」タブで共用する表です。
列の見せ方は、公式サイトのフレームデータ表（技種別ごとの見出し行、発生・持続・硬直・ヒット/ガード硬直差・キャンセル・ダメージ・コンボ補正・
ドライブゲージ増減・SAゲージ増加・属性・備考）を参考にしている。データは自サイトの `frame` テーブルの値を使う。

- 部品：`includes/functions/frame_table.php`（`renderFrameTable($frames, $wrapId)` / `frameTableColumns()`）
- 操作：`js/frame-table.js`（表示項目・技種別・検索・プリセット・選択の保存）
- 見た目：`css/components/components.css` の `frame-table.css` ブロック

## 1. 表示項目（チェックボックスで切り替え。全項目をHTMLに出力し、CSSで隠す）

| グループ | key | 見出し | frame のカラム | 初期表示 |
| :--- | :--- | :--- | :--- | :--- |
| （固定） | - | 技名（補足 `move_variant` を併記。`L_charged` など内部ID形式の補足は出さない） | `move_name_jp` / `move_variant` | 常に表示 |
| 基本 | `command` | コマンド | `command` | ○ |
| 基本 | `startup` | 発生 | `startup` | ○ |
| 基本 | `active` | 持続 | `active` | ○ |
| 基本 | `recovery` | 硬直 | `recovery` | ○ |
| 基本 | `hit_adv` | ヒット（硬直差） | `hit_adv` | ○ |
| 基本 | `guard_adv` | ガード（硬直差） | `guard_adv` | ○ |
| 詳細 | `damage` | ダメージ | `damage` | ○ |
| 詳細 | `hit_level` | 属性 | `hit_level` | ○ |
| 詳細 | `cancel` | キャンセル | `cancel` | － |
| 詳細 | `combo_scaling` | コンボ補正 | `combo_scaling` | － |
| 詳細 | `misc` | 備考 | `miscellaneous` | － |
| ゲージ | `dg_increase_hit` | Dゲージ増加（ヒット） | `dg_increase_hit` | － |
| ゲージ | `dg_decrease_block` | Dゲージ減少（ガード） | `dg_decrease_block` | － |
| ゲージ | `dg_decrease_punish` | Dゲージ減少（パニカン） | `dg_decrease_punish` | － |
| ゲージ | `sa_gauge_increase` | SAゲージ増加 | `sa_gauge_increase` | － |

## 2. 操作

- **プリセット**：「基本のみ」（発生・持続・硬直・ヒット・ガード）／「標準」（初期表示）／「すべて」
- **技種別チップ**：通常技・特殊技・必殺技・SA・投げ技・共通技の表示/非表示（件数付き）。表は技種別ごとの見出し行で区切る。
- **コマンド表示の切り替え**：コマンド列は「アイコン」（初期）／「テンキー表記（文字）」を切り替え可能。選択は `localStorage`（キー `sf6ft_cmd_v1`）に保存。
  アイコンは `convertCommandToIcons()` の出力を使い、文字表記も同じセルに出力して外枠の `ft-cmd-text` クラスで切り替える。
  凡例「テンキー表記の見方」（折りたたみ）を表示。書き方のルールは `command_notation.md` を参照。
- **キーワード検索**：技名・英名・補足・コマンドを対象。全角/半角・大文字小文字・空白の違いを無視する。
- **選択の保存**：表示項目の選択は `localStorage`（キー `sf6ft_cols_v1`）に保存し、キャラ攻略ページと豪鬼ページの両方で共有する。保存できない環境でも動作する。
- 見出し行・技名の列は固定表示（スクロールしても見える）。表は縦横にスクロールできる。

## 3. 実装メモ

- 列の表示/非表示は、外枠 `.frame-table-wrap` に `ft-hide-{key}` クラスを付け外し、CSSで `[data-col="{key}"]` を隠す方式。
- 外枠の `id` はページごとに渡す（キャラ攻略ページ：`frame-data`、豪鬼ページ：`frame-table-akuma`）。
- 空欄のセルは空のまま表示する。ドライブ・SAゲージ増減（NOT NULL・初期値0）は保存値をそのまま表示する。
- 公式サイトのデータ・画像・文章は転載しない（レイアウトの参考のみ）。
