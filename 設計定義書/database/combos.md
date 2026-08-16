# combos テーブル定義書 (Street Fighter 6 Strategy Site)

このテーブルは、キャラクターごとのコンボレシピ、ダメージ、難易度、使用状況を管理します。
「キャラ別コンボ一覧」「状況別フィルタリング」「コンボ詳細表示」に使用されます。

---

## 1. カラム定義一覧

| カラム名 | 型 (SQL型) | 説明 | 入力ルール / 備考 | 具体例 |
| :--- | :--- | :--- | :--- | :--- |
| **id** | `INT` | 固有ID | **PRIMARY KEY / AUTO_INCREMENT**<br>システムが自動で振る連番。手動入力禁止。CSVにも含めないこと。 | `1`, `2`... |
| **character_id** | `INT` | キャラ紐付け | **NOT NULL / FOREIGN KEY**<br>`characters.id` と一致させる。 | `1`（リュウ） |
| **combo_slug** | `VARCHAR(100)` | 識別子 | **NOT NULL**<br>キャラクター内でユニーク（複合UNIQUE）。<br>命名規則に従いExcel関数で自動生成推奨。 | `mid-normal-1`, `corner-normal-wallsplat-1` |
| **combo_group** | `VARCHAR(100)` | コンボグループ | **NULL許可**。<br>同じ始動・状況から派生するバリエーションコンボを束ねる識別子。<br>単独コンボの場合はNULL。 | `4f-carry`, `jump`, `rush` |
| **page_type** | `ENUM` | ページ種別 | **NOT NULL** / DEFAULT `general`。取りうる値は固定：<br>`general`（初心者・サブキャラ向け汎用ページ）<br>`special`（キャラ特設ページ・上級者向け） | `general`, `special` |
| **title** | `VARCHAR(150)` | コンボ名 | NULL許可。コンボの呼び名。 | `汎用コンボ`, `4F始動 運び` |
| **recipe** | `TEXT` | レシピ | **NOT NULL**<br>独自のアイコン変換用記法で記述。<br>繰り返し回数が変わる技は `(xN-M)` 記法を使用。 | `2LP(x1-3) -> 214MK` |
| **difficulty** | `ENUM` | 難易度 | **NOT NULL**。取りうる値は固定：<br>`Beginner` / `Intermediate` / `Advanced` | `Beginner` |
| **position** | `ENUM` | 場所の状態 | **NOT NULL** / DEFAULT `Any`。取りうる値は固定：<br>`Any` / `Mid` / `Corner` | `Mid` |
| **hit_type** | `ENUM` | ヒットの強度 | **NOT NULL** / DEFAULT `Normal`。取りうる値は固定：<br>`Normal` / `Counter` / `Punish` | `Normal` |
| **hit_position** | `ENUM` | 相手の状態 | **NOT NULL** / DEFAULT `Ground`。取りうる値は固定：<br>`Ground` / `Air` | `Ground` |
| **special_state** | `ENUM` | 特殊やられ状態 | **NOT NULL** / DEFAULT `None`。取りうる値は固定：<br>`None` / `WallSplat` / `Stun` | `None` |
| **char_condition** | `VARCHAR(50)` | キャラ固有条件 | **NULL許可**。<br>固有能力が不要なコンボはNULL。<br>記法：`[識別子]_[条件]`。条件の記法は運用ルール③を参照。 | `drink_2+`, `fstock_1+`, `denjin_active` |
| **start_move** | `VARCHAR(50)` | 始動技の識別子 | **NULL許可**。<br>フレームデータテーブルの `move_slug` と対応させる。<br>ラッシュ・インパクト始動の場合は `[NR]` `[CR]` `[IM]` を使用。 | `2LP`, `j.HK`, `[NR]`, `[IM]` |
| **end_move** | `VARCHAR(50)` | 締め技の識別子 | **NULL許可**。<br>フレームデータテーブルの `move_slug` と対応させる。<br>起き攻め・SA継続・連携データとの結合キーとして使用。 | `214HP`, `623HP`, `SA3` |
| **damage** | `INT` | ダメージ値 | NULL許可。数値で入力。<br>`(xN-M)` 記法使用時は**最大ヒット数時のダメージ**を入力。 | `1200`, `3500` |
| **drive_gauge** | `TINYINT` | 消費Dゲージ | **NOT NULL** / DEFAULT `0`。<br>有効範囲：`0`〜`6`。CHECK制約あり。 | `0`, `2` |
| **sa_gauge** | `TINYINT` | 消費SAゲージ | **NOT NULL** / DEFAULT `0`。<br>有効範囲：`0`〜`3`。CHECK制約あり。 | `0`, `1`, `3` |
| **is_recommended** | `TINYINT(1)` | おすすめフラグ | **NOT NULL** / DEFAULT `0`。<br>`1` = おすすめ表示あり、`0` = 通常。 | `0`, `1` |
| **memo** | `TEXT` | 解説・補足 | NULL許可。**Markdown形式**。スペース2つ + `\n` で改行。 | `画面端では使用不可。  \n安定して入れるには...` |
| **sort_order** | `INT` | 表示順 | **NOT NULL**。省略不可・必ず明示的に指定すること。<br>数値が小さいほど先に表示される。**100きざみの数値**を推奨。 | `100`, `200` |
| **created_at** | `DATETIME` | 作成日時 | **NOT NULL** / DEFAULT `CURRENT_TIMESTAMP`。<br>レコード作成時に自動セット。手動入力禁止。CSVにも含めないこと。 | `2025-06-01 12:00:00` |
| **updated_at** | `DATETIME` | 更新日時 | **NOT NULL** / DEFAULT `CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`。<br>レコード更新時に自動更新。手動入力禁止。CSVにも含めないこと。 | `2025-06-10 09:30:00` |

