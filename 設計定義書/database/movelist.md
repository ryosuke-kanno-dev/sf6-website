# movelist テーブル定義書 (Street Fighter 6 Strategy Site)

このテーブルは、各キャラクターの全技データ（通常技・特殊技・必殺技・SA・投げ・共通）の**基本情報**を管理します。
「コマンドリストページ」「技の概要表示」に使用されます。

フレームデータ（発生・持続・硬直差・ダメージ等）は **frameテーブル** で管理します。
`character_id` + `move_slug` をキーにframeテーブルとJOINして使用します。

> **combosテーブルの `start_move` / `end_move` との対応について**
> 現在combosの `start_move` / `end_move` はコマンド記法（例：`214MP`）で記述していますが、
> frameテーブル完成後に `move_slug` に合わせて修正する予定です。それまでは現状のまま進めます。

### movelistとframeの役割分担

| 情報 | movelist | frame |
| :--- | :--- | :--- |
| 技名・コマンド・派生関係 | ✅ | — |
| 使用条件 | ✅ | — |
| 技の概要・戦略的解説 | ✅ | — |
| 消費ドライブゲージ・SAレベル | ✅ | — |
| 発生・持続・硬直フレーム | — | ✅ |
| ヒット時・ガード時硬直差 | — | ✅ |
| ダメージ・コンボ補正 | — | ✅ |
| ゲージ増減 | — | ✅ |
| キャンセル可否・技術的補足 | — | ✅ |
| 攻撃属性（上中下段・投・弾） | — | ✅ |

---

## 1. カラム定義一覧

| カラム名 | 型 (SQL型) | 説明 | 入力ルール / 備考 | 具体例 |
| :--- | :--- | :--- | :--- | :--- |
| **id** | `INT` | 固有ID | **PRIMARY KEY / AUTO_INCREMENT**<br>システムが自動で振る連番。手動入力禁止。CSVにも含めないこと。 | `1`, `2`... |
| **character_id** | `INT` | キャラ紐付け | **NOT NULL / FOREIGN KEY**<br>`characters.id` と一致させる。 | `2`（ルーク） |
| **move_slug** | `VARCHAR(100)` | 技識別子 | **NOT NULL**<br>キャラクター内でユニーク（複合UNIQUE）。<br>スネークケースで記述。弱・中・強・OD含むすべてのバリアントを1レコードで管理。<br>将来的にframeテーブルとのJOINキーになる。 | `flash_knuckle`, `rising_uppercut` |
| **move_type** | `ENUM` | 技の種類 | **NOT NULL**。取りうる値は固定：<br>`normal_moves` / `unique_attacks` / `special_moves` / `super_arts` / `throws` / `common_moves` | `special_moves` |
| **name_jp** | `VARCHAR(100)` | 技名（日本語） | **NOT NULL**。 | `フラッシュナックル` |
| **name_en** | `VARCHAR(100)` | 技名（英語） | **NOT NULL**。 | `Flash Knuckle` |
| **command** | `VARCHAR(100)` | コマンド | **NOT NULL**<br>combosテーブルのrecipe記法に準拠。 | `214P`, `[2]8HK`, `LPLK` |
| **parent_slug** | `VARCHAR(100)` | 派生元の技識別子 | **NULL許可**。<br>派生技の場合、親技の `move_slug` を入力。<br>親技はNULL。CSVに直接記述できる。 | `\N`（親）, `avenger`（子） |
| **drive_gauge** | `VARCHAR(20)` | 消費Dゲージ | **NOT NULL** / DEFAULT `0`。<br>通常は整数（`1`〜`6`）。特殊値は以下を参照。 | `0`, `1`, `2`, `0.5`, `hold` |
| **sa_level** | `VARCHAR(20)` | 消費SAゲージ | **NOT NULL** / DEFAULT `0`。<br>SA技は `1`〜`3`。特殊値は以下を参照。 | `0`, `1`, `2`, `3` |
| **condition** | `VARCHAR(150)` | 使用条件 | **NULL許可**。<br>技を使用できる状況の条件。<br>公式コマンドリストの括弧書きに相当。<br>方向入力として変換したい数字は `{}` で囲む（例：`{2}ホールドで性質変化`）。<br>囲まない数字は文字列としてそのまま表示される（例：`体力25%以下で性能がアップ`）。<br>⚠️ **MySQLの予約語のためSQL・PHPクエリでは必ずバッククォートで囲むこと**（`` `condition` ``）。 | `ODサンドブラスト後に`, `{2}ホールドで性質変化`, `近距離で` |
| **overview** | `TEXT` | 技の概要・戦略的解説 | **NULL許可**。**Markdown形式**。スペース2つ + `\n` で改行。<br>「この技は何のための技か」という概要・戦略的な使い方を記述。<br>技術的なフレーム情報はframeの `description` に記述。 | `前方へ拳圧による衝撃波を飛ばす技。離れた間合いのけん制や連係の繋ぎとして有効。` |
| **sort_order** | `INT` | 表示順 | **NOT NULL**。省略不可・必ず明示的に指定すること。<br>**100きざみの数値**を推奨。 | `100`, `200` |
| **created_at** | `DATETIME` | 作成日時 | **NOT NULL** / DEFAULT `CURRENT_TIMESTAMP`。<br>自動セット。手動入力禁止。CSVにも含めないこと。 | `2025-06-01 12:00:00` |
| **updated_at** | `DATETIME` | 更新日時 | **NOT NULL** / DEFAULT `CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`。<br>自動更新。手動入力禁止。CSVにも含めないこと。 | `2025-06-10 09:30:00` |

---

## 2. 運用ルール・ガイドライン

### ① move_slug の命名規則

* スネークケース（小文字・アンダースコア区切り）で記述してください。
* **弱・中・強・ODを含む同技系統は1つの `move_slug` で管理します。** バリアントの区別はframeテーブルの `move_variant` で行います。
* movelistは「技の種類」単位で1レコード、frameは「バリアント」単位で複数レコードという役割分担です。
* **同名の技が複数存在する場合はサフィックスで区別します。**

**同名技のサフィックス命名規則**

| パターン | サフィックス | 例 |
| :--- | :--- | :--- |
| 派生技 | `_[親技の略称]` | `cannon_strike_hooligan`（フーリガン派生） |
| 空中版 | `_aerial` | `cannon_strike_aerial` |
| 地上版 | `_ground` | `cannon_strike_ground` |
| ODのみ別扱いが必要な場合 | `_od` | `cannon_strike_od` |

```
-- キャミィのキャノンストライク（同名2種）
cannon_strike          通常版（前ジャンプ中に214K）       parent_slug: NULL
cannon_strike_hooligan フーリガン派生版（フーリガン中にK） parent_slug: hooligan_combination
```

```
-- movelistは1レコード
flash_knuckle  →  フラッシュナックル（弱/中/強/OD/ホールド/ジャストすべてを代表）

-- frameは複数レコード（move_variantで区別）
flash_knuckle + L        弱フラッシュナックル
flash_knuckle + M        中フラッシュナックル
flash_knuckle + H        強フラッシュナックル
flash_knuckle + OD       ODフラッシュナックル
flash_knuckle + charged  ホールド版
flash_knuckle + perfect  ジャスト版
```

---

### ② command の記法

combosテーブルのrecipe記法（定義書参照）に準拠します。ただしmovelistでは1技単体のコマンドのみを記述するため ` -> ` は使用しません。
バリアントが複数ある技（弱・中・強）はボタン部分を `P` / `K` のように代表表記します。

| 技の種類 | command 記述例 |
| :--- | :--- |
| 弱・中・強がある必殺技 | `214P`（PがLP/MP/HPを代表） |
| 溜め必殺技 | `[2]8K`, `[4]6P` |
| 同時押し | `LPLK`, `HPHK` |
| 派生技（ボタンのみ） | `P`, `K`, `LK`, `HK` |
| ボタン長押し | `K[H]`, `LP[H]`, `6K[H]` |
| 入力の区切り（+画像） | `(任意の方向)+P`, `6+P` |
| 一回転コマンド | `[360]+P`, `[360][360]+P` |
| 投げ | `LPLK`, `4LPLK` |
| 前ステップ派生 | `66` |
| SA | `236236P`, `214214K` |

> `6P` のように方向とボタンが隣接している場合は `+` を省略できます。括弧内テキストとボタンが隣接する場合など、`+` 画像を明示的に表示したい箇所では `+` を記述してください。
> `[360]` は一回転コマンド専用の特殊画像に変換されます。二回転は `[360][360]` と記述し画像を2枚出力します。

---

### ③ condition の記法

condition内で方向入力として矢印画像に変換したい数字は `{}` で囲んでください。囲まない数字は文字列としてそのまま表示されます。

| 記述 | 表示 |
| :--- | :--- |
| `{2}ホールドで性質変化` | ↓ホールドで性質変化 |
| `{6}入力で強化版が発動` | →入力で強化版が発動 |
| `体力25%以下で性能がアップ` | 体力25%以下で性能がアップ（数字は変換されない） |

`{}` はrecipeの `[]` と異なる記号のためパーサーが競合しません。

> ⚠️ **`condition` はMySQLの予約語です。** CREATE TABLE・SELECT・INSERT等のSQL文およびPHPのクエリでは必ずバッククォートで囲んでください。
> ```sql
> -- CREATE TABLE
> `condition` VARCHAR(150) DEFAULT NULL,
>
> -- SELECT
> SELECT `condition`, overview FROM movelist WHERE character_id = 2;
>
> -- INSERT
> INSERT INTO movelist (`condition`, ...) VALUES ('アベンジャー中に', ...);
> ```

```php
// PHP側の変換処理イメージ
$condition = preg_replace_callback('/\{([1-9]+)\}/', function($matches) {
    return convertDirectionToArrow($matches[1]); // 各桁を矢印画像に変換
}, $condition);
```

---

### ④ parent_slug による派生管理

* 派生技でない親技は `parent_slug = NULL`。
* 派生技は `parent_slug` に親技の `move_slug` を入力。
* CSVに直接記述できるためインポート順を気にする必要がありません。
* PHP側で `parent_slug` が同じレコードを親の下にまとめて表示します。

**例：ルークのアベンジャーと派生技**

| move_slug | name_jp | parent_slug | command | condition |
| :--- | :--- | :--- | :--- | :--- |
| `avenger` | アベンジャー | NULL | `236K` | NULL |
| `no_chaser` | ノーチェイサー | `avenger` | `P` | アベンジャー中に |
| `impaler` | インパラー | `avenger` | `K` | アベンジャー中に |
| `ddt` | DDT | `flash_knuckle` | `PP` | ODフラッシュナックル後に |

---

### ⑤ overview と frame.description の使い分け

| カラム | テーブル | 内容 |
| :--- | :--- | :--- |
| `overview` | movelist | 技の概要・戦略的な使い方の解説 |
| `description` | frame | フレーム関連の技術的補足・注意事項 |

```
-- overviewの例（movelist）
サンドブラスト：前方へ拳圧による衝撃波を飛ばす技。離れた間合いのけん制や連係の繋ぎとして有効。

-- descriptionの例（frame）
弱フラッシュナックル：18F以上ボタンホールドすると性能変化。18-20Fの間に離すとジャスト版が発生。
```

---

### ⑥ move_type の使い分け

| 値 | 対象 |
| :--- | :--- |
| `normal_moves` | 立ち・しゃがみ・ジャンプの通常攻撃 |
| `unique_attacks` | キャラ固有の特殊技（コマンド技でないもの） |
| `special_moves` | コマンド入力の必殺技（OD版含む） |
| `super_arts` | SA1〜SA3 |
| `throws` | 通常投げ・コマンド投げ |
| `common_moves` | ドライブインパクト・ドライブリバーサル・ドライブパリィ等 |

> `normal_moves` はmovelistとframeの両方に登録します。movelistには技名・コマンド・概要を、frameには発生・硬直差等を登録してください。

PHP側でのフィルタリング例：
```php
// 必殺技のみ表示
WHERE move_type = 'special_moves'

// SA以外を表示
WHERE move_type != 'super_arts'
```

---

### ⑦ drive_gauge / sa_level の特殊値

`drive_gauge` と `sa_level` はともに `VARCHAR(20)` 型です。

| 値 | 意味 | PHP側の表示 |
| :--- | :--- | :--- |
| `0` | 消費なし | 非表示 |
| `1`〜`6` | 通常消費本数 | Dゲージ画像 + 数値 |
| `0.5` | 0.5本消費 | 0.5ゲージ画像 + `0.5` |
| `hold` | 押している間ずっと消費 | 専用画像 |

SAゲージ（`sa_level`）も同じ規則を使用します。通常は `1`〜`3` の整数ですが、将来特殊値が必要になった場合も対応できます。

```
drive_gauge: 1      Dゲージ1本消費
drive_gauge: 0.5    Dゲージ0.5本消費（パリィドライブラッシュ等）
drive_gauge: hold   押している間消費（ドライブパリィ等）
sa_level:    2      SA2を消費
```

---

### ⑧ frameテーブルとのJOIN

movelistはコマンドリストページ、frameは対策ページ・フレームデータページで使用します。

```sql
-- 対策ページ用：必殺技の技名・概要・フレーム情報を合わせて取得
SELECT
    m.name_jp,
    m.command,
    m.overview,
    f.move_variant,
    f.startup,
    f.hit_adv,
    f.guard_adv,
    f.cancel,
    f.description
FROM movelist m
JOIN frame f
  ON m.character_id = f.character_id
 AND m.move_slug    = f.move_slug
WHERE m.character_id = 2
  AND m.move_type = 'special_moves'
ORDER BY f.sort_order;
```

---

### ⑨ sort_order の決め方

* `move_type` ごとにブロックを分けて採番することを推奨します。
* frameテーブルも同じ `sort_order` 範囲で管理すると並び順が統一されます。

| move_type | sort_order の範囲（目安） |
| :--- | :--- |
| `common_moves` | 100〜 |
| `normal_moves` | 1000〜 |
| `unique_attacks` | 2000〜 |
| `special_moves` | 3000〜 |
| `super_arts` | 4000〜 |
| `throws` | 5000〜 |

---

### ⑩ created_at / updated_at の取り扱い

* MySQLが自動でセット・更新します。手動入力禁止。
* CSVインポート時もこの2カラムは**列ごと除外**してください。

---

## 3. CSVインポートガイドライン

### CSVに含めるカラム（列順）

```
character_id, move_slug, move_type, name_jp, name_en,
command, parent_slug, drive_gauge, sa_level,
condition, overview, sort_order
```

> `id`, `created_at`, `updated_at` は**CSVに含めないこと**。

### NULL の記述方法

| 項目 | ルール |
| :--- | :--- |
| NULLにしたい列 | `\N` と記述 |
| `parent_slug` | 親技（派生元なし）は `\N` |
| `condition` | 条件なしは `\N` |
| `overview` | 解説なしは `\N` |
| `drive_gauge` | 消費なしは `0` |
| `sa_level` | SA以外は `0` |

---

## 4. インデックス設計

| インデックス名 | 対象カラム | 種別 | 用途 |
| :--- | :--- | :--- | :--- |
| PRIMARY | `id` | PRIMARY KEY | 主キー |
| `uq_char_move` | `character_id`, `move_slug` | UNIQUE | キャラ内でのslug重複防止 |
| `idx_character_id` | `character_id` | INDEX | キャラ別技一覧の高速化 |
| `idx_move_type` | `move_type` | INDEX | 技種別フィルタリング高速化 |
| `idx_parent_slug` | `parent_slug` | INDEX | 派生技取得の高速化 |
| `idx_sa_level` | `sa_level` | INDEX | SAレベルフィルタリング高速化 |

---

## 5. SQL定義

```sql
CREATE TABLE movelist (
    id             INT            NOT NULL AUTO_INCREMENT,
    character_id   INT            NOT NULL,
    move_slug      VARCHAR(100)   NOT NULL,
    move_type      ENUM('normal_moves', 'unique_attacks', 'special_moves', 'super_arts', 'throws', 'common_moves') NOT NULL,
    name_jp        VARCHAR(100)   NOT NULL,
    name_en        VARCHAR(100)   NOT NULL,
    command        VARCHAR(100)   NOT NULL,
    parent_slug    VARCHAR(100)            DEFAULT NULL,
    drive_gauge    VARCHAR(20)    NOT NULL DEFAULT '0',
    sa_level       VARCHAR(20)    NOT NULL DEFAULT '0',
    `condition`    VARCHAR(150)            DEFAULT NULL,
    overview       TEXT,
    sort_order     INT            NOT NULL,
    created_at     DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_char_move`    (`character_id`, `move_slug`),
    INDEX `idx_character_id`     (`character_id`),
    INDEX `idx_move_type`        (`move_type`),
    INDEX `idx_parent_slug`      (`parent_slug`),
    INDEX `idx_sa_level`         (`sa_level`),
    FOREIGN KEY (`character_id`) REFERENCES `characters`(`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 6. INSERT例

```sql
-- 必殺技（親技・バリアントはframeで管理するためmovelistは1レコード）
INSERT INTO movelist
    (character_id, move_slug, move_type, name_jp, name_en, command,
     parent_slug, drive_gauge, sa_level, condition, overview, sort_order)
VALUES
    (2, 'sand_blast', 'special_moves', 'サンドブラスト', 'Sand Blast', '236P',
     NULL, '2', '0', NULL,
     '前方へ拳圧による衝撃波を飛ばす技。離れた間合いのけん制や連係の繋ぎとして有効。',
     3100),

    (2, 'flash_knuckle', 'special_moves', 'フラッシュナックル', 'Flash Knuckle', '214P',
     NULL, '2', '0', NULL,
     '突進型の打撃必殺技。ジャスト入力で最大火力になる。SA3へのキャンセルも可能。',
     3200);

-- 派生技（parent_slug に親の move_slug を記述）
INSERT INTO movelist
    (character_id, move_slug, move_type, name_jp, name_en, command,
     parent_slug, drive_gauge, sa_level, condition, overview, sort_order)
VALUES
    (2, 'no_chaser', 'special_moves', 'ノーチェイサー', 'No Chaser', 'P',
     'avenger', '0', '0', 'アベンジャー中に', NULL, 3401),

    (2, 'ddt', 'special_moves', 'DDT', 'DDT', 'PP',
     'flash_knuckle', '1', '0', 'ODフラッシュナックル後に', NULL, 3301);

-- スーパーアーツ
INSERT INTO movelist
    (character_id, move_slug, move_type, name_jp, name_en, command,
     parent_slug, drive_gauge, sa_level, condition, overview, sort_order)
VALUES
    (2, 'vulcan_blast', 'super_arts', 'バルカンブラスト', 'Vulcan Blast', '236236P',
     NULL, '0', '1', NULL, NULL, 4100),
    (2, 'eraser', 'super_arts', 'イレイザー', 'Eraser', '214214P',
     NULL, '0', '2', NULL, NULL, 4200),
    (2, 'pale_rider', 'super_arts', 'ペイルライダー', 'Pale Rider', '236236K',
     NULL, '0', '3', NULL,
     '体力25%以下でCA版に強化される。',
     4300);

-- 共通技（特殊なdrive_gauge値の例）
INSERT INTO movelist
    (character_id, move_slug, move_type, name_jp, name_en, command,
     parent_slug, drive_gauge, sa_level, condition, overview, sort_order)
VALUES
    (2, 'drive_impact', 'common_moves', 'ドライブインパクト', 'Drive Impact: Muzzle Flash', 'HPHK',
     NULL, '1', '0', NULL, NULL, 100),
    (2, 'drive_parry', 'common_moves', 'ドライブパリィ', 'Drive Parry', 'MPMK',
     NULL, 'hold', '0', 'ボタンホールドで動作継続',
     'その場で構えを取り、相手のすべての打撃技を受け止める。',
     300),
    (2, 'parry_drive_rush', 'common_moves', 'ドライブラッシュ', 'Parry Drive Rush', '66',
     'drive_parry', '0.5', '0', 'ドライブパリィ中に', NULL, 400);
```