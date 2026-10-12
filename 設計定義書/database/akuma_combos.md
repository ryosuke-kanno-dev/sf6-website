# akuma_combos テーブル定義書 (Street Fighter 6 Strategy Site)

このテーブルは、豪鬼特設ページ（`akuma.php`）専用の実戦コンボを管理します。
「実戦コンボ集」「リーサル判断」の両セクションに使用されます。
`combos` テーブルとは別の、豪鬼専用の独立テーブルです（`character_id` を持ちません）。

> 2026-10 更新：始動技・位置・ヒット状況を追加し、リーサル判断を「ダメージ ÷ 相手キャラの体力」による自動判定に変更。
> `hp_threshold_min/max`（体力%の手入力）は旧仕様のため任意・参考用になり、公開ページの判定では使用しない。

---

## 1. カラム定義一覧

| カラム名 | 型 (SQL型) | 説明 | 入力ルール / 備考 | 具体例 |
| :--- | :--- | :--- | :--- | :--- |
| **id** | `INT` | 固有ID | PRIMARY KEY / AUTO_INCREMENT | `1`, `2`... |
| **purpose** | `ENUM` | 表示先 | NOT NULL / DEFAULT `practical`。`practical`＝実戦コンボ集とリーサル判断の両方に表示 / `lethal`＝リーサル判断にだけ表示 | `practical` |
| **hp_threshold_min** | `TINYINT UNSIGNED` | 体力%下限（旧仕様） | NULL許可。任意・参考用。両方入力か両方空欄（0〜100、下限≦上限） | `0` |
| **hp_threshold_max** | `TINYINT UNSIGNED` | 体力%上限（旧仕様） | NULL許可。同上 | `25` |
| **title** | `VARCHAR(100)` | コンボ名 | NOT NULL | `画面端リーサル` |
| **start_move_slug** | `VARCHAR(100)` | 始動技の move_slug | NULL許可。豪鬼の `frame.move_slug`。管理画面で技DBから選択（`start_move_variant` とセット） | `jodan_...` |
| **start_move_variant** | `VARCHAR(50)` | 始動技の move_variant | NULL許可。`frame.move_variant`（強弱・OD等）。未指定は NULL | `M` |
| **position** | `ENUM` | 位置 | NOT NULL / DEFAULT `Any`。`Any`（位置問わず）/ `Center`（中央）/ `OppCorner`（相手が端）/ `SelfCorner`（自分が端） | `OppCorner` |
| **hit_type** | `ENUM` | ヒット状況 | NOT NULL / DEFAULT `Normal`。`Normal`（通常ヒット）/ `Counter`（カウンター）/ `Punish`（パニカン・確反）。`combos.hit_type` と同じ語彙 | `Punish` |
| **recipe** | `TEXT` | レシピ | NOT NULL。`combos.recipe` と同じコマンド表記ルール | `236P > 214P[J] > 236236P` |
| **damage** | `INT` | ダメージ値 | NOT NULL / DEFAULT `0`。**この行の position / hit_type で出した値**を入力する。リーサル判断で「残り体力」と比較する | `4200` |
| **drive_gauge** | `INT` | 消費ドライブ（本数） | NOT NULL / DEFAULT `0`。0〜6（管理画面でバリデーション） | `2` |
| **sa_gauge** | `INT` | 消費SA（段階） | **NOT NULL** / DEFAULT `0`。0〜3（管理画面でバリデーション）。NULLを渡すとエラーになるため、未入力時は`0` | `3` |
| **difficulty** | `ENUM` | 難易度 | NOT NULL / DEFAULT `Intermediate`。`Beginner`/`Intermediate`/`Advanced` | `Advanced` |
| **memo** | `TEXT` | 補足メモ | NULL許可 | `画面端限定。安定度は中程度。` |
| **sort_order** | `INT` | 表示順 | NOT NULL / DEFAULT `0`。10刻み。管理画面では空欄なら「その purpose の最大値+10」を自動採番 | `10` |
| **created_at** | `TIMESTAMP` | 作成日時 | DEFAULT CURRENT_TIMESTAMP | - |
| **updated_at** | `TIMESTAMP` | 更新日時 | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

インデックス：`idx_akuma_combos_start (start_move_slug, start_move_variant)` / `idx_akuma_combos_filter (position, hit_type)`
マイグレーション：`database_migrations/2026-10_akuma_combos_attributes.sql`

---

## 2. 運用ルール

- 始動技は豪鬼の技DB（`frame` テーブル）に登録されている全ての技から選べる。キーは `move_slug|move_variant`。
  技DB側で slug / variant を変更・削除すると、既存コンボの始動技は「技DBに無し」扱いになり、絞り込みの選択肢に出なくなる。
- **位置**：「位置問わず」のコンボは、どの位置で絞り込んでも表示される。「中央」「相手が端」「自分が端」は選んだ位置と一致するものだけ（＋位置問わず）。
- **実戦コンボ集**（`purpose='practical'` のみ）：始動技・位置・ヒット状況・使えるドライブ（N本まで）・使えるSA（N段階まで）で絞り込み、登録順／ダメージ順／ドライブ消費順で並べ替え。
- **リーサル判断**（`practical` + `lethal` の全コンボ）：相手キャラ（`characters.vitality`）と残り体力%から「残り体力（実数）」を出し、`damage >= 残り体力` のコンボをリーサルとして判定する。
  同じ絞り込み条件（始動技・位置・ヒット状況・ゲージ）の中での最大ダメージと、リーサル可否・不足ダメージをサマリー表示する。
  確反からのリーサル確認は、始動技に確反で使う技、ヒット状況に「パニカン・確反」などを指定して使う。
- 表示ダメージは登録条件での値であり、実戦ではコンボ補正等で前後する。
- 管理画面：`admin/akuma-combos-edit.php`