---

## 2. 運用ルール・ガイドライン

### ① レシピの記述ルール（アイコン変換前提）

#### 記法一覧

| 記法 | 役割 | 例 | 表示イメージ |
| :--- | :--- | :--- | :--- |
| 数字（1〜9） | レバー方向（各桁を個別変換） | `236` | ↓↘→ |
| `[数字]` | 溜め方向（色付き矢印画像に変換） | `[2]8HK` | 色付き↓矢印 |
| 大文字アルファベット | ボタン | `LP`, `HP`, `SA3` | 各ボタン画像 |
| 方向なし | ニュートラル立ち技（`5` は使用しない） | `HP` | HP画像のみ |
| `j.` | ジャンプ修飾子（通常技・必殺技どちらにも使用可） | `j.HP`, `j.236P[OD]` | 空中技 |
| ` -> ` | 次の技への区切り（**前後スペース必須**） | `2HP -> 214MP` | — |
| ` > ` | 技からの派生入力（**前後スペース必須**） | `214P > HK` | — |
| `~` | 技内の連続入力（▶） | `236P~6P~6P` | — |
| `(xN-M)` | 繰り返し回数（N〜M回）。**最大ヒット数のダメージを `damage` に入力。** | `2LP(x1-3)` | 回数表示 |
| `[J]` | ジャスト入力必須 | `214MP[J]` | ジャストアイコン |
| `[H]` | ホールド入力必須 | `214MP[H]` | ホールドアイコン |
| `[J/H]` | ジャストまたはホールド、どちらでも可 | `214MP[J/H]` | ジャスト／ホールドアイコン |
| `[OD]` | OD技 | `214HP[OD]` | ODアイコン |
| `[数字]` | 何段目でキャンセルするか（修飾子なし＝全段出し切り） | `HK[1]` | 段数アイコン |
| `[NR]` | 生ラッシュ（Natural Rush） | `[NR] -> 2MP` | 生ラッシュアイコン |
| `[CR]` | キャンセルドライブラッシュ | `2HP[CR] -> 2MP` | キャンセルラッシュアイコン |
| `[IM]` | インパクト | `[IM] -> 2HP` | インパクトアイコン |
| `[W]` | 微歩き | `2HP -> [W] -> 214MP[J]` | 歩きアイコン |
| `[BJ]` | バックジャンプ（移動として使用） | `[IM] -> [BJ] -> j.HP` | バックジャンプアイコン |
| `[BS]` | バックステップ（移動として使用） | `[IM] -> [BS] -> 2HP` | バックステップアイコン |
| `[D]` | ディレイ（技の前に付けて遅らせ入力を示す） | `63214HK -> [D]1HK` | ディレイアイコン |
| `[AUTO]` | 自動派生（入力不要） | `236K > [AUTO] > K` | AUTOアイコン |

#### ルールの補足

* ` -> ` の**前後スペースは必須**です。スペースなしの `HP->214MP` はパーサーが `HP-` の `-` を誤認するリスクがあります。
* ` > ` の**前後スペースは必須**です。` -> ` との区別はスペースで囲まれた `>` 単体かどうかで判定します。
* ` -> ` / ` > ` / `~` の使い分けは以下の通りです。

| 記法 | 使う場面 | 例 |
| :--- | :--- | :--- |
| ` -> ` | 次の独立した技へ移行する | `2HP -> 214MP` |
| ` > ` | 技から生えたオプション派生を入力する | `214P > HK` |
| `~` | 同一コマンドを連続で入力する（レカ・連打系） | `236P~6P~6P` |
* `5`（ニュートラル）は**使用禁止**。数字も修飾子もなければニュートラル立ち技と判断します。
* 溜め方向は `[]` で囲んでください（例：`[2]8HK`）。囲まれた数字を通常方向と区別し色付き矢印画像に変換します。囲まれていない数字は通常の矢印画像に変換します。
* ジャンプは必ず `j.` を付けてください。通常技・必殺技どちらにも使用できます（例：`j.HP`、`j.236P[OD]`）。`jHP` のように `.` を省略すると `j` が方向なのかジャンプなのかパーサーが判断できなくなります。また `[J]` はジャスト入力として定義済みのためジャンプの表現には使用できません。
* `[CR]` は直前の技の後ろに付けてください（例：`2HP[CR] -> 2MP`）。
* `[NR]` と `[IM]` はコンボの始点として先頭に記述してください（例：`[NR] -> 2MP -> 2HP`）。
* `[W]` は微歩きが必要な箇所に挿入してください。`6`（前入れ方向入力）と区別するため必ずタグ形式を使用してください。
* `[BJ]` はバックジャンプを移動として使う箇所に挿入してください。方向入力の `7` と区別するため必ずタグ形式を使用してください。
* `[BS]` はバックステップを移動として使う箇所に挿入してください。方向入力の `44` と区別するため必ずタグ形式を使用してください。
* `[D]` はディレイが必要な技の**直前**に付けてください。` -> ` との間にスペースは入れません（例：`63214HK -> [D]1HK`）。
* `[AUTO]` は入力不要の自動派生が発生する箇所に挿入してください。必ず ` > ` で挟んで使用します（例：`236K > [AUTO] > K`）。
* `[H]` はホールド入力が必要な技に付けてください。記法なし（例：`214MP`）はホールドなし＝最速入力を意味します。
* `[J]` と `[H]` はどちらでも可能な場合は `[J/H]` と記述してください。`[J]` と `[H]` を単独で使う場合はその入力が必須であることを意味します。
* 多段技のキャンセル段数は技の後ろに `[数字]` で指定してください（例：`HK[1]`）。修飾子なしは全段出し切りを意味します。`1HK` のように前に付けると方向入力と混同するため禁止です。
* `(xN-M)` を使用した場合、`damage` カラムには**最大ヒット数（M回）時のダメージ**を入力してください。

#### 記法例

```
-- 基本コンボ
2HP -> 214MP[J] -> 214LP[J] -> 214HP[J]

-- 溜め技を含むコンボ
MP -> 2MP -> [2]8HK

-- 派生技を含むコンボ
2MP -> 214P > HK -> 236HK

-- ジャンプ中必殺技を含むコンボ
2HP -> 236HP -> j.236P[OD] -> 236K > LK -> 236LP

-- 自動派生を含むコンボ
2HP -> 236HP -> j.236P[OD] -> 236K > [AUTO] > LK -> 236LP

-- バックジャンプを含むスタンコンボ
[IM] -> [BJ] -> j.HP -> 2HP -> 236HK

-- バックステップを含むコンボ
[IM] -> [BS] -> 2HP -> 236HK

-- ディレイを含むコンボ
63214HK -> [D]1HK

-- 多段技の途中段でキャンセルするコンボ
[IM] -> HK[1] -> 236K > 2P -> [4]6HP

-- 繰り返し記法（generalページ向け・1〜3回変動）
2LP(x1-3) -> 214MK
-- damage には 2LP x3 時のダメージ（最大値）を入力する

-- ジャンプ始動
j.HK -> 2HP -> 214MP[J] -> 214LP[J] -> 214HP[J]

-- 生ラッシュ始動
[NR] -> 2MP -> 2HP -> 214MP[J] -> 214LP[J] -> 214HP[J]

-- キャンセルドライブラッシュ使用
2HP[CR] -> 2MP -> 214MP[J] -> 214LP[J] -> 214HP[J]

-- インパクト始動（パニカン）
[IM] -> 2HP -> 214MP[J] -> 214LP[J] -> 214HP[J]

-- インパクト始動（壁やられ）
[IM] -> HP -> 214LP[J] -> 214HP[J]

-- ホールド入力を含むリカバリーコンボ
2HP -> 214MP[H] -> 214LP[H] -> 214MP

-- 複合コマンド技（連続入力）
236P~6P~6P -> 214HP[J]
```

---

### ② page_type の運用

| 値 | 対象 | 状況カラムの厳密さ | コンボ数 |
| :--- | :--- | :--- | :--- |
| `general` | 初心者・サブキャラ向け汎用ページ | 省略可（DEFAULT値で代用） | 少なめ・厳選 |
| `special` | キャラ特設ページ（豪鬼等） | 全カラム厳密に入力 | 網羅的 |

* `general` では `position` / `hit_type` / `hit_position` / `special_state` をDEFAULT値のまま入力し、状況の厳密な分類は省略しても構いません。
* `special` では全カラムを厳密に入力してください。
* PHP側で `WHERE page_type = 'general' AND character_id = 1` のように絞り込んで表示します。

---

### ③ char_condition（キャラ固有条件）の記述ルール

#### 記法

```
[識別子]_[条件]
```

条件部分の記法は以下の通りです。

| 条件記法 | 意味 | 例 |
| :--- | :--- | :--- |
| `_N` | 値がちょうどN | `drink_0`（酔いレベルが0） |
| `_N-M` | 値がNからM | `drink_0-1`（酔いレベルが0か1） |
| `_N+` | 値がN以上 | `drink_2+`（酔いレベルが2以上） |
| `_active` | 強化状態が有効中 | `mashin_active`（絶唱魔身強化中） |

#### キャラクター別 char_condition 一覧

| キャラ | 能力名 | 識別子 | 範囲／状態 | コンボへの影響 |
| :--- | :--- | :--- | :--- | :--- |
| ジェイミー | 酔いレベル | `drink` | 0〜4 | 使用できる技・ダメージが増加 |
| ジェイミー | 絶唱魔身 | `mashin` | `active` | 酔いレベルが4になり一定時間強化 |
| マノン | メダルレベル | `medal` | 1〜5 | コマ投げのダメージのみ変化 |
| キンバリー | 手裏剣ストック | `shuriken` | 0〜2 | 特定技の使用可否が変わる |
| リリー | 風纏いスタック | `wind` | 0〜3 | 必殺技が強化される |
| ジュリ | 風波ストック | `fstock` | 0〜3 | キャンセル・必殺技強化・コンボ増加 |
| ジュリ | 風水エンジン | `fse` | `active` | 通常技にキャンセルがかかるようになる |
| リュウ | 電刃錬気 | `denjin` | 0〜1 | 一部必殺技が強化されコンボが増える |
| 本田 | 肩屋入り | `shoulder` | 0〜1 | 一部必殺技が強化されコンボが増える |
| ガイル | ソリッドパンチャー | `solid_puncher` | `active` | 飛び道具が強化される |
| ブランカ | ブランカちゃん爆弾 | `bomb` | 0〜3 | 特定技の使用可否が変わる |
| ブランカ | ライトニングビースト | `lightning` | `active` | 必殺技が強化される |
| 舞 | 焔ストック | `flame` | 0〜5 | 必殺技が強化されコンボが増える |
| ヴァイパー | バウンサーステップ | `bouncer` | `active` | 特殊キャンセル時のゲージ消費がなくなる |

#### char_condition の記述例

```
drink_0       酔いレベルがちょうど0
drink_0-1     酔いレベルが0か1
drink_2+      酔いレベルが2以上
drink_4       酔いレベルが4（最大）
mashin_active 絶唱魔身強化中
medal_3+      メダルレベルが3以上
fstock_1+     風波ストックが1以上
fstock_3      風波ストックが3（最大）
denjin_1      電刃錬気ストックあり
flame_1+      焔ストックが1以上
```

> 一覧にない値（例：`drink_3+`）も上記の記法規則に従えば自由に使用できます。

---

### ④ position / hit_type / hit_position / special_state の分類

4つのカラムを組み合わせることで状況を正確に表現できます。`special` ページでは必ず指定してください。

**position（場所の状態）**

| 値 | 意味 |
| :--- | :--- |
| `Any` | 場所を問わず使用可能（DEFAULT） |
| `Mid` | 中央限定 |
| `Corner` | 画面端限定 |

**hit_type（ヒットの強度）**

| 値 | 意味 |
| :--- | :--- |
| `Normal` | 通常ヒット始動（DEFAULT） |
| `Counter` | カウンターヒット始動 |
| `Punish` | パニッシュカウンター始動（確反用） |

**hit_position（相手の状態）**

| 値 | 意味 |
| :--- | :--- |
| `Ground` | 相手が地上にいる状態（DEFAULT） |
| `Air` | 相手が空中にいる状態（空中ぐらい） |

**special_state（特殊やられ状態）**

| 値 | 意味 |
| :--- | :--- |
| `None` | 通常・特殊状態なし（DEFAULT） |
| `WallSplat` | 壁やられ（画面端インパクト通常ヒット時） |
| `Stun` | スタン（相手のDゲージが0の壁やられ） |

> `special_state` に新しい状態を追加する場合は `ALTER TABLE` でENUMを拡張してください。

**組み合わせ例**

| position | hit_type | hit_position | special_state | 意味 |
| :--- | :--- | :--- | :--- | :--- |
| `Mid` | `Normal` | `Ground` | `None` | 中央・通常ヒット・地上 |
| `Any` | `Punish` | `Ground` | `None` | インパクトパニカン始動 |
| `Corner` | `Normal` | `Ground` | `WallSplat` | 壁やられコンボ |
| `Corner` | `Normal` | `Ground` | `Stun` | スタンコンボ |
| `Any` | `Punish` | `Air` | `None` | パニカン空中ぐらい |

---

### ⑤ start_move / end_move の記述ルール

* `start_move` は**フレームデータテーブルとの結合キー**として使用します。
* `end_move` は**締め技に紐づく起き攻め・連携・SAキャンセル情報との結合キー**として使用します。
* どちらも将来作成するフレームデータテーブルの `move_slug` と同じ識別子を入力してください。
* ラッシュ・インパクト始動の場合は以下の識別子を使用します。

| 始動 | start_move の値 | drive_gauge |
| :--- | :--- | :--- |
| 生ラッシュ | `[NR]` | 1 |
| キャンセルドライブラッシュ | `[CR]` | 2 |
| インパクト | `[IM]` | 1 |

```sql
-- start_move でフレームデータと結合するイメージ
SELECT c.title, c.recipe, f.startup_frames
FROM combos c
JOIN frame_data f
  ON c.character_id = f.character_id
 AND c.start_move   = f.move_slug
WHERE c.character_id = 1;

-- end_move で起き攻め・SAキャンセル情報と結合するイメージ
SELECT c.title, c.recipe, m.can_cancel_sa, m.oki_type
FROM combos c
JOIN move_data m
  ON c.character_id = m.character_id
 AND c.end_move     = m.move_slug
WHERE c.character_id = 1;
```

---

### ⑥ combo_group の運用

* **同じ始動技・状況から派生するバリエーションコンボ**を束ねるために使用します。
* PHP側で `combo_group` が同じレコードをまとめて表示することで「状況によって使い分けるコンボ群」として見せられます。
* バリエーションのない単独コンボは **NULL** にしてください。
* 命名は `[カテゴリ]` または `[カテゴリ]-[サブカテゴリ]` 形式を推奨します。

**主なcombo_group名称**

| combo_group | 用途 |
| :--- | :--- |
| `general` | 汎用コンボ群 |
| `general-carry` | 汎用の運びコンボ群 |
| `damage` | ダメージ重視コンボ群 |
| `damage-sa3` | SA3使用ダメージコンボ群 |
| `punish` | 確反コンボ群 |
| `punish-meterless` | ゲージなし確反コンボ群 |
| `4f-carry` | 4F始動運びコンボ群 |
| `4f-damage` | 4F始動ダメージコンボ群 |
| `jump` | ジャンプ攻撃始動コンボ群 |
| `crossup` | めくりジャンプ始動コンボ群 |
| `rush` | ラッシュ始動コンボ群 |
| `anti-air` | 対空始動コンボ群 |
| `oki-corner` | 画面端起き攻めコンボ群 |

**`general` ページでの `(xN-M)` 記法との使い分け**

| ページ | 方針 | 例 |
| :--- | :--- | :--- |
| `general` | `(xN-M)` 記法で1レコードにまとめる | `2LP(x1-3) -> 214MK`（damage = 最大値） |
| `special` | `combo_group` で束ね各ヒット数を別レコードで管理 | `2LP -> 214MK` / `2LP -> 2LP -> 214MK` / `2LP -> 2LP -> 2LP -> 214MK` |

---

### ⑦ combo_slug の命名規則（Excel自動生成）

#### 命名規則

```
[position]-[hit_type]-[hit_position省略可]-[special_state省略可]-[連番]
```

* `hit_position` は `Ground` の場合は**省略**。`Air` の場合のみ記載。
* `special_state` は `None` の場合は**省略**。`WallSplat` / `Stun` の場合のみ記載。
* 連番はキャラ × position × hit_type × hit_position × special_state の組み合わせ内での通し番号。

**生成例**

| position | hit_type | hit_position | special_state | 生成されるslug |
| :--- | :--- | :--- | :--- | :--- |
| `Mid` | `Normal` | `Ground` | `None` | `mid-normal-1` |
| `Mid` | `Normal` | `Ground` | `None` | `mid-normal-2` |
| `Any` | `Normal` | `Ground` | `None` | `any-normal-1` |
| `Corner` | `Normal` | `Ground` | `WallSplat` | `corner-normal-wallsplat-1` |
| `Corner` | `Normal` | `Ground` | `Stun` | `corner-normal-stun-1` |
| `Any` | `Normal` | `Air` | `None` | `any-normal-air-1` |
| `Any` | `Punish` | `Ground` | `None` | `any-punish-1` |

#### Excel 自動生成式

以下の列構成を前提とします。

| 列 | カラム |
| :--- | :--- |
| A列 | character_id |
| G列 | position |
| H列 | hit_type |
| I列 | hit_position |
| J列 | special_state |

```excel
=LOWER(
  G2
  & "-" & H2
  & IF(I2="Air", "-air", "")
  & IF(J2="WallSplat", "-wallsplat", IF(J2="Stun", "-stun", ""))
  & "-"
  & COUNTIFS($A$2:A2, A2, $G$2:G2, G2, $H$2:H2, H2, $I$2:I2, I2, $J$2:J2, J2)
)
```

> **列番号の変更について**: `page_type` カラムの追加によりExcel上の列がずれている場合は、上記の列番号を実際のExcelファイルに合わせて調整してください。

---

### ⑧ damage の入力ルール

* 通常は実測値を手動で入力します。
* `(xN-M)` 記法を使用している場合は**最大ヒット数（M回）時のダメージを入力**してください。
* 将来フレームデータテーブルから自動計算できるようになった場合、このカラムを自動更新する処理に切り替えます。

---

### ⑨ drive_gauge / sa_gauge の入力範囲
* `drive_gauge` : `0`〜`6` の整数のみ有効（CHECK制約でDBが弾く）
* `sa_gauge` : `0`〜`3` の整数のみ有効（CHECK制約でDBが弾く）
* CHECK制約はMySQL 8.0.16以降で有効です。それ以前のバージョンでは制約が機能しないため、アプリケーション側でのバリデーションを必ず実装してください。

### ⑩ is_recommended フラグの運用
* `1` を設定したコンボはキャラページの上部や★マーク付きで優先表示する運用を想定しています。
* キャラごとに複数設定しても問題ありませんが、多すぎると意味が薄れるため、各キャラ3件以内を目安にしてください。

### ⑪ 外部キー制約（ON DELETE CASCADE）
* `character_id` は必ず `characters` テーブルに存在するIDを指定してください。
* `characters` テーブルのレコードが削除された場合、そのキャラのコンボもすべて自動削除されます（CASCADE）。
* キャラクターの削除は慎重に行い、必ず事前にバックアップを取ってください。

### ⑫ sort_order の決め方（ギャップ法）
* 最初から **100, 200, 300...** と間隔を開けて設定してください。
* 間に差し込みたい場合は `150` や `250` を使うことで、既存データの書き換えを回避します。
* **`sort_order` にデフォルト値はありません。INSERT時に必ず明示的に指定してください。**

### ⑬ created_at / updated_at の取り扱い
* どちらも **MySQLが自動でセット・更新** します。アプリケーション側からの手動入力は禁止です。
* CSVインポート時もこの2カラムは**列ごと除外**してください。

---

## 3. CSVインポートガイドライン

### CSVに含めるカラム（列順）

```
character_id, combo_slug, combo_group, page_type, title, recipe,
difficulty, position, hit_type, hit_position, special_state, char_condition,
start_move, end_move, damage, drive_gauge, sa_gauge,
is_recommended, memo, sort_order
```

> `id`, `created_at`, `updated_at` は**CSVに含めないこと**。MySQLが自動で処理します。

### NULL の記述方法

| 項目 | ルール |
| :--- | :--- |
| NULLにしたい列 | `\N` と記述する（空欄のままにしない） |
| `combo_group` | 単独コンボは `\N` |
| `char_condition` | 固有条件不要のコンボは `\N` |
| `start_move` / `end_move` | 未設定の場合は `\N` |
| `drive_gauge` / `sa_gauge` | DEFAULT `0` があるが、CSVには明示的に `0` と記述することを推奨 |
| `hit_position` / `special_state` | DEFAULT値があるが、CSVには明示的に記述することを推奨 |
| `page_type` | 省略不可。必ず `general` または `special` を記述 |
| `is_recommended` | 通常は `0` と記述 |

---

## 4. インデックス設計

| インデックス名 | 対象カラム | 種別 | 用途 |
| :--- | :--- | :--- | :--- |
| PRIMARY | `id` | PRIMARY KEY | 主キー |
| `uq_char_combo` | `character_id`, `combo_slug` | UNIQUE | キャラクター内でのslug重複防止 |
| `idx_character_id` | `character_id` | INDEX | キャラ別コンボ一覧の高速化 |
| `idx_page_type` | `page_type` | INDEX | ページ種別での絞り込み高速化 |
| `idx_combo_group` | `combo_group` | INDEX | グループ別コンボ取得の高速化 |
| `idx_position` | `position` | INDEX | 場所でのフィルタリング高速化 |
| `idx_hit_type` | `hit_type` | INDEX | ヒット強度でのフィルタリング高速化 |
| `idx_hit_position` | `hit_position` | INDEX | 相手状態でのフィルタリング高速化 |
| `idx_special_state` | `special_state` | INDEX | 特殊状態でのフィルタリング高速化 |
| `idx_char_condition` | `char_condition` | INDEX | キャラ固有条件でのフィルタリング高速化 |

---

## 5. SQL定義

```sql
CREATE TABLE combos (
    id             INT           NOT NULL AUTO_INCREMENT,
    character_id   INT           NOT NULL,
    combo_slug     VARCHAR(100)  NOT NULL,
    combo_group    VARCHAR(100)           DEFAULT NULL,
    page_type      ENUM('general', 'special') NOT NULL DEFAULT 'general',
    title          VARCHAR(150),
    recipe         TEXT          NOT NULL,
    difficulty     ENUM('Beginner', 'Intermediate', 'Advanced')   NOT NULL,
    position       ENUM('Any', 'Mid', 'Corner')                   NOT NULL DEFAULT 'Any',
    hit_type       ENUM('Normal', 'Counter', 'Punish')            NOT NULL DEFAULT 'Normal',
    hit_position   ENUM('Ground', 'Air')                          NOT NULL DEFAULT 'Ground',
    special_state  ENUM('None', 'WallSplat', 'Stun')              NOT NULL DEFAULT 'None',
    char_condition VARCHAR(50)            DEFAULT NULL,
    start_move     VARCHAR(50)            DEFAULT NULL,
    end_move       VARCHAR(50)            DEFAULT NULL,
    damage         INT                    DEFAULT NULL,
    drive_gauge    TINYINT       NOT NULL DEFAULT 0 CHECK (drive_gauge BETWEEN 0 AND 6),
    sa_gauge       TINYINT       NOT NULL DEFAULT 0 CHECK (sa_gauge    BETWEEN 0 AND 3),
    is_recommended TINYINT(1)    NOT NULL DEFAULT 0,
    memo           TEXT,
    sort_order     INT           NOT NULL,
    created_at     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_char_combo`    (`character_id`, `combo_slug`),
    INDEX `idx_character_id`      (`character_id`),
    INDEX `idx_page_type`         (`page_type`),
    INDEX `idx_combo_group`       (`combo_group`),
    INDEX `idx_position`          (`position`),
    INDEX `idx_hit_type`          (`hit_type`),
    INDEX `idx_hit_position`      (`hit_position`),
    INDEX `idx_special_state`     (`special_state`),
    INDEX `idx_char_condition`    (`char_condition`),
    FOREIGN KEY (`character_id`) REFERENCES `characters`(`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 6. INSERT例

```sql
-- char_conditionなし（通常コンボ）
INSERT INTO combos
    (character_id, combo_slug, combo_group, page_type, title, recipe,
     difficulty, position, hit_type, hit_position, special_state, char_condition,
     start_move, end_move, damage, drive_gauge, sa_gauge, is_recommended, memo, sort_order)
VALUES (
    1, 'any-normal-1', '4f-carry', 'general', '4F始動 運び',
    '2LP(x1-3) -> 214MK',
    'Beginner', 'Any', 'Normal', 'Ground', 'None', NULL,
    '2LP', '214MK', 1350, 0, 0, 1,
    '距離によって2LPの回数を1〜3回に変更する。  \ndamageは3ヒット時の最大値。',
    100
);

-- ジェイミー：酔いレベル別コンボ（char_conditionで分岐）
INSERT INTO combos
    (character_id, combo_slug, combo_group, page_type, title, recipe,
     difficulty, position, hit_type, hit_position, special_state, char_condition,
     start_move, end_move, damage, drive_gauge, sa_gauge, is_recommended, memo, sort_order)
VALUES
    (3, 'any-normal-1', 'general', 'general', '汎用コンボ',
     '2HP -> 623HK -> 22P',
     'Beginner', 'Any', 'Normal', 'Ground', 'None', 'drink_0-1',
     '2HP', '623HK', 2070, 0, 0, 1,
     '強張弓腿を使い魔身でレベルを上げましょう。', 100),
    (3, 'any-normal-2', 'general', 'general', '汎用コンボ',
     '2HP -> 236HK',
     'Beginner', 'Any', 'Normal', 'Ground', 'None', 'drink_2+',
     '2HP', '236HK', 2700, 0, 0, 1,
     '爆廻は酔いレベル2以上から使用できる。', 200);

-- 壁やられコンボ（char_conditionなし）
INSERT INTO combos
    (character_id, combo_slug, combo_group, page_type, title, recipe,
     difficulty, position, hit_type, hit_position, special_state, char_condition,
     start_move, end_move, damage, drive_gauge, sa_gauge, is_recommended, memo, sort_order)
VALUES (
    1, 'corner-normal-wallsplat-1', NULL, 'special', '壁やられコンボ',
    '[IM] -> 4HP -> 214MP -> 623HP',
    'Intermediate', 'Corner', 'Normal', 'Ground', 'WallSplat', NULL,
    '[IM]', '623HP', 2840, 1, 0, 0,
    '汎用コンボを使用してもよいがこのコンボは火力が伸びる。',
    400
);
```