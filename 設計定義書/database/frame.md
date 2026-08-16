# frame テーブル定義書 (Street Fighter 6 Strategy Site)

このテーブルは、各キャラクターの技フレームデータを管理します。
「対策ページ」「フレームデータ一覧」での硬直差・無敵・ダメージ情報の表示に使用されます。
movelistテーブルと `character_id` + `move_slug` でJOINして使用します。

---

## 1. カラム定義一覧

| カラム名 | 型 (SQL型) | 説明 | 入力ルール / 備考 | 具体例 |
| :--- | :--- | :--- | :--- | :--- |
| **id** | `INT` | 固有ID | **PRIMARY KEY / AUTO_INCREMENT**<br>手動入力禁止。CSVにも含めないこと。 | `1`, `2`... |
| **character_id** | `INT` | キャラ紐付け | **NOT NULL / FOREIGN KEY**<br>`characters.id` と一致させる。 | `2`（ルーク） |
| **move_slug** | `VARCHAR(100)` | 技識別子 | **NOT NULL**<br>movelistテーブルの `move_slug` と完全一致させる。 | `flash_knuckle`, `2hp` |
| **move_type** | `ENUM` | 技の種類 | **NOT NULL**。movelistと同じ値を使用。<br>`normal_moves` / `unique_attacks` / `special_moves` / `super_arts` / `throws` / `common_moves`<br>movelistに通常技が存在しない場合でもframe単体でフィルタリング可能にするために持つ。 | `normal_moves`, `special_moves` |
| **move_variant** | `VARCHAR(50)` | 技バリアント | **NULL許可**。<br>弱・中・強・OD・ホールド・ジャスト・多段技の段数など。<br>同一move_slugで複数レコードを持つ場合に使用。 | `L`, `M`, `H`, `OD`, `charged`, `perfect`, `1hit`, `2hit` |
| **move_name_jp** | `VARCHAR(150)` | 技名（日本語） | **NOT NULL**。 | `弱フラッシュナックル`, `強フラッシュナックル(ジャスト)` |
| **move_name_en** | `VARCHAR(150)` | 技名（英語） | **NOT NULL**。 | `L Flash Knuckle`, `H Flash Knuckle(Perfect)` |
| **command** | `VARCHAR(100)` | コマンド | **NULL許可**。<br>combosテーブルのrecipe記法に準拠。<br>特殊な使用条件がある技はコマンドの前に `(条件)` をインラインで記述する。<br>movelistと異なりconditionカラムは持たない。 | `623LP`, `(ODサンドブラスト後に)PP`, `(近距離で)Nor6LPLK`, `(体力25%以下で)236236K` |
| **startup** | `VARCHAR(20)` | 発生フレーム | **NULL許可**。<br>数値または特殊表記。VARCHAR型で管理。 | `7`, `14`, `—`（移動技など） |
| **active** | `VARCHAR(30)` | 持続フレーム | **NULL許可**。<br>数値・範囲・特殊表記を含む。 | `7-8`, `5-14`, `着地後3` |
| **recovery** | `VARCHAR(30)` | 硬直フレーム | **NULL許可**。<br>全体フレームで表記する場合も含む。 | `24`, `全体 47`, `22+着地後12` |
| **hit_adv** | `VARCHAR(20)` | ヒット時硬直差 | **NULL許可**。<br>`D`（ダウン）、数値（正＝有利、負＝不利）、`—`（空中技等）を含む。 | `2`, `-3`, `D`, `—` |
| **guard_adv** | `VARCHAR(20)` | ガード時硬直差 | **NULL許可**。<br>同上。 | `-3`, `-8`, `D` |
| **cancel** | `VARCHAR(50)` | キャンセル可否 | **NULL許可**。<br>可能なキャンセル種別をカンマ区切りで記述。 | `C`, `SA`, `SA3`, `SA2`, `C,SA3` |
| **damage** | `VARCHAR(30)` | ダメージ | **NULL許可**。<br>特殊表記（`※`付き等）があるためVARCHAR型。 | `700`, `※900`, `1200` |
| **combo_scaling** | `VARCHAR(100)` | コンボ補正 | **NULL許可**。<br>始動補正・コンボ補正など複数表記あり。 | `始動補正20%`, `コンボ補正15%`, `即時補正20%` |
| **dg_increase_hit** | `INT` | Dゲージ増加（ヒット時） | **NOT NULL** / DEFAULT `0`。 | `2000`, `250` |
| **dg_decrease_block** | `INT` | Dゲージ減少（ガード時） | **NOT NULL** / DEFAULT `0`。<br>負の値で格納。 | `-3000`, `-500` |
| **dg_decrease_punish** | `INT` | Dゲージ減少（パニカン時） | **NOT NULL** / DEFAULT `0`。<br>負の値で格納。 | `-5000`, `-2000` |
| **sa_gauge_increase** | `INT` | SAゲージ増加 | **NOT NULL** / DEFAULT `0`。 | `500`, `1000` |
| **hit_level** | `VARCHAR(20)` | 攻撃属性（上中下段） | **NULL許可**。<br>公式フレームデータの「属性」列に相当。 | `上`, `下`, `中`, `投`, `上・弾` |
| **miscellaneous** | `TEXT` | 技の特記事項 | **NULL許可**。**Markdown形式**。スペース2つ + `\n` で改行。<br>無敵フレーム・判定・特殊効果・キャンセル条件・パニカン時の変化など技に関するすべての補足情報を記述。 | `1-14F 空中無敵  \n7-34F 空中判定` |
| **sort_order** | `INT` | 表示順 | **NOT NULL**。**100きざみ**推奨。 | `1001`, `1035` |
| **created_at** | `DATETIME` | 作成日時 | **NOT NULL** / DEFAULT `CURRENT_TIMESTAMP`。自動セット。 | — |
| **updated_at** | `DATETIME` | 更新日時 | **NOT NULL** / DEFAULT `CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`。自動更新。 | — |

---

## 2. 運用ルール・ガイドライン

### ① move_variant の使い方

同一 `move_slug` で複数レコードが必要な場合に使用します。バリアントが不要な技は `\N`（NULL）にしてください。

#### 命名規則

複数の要素が重なる場合は以下の**順序で `_` 区切り**で記述します。

```
[強度]_[段数]_[条件]
```

| 要素 | 値 | 使用場面 |
| :--- | :--- | :--- |
| 強度 | `L` / `M` / `H` / `OD` / `CA` | 弱・中・強・OD・CA版 |
| 段数 | `1hit` / `2hit` / `3hit` / `Nhit` | 多段技の各段 |
| 入力種別 | `charged` / `perfect` | ホールド版・ジャスト版 |
| キャラ固有条件 | `drink_lv4` / `denjin_charge` / `lv1` / `lv2` / `lv3` など | char_conditionの識別子に準拠 |
| 状況種別 | `while_blocking` / `while_recovering` / `strike` / `projectile` | ドライブリバーサル・ジャストパリィの区別 |
| 遅延種別 | `immediate` / `delayed` / `longest_delay` | 入力タイミングで挙動が変わる技 |

#### 記述例

| 技名 | move_variant |
| :--- | :--- |
| 弱フラッシュナックル | `L` |
| 弱フラッシュナックル(ホールド) | `L_charged` |
| 弱フラッシュナックル(ジャスト) | `L_perfect` |
| ODフラッシュナックル | `OD` |
| SA2 真波掌撃(Lv1) | `lv1` |
| 電刃錬気 SA2 真波掌撃(Lv1) | `denjin_charge_lv1` |
| 弱 流酔拳(1段目) | `L_1hit` |
| 弱 流酔拳(1段目) 酔いLv4 | `L_1hit_drink_lv4` |
| OD 流酔拳(2段目) 酔いLv4 | `OD_2hit_drink_lv4` |
| 不破三連撃(2段目) | `2hit` |
| ガード時ドライブリバーサル | `while_blocking` |
| 起き上がりドライブリバーサル | `while_recovering` |
| ジャストパリィ(打撃) | `strike` |
| ジャストパリィ(飛び道具) | `projectile` |
| CA 真・昇龍拳 | `CA` |

#### 注意事項

* **`level4` は `lv4` に統一**します（`char_condition` の識別子 `drink_4` との整合性を保つため）。
* 強度（L/M/H/OD）のみで区別できる場合は段数・条件を省略します。
* 単一コマンドで1レコードのみの場合は `\N`（NULL）にします。

---

### ② command の記法

combosテーブルの `command` 記法（定義書参照）に準拠します。movelistと異なり `condition` カラムを持たないため、特殊な使用条件はコマンドの前に `(条件)` をインラインで記述します。

| 技の種類 | command 記述例 |
| :--- | :--- |
| 通常技 | `LP`, `2HP`, `j.HK` |
| 弱・中・強の必殺技 | `623LP`, `214MP`, `236HK` |
| OD技 | `623PP`, `214PP` |
| 投げ | `(近距離で)Nor6LPLK` |
| 派生技 | `(ODサンドブラスト後に)PP` |
| ジャンプ中の技 | `(垂直 or 前ジャンプ中に)214P` |
| SA通常版・CA版 | `236236K` / `(体力25%以下で)236236K` |
| 電刃錬気強化版 | `(電刃錬気)236LP` |

`command_converter.php` は括弧内テキストを文字列としてそのまま通過させるため、追加実装なしで変換できます。

---

### ③ フレーム値の特殊表記ルール

公式フレームデータには数値以外の表記が多く含まれます。すべて **VARCHAR型** で格納します。

| 表記 | 意味 | 記述例 |
| :--- | :--- | :--- |
| `D` | ダウン | `hit_adv: D` |
| `—` | 該当なし（ジャンプ技の硬直差等） | `hit_adv: —` |
| `※数値` | 注記付き数値 | `damage: ※900` |
| `全体 N` | 全体フレームN | `recovery: 全体 47` |
| `N+着地後M` | 空中技の硬直 | `recovery: 22+着地後12` |
| `着地後N` | 着地後硬直 | `active: 着地後3` |
| `N-M.X` | 持続フレームに2段判定がある技（公式準拠） | `active: 30-34.35`（34Fと35Fで別判定） |

---

### ④ miscellaneous の記述ルール

技に関するすべての補足情報を1カラムに格納します。**Markdown形式（スペース2つ + `\n`）** で改行します。PHP側で改行を `<br>` または箇条書きに変換して表示します。

```
-- 記述例（リュウ弱昇龍拳）
1-14F　空中判定の打撃・空弾属性に対して無敵  \n7-34F　空中判定  \n※持続の3F目以降は個別ダメージ(800)

-- 記述例（ドライブインパクト）
1-27F アーマー判定(2回)  \nヒットバックでステージ端に到達すると壁やられが発生

-- 記述例（単一情報）
連打キャンセル対応
```

---

### ⑤ movelistとのJOIN例

```sql
-- 対策ページ用：必殺技の技名・フレーム情報を取得（movelistに通常技がない場合はframe単体で取得）
SELECT
    f.move_name_jp,
    f.move_type,
    f.startup,
    f.hit_adv,
    f.guard_adv,
    f.cancel,
    f.miscellaneous,
    m.command,
    m.overview
FROM frame f
LEFT JOIN movelist m
  ON f.character_id = m.character_id
 AND f.move_slug    = m.move_slug
WHERE f.character_id = 2
  AND f.move_type = 'special_moves'
ORDER BY f.sort_order;
```

---

### ⑥ dg_decrease_block / dg_decrease_punish の符号

旧CSVでは正の値で格納されていましたが、**負の値（マイナス）**で格納することを推奨します。画面表示時に「減少量」として明示しやすくなります。

```
旧CSV: drive_gauge_decrease(block) = 3000
新定義: dg_decrease_block = -3000
```

---

## 3. CSVインポートガイドライン

### CSVに含めるカラム（列順）

```
character_id, move_slug, move_type, move_variant, move_name_jp, move_name_en, command,
startup, active, recovery, hit_adv, guard_adv, cancel,
damage, combo_scaling,
dg_increase_hit, dg_decrease_block, dg_decrease_punish, sa_gauge_increase,
hit_level, miscellaneous, sort_order
```

> `id`, `created_at`, `updated_at` は**CSVに含めないこと**。

### NULL の記述方法

| 項目 | ルール |
| :--- | :--- |
| NULLにしたい列 | `\N` と記述 |
| `move_variant` | バリアント不要な技は `\N` |
| `startup` / `active` / `recovery` | 移動技など値がない場合は `\N` |
| `hit_adv` / `guard_adv` | ジャンプ技など該当なしは `—` または `\N` |
| `cancel` | キャンセル不可は `\N` |
| `miscellaneous` | 特記事項なしは `\N` |
| `dg_increase_hit` / `dg_decrease_block` / `dg_decrease_punish` / `sa_gauge_increase` | **NOT NULL DEFAULT `0`** のため空白でも自動で `0` が入る。明示的に `0` と記述することを推奨。 |

---

## 4. インデックス設計

| インデックス名 | 対象カラム | 種別 | 用途 |
| :--- | :--- | :--- | :--- |
| PRIMARY | `id` | PRIMARY KEY | 主キー |
| `uq_char_frame` | `character_id`, `move_slug`, `move_variant` | UNIQUE | 重複防止 |
| `idx_character_id` | `character_id` | INDEX | キャラ別一覧の高速化 |
| `idx_move_type` | `move_type` | INDEX | 技種別フィルタリング高速化 |
| `idx_move_slug` | `move_slug` | INDEX | movelist JOINの高速化 |

---

## 5. SQL定義

```sql
CREATE TABLE frame (
    id                INT            NOT NULL AUTO_INCREMENT,
    character_id      INT            NOT NULL,
    move_slug         VARCHAR(100)   NOT NULL,
    move_type         ENUM('normal_moves', 'unique_attacks', 'special_moves', 'super_arts', 'throws', 'common_moves') NOT NULL,
    move_variant      VARCHAR(50)             DEFAULT NULL,
    move_name_jp      VARCHAR(150)   NOT NULL,
    move_name_en      VARCHAR(150)   NOT NULL,
    command           VARCHAR(100)            DEFAULT NULL,
    startup           VARCHAR(20)             DEFAULT NULL,
    active            VARCHAR(30)             DEFAULT NULL,
    recovery          VARCHAR(30)             DEFAULT NULL,
    hit_adv           VARCHAR(20)             DEFAULT NULL,
    guard_adv         VARCHAR(20)             DEFAULT NULL,
    cancel            VARCHAR(50)             DEFAULT NULL,
    damage            VARCHAR(30)             DEFAULT NULL,
    combo_scaling     VARCHAR(100)            DEFAULT NULL,
    dg_increase_hit    INT          NOT NULL DEFAULT 0,
    dg_decrease_block  INT          NOT NULL DEFAULT 0,
    dg_decrease_punish INT          NOT NULL DEFAULT 0,
    sa_gauge_increase  INT          NOT NULL DEFAULT 0,
    hit_level         VARCHAR(20)             DEFAULT NULL,
    miscellaneous     TEXT,
    sort_order        INT            NOT NULL,
    created_at        DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at        DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_char_frame`   (`character_id`, `move_slug`, `move_variant`),
    INDEX `idx_character_id`     (`character_id`),
    INDEX `idx_move_type`        (`move_type`),
    INDEX `idx_move_slug`        (`move_slug`),
    FOREIGN KEY (`character_id`) REFERENCES `characters`(`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```