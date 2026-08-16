# matchup_guidesテーブル定義書 (Street Fighter 6 Strategy Site)

このテーブルは、各キャラクターへの技単位・状況別の詳しい対策テキストを管理します。
「matchup.php（キャラ対策）ページ」の状況別戦術解説・確定反撃補足・切り返し手段補足に使用されます。
1キャラクターに対して複数のレコードを `category` で分類して登録します。

---

## 1. カラム定義一覧

| カラム名 | 型 (SQL型) | 説明 | 入力ルール / 備考 | 具体例 |
| :--- | :--- | :--- | :--- | :--- |
| **id** | `INT` | 固有ID | **PRIMARY KEY / AUTO_INCREMENT**<br>手動入力禁止。CSVにも含めないこと。 | `1`, `2`... |
| **opponent_char_id** | `INT` | 対策対象キャラのID | **NOT NULL / FOREIGN KEY**<br>`characters.id` と一致させる。 | `3`（ジェイミー） |
| **category** | `ENUM` | 対策の分類 | **NOT NULL**。取りうる値は固定。下記参照。 | `summary`, `neutral` |
| **difficulty** | `TINYINT` | 対策の実行難易度 | **NOT NULL** / DEFAULT `1`。<br>1（初心者でも実行可能）〜5（上級者向け）で評価。 | `1`, `3`, `5` |
| **condition_tag** | `VARCHAR(50)` | 特定キャラ向け注釈タグ | **NULL許可**。<br>自分が使うキャラの条件に応じた補足を付与する場合に使用。<br>全キャラ共通の対策は `\N`（NULL）。 | `has_dp`, `is_grappler`, `\N` |
| **title** | `VARCHAR(150)` | 対策の見出し | **NOT NULL**。 | `波動拳を飛ばない`, `昇龍拳持ちはOD昇龍で割り込み可` |
| **content** | `TEXT` | 対策の本文 | **NULL許可**。**Markdown形式**。スペース2つ + `\n` で改行。<br>フレーム数値を交えた具体的な記述を推奨。 | `+3F有利なので4F技で暴れても相手の4F技と相打ちになる。` |
| **move_slug** | `VARCHAR(100)` | 関連技の識別子 | **NULL許可**。<br>特定の技への対策の場合に `frame.move_slug` と一致させる。<br>技に紐付かない解説は `\N`（NULL）。 | `hadoken`, `shoryuken`, `\N` |
| **sort_order** | `INT` | 表示順 | **NOT NULL**。省略不可。**100きざみ**推奨。 | `100`, `200` |
| **created_at** | `DATETIME` | 作成日時 | **NOT NULL** / DEFAULT `CURRENT_TIMESTAMP`。<br>自動セット。手動入力禁止。CSVにも含めないこと。 | `2025-06-01 12:00:00` |
| **updated_at** | `DATETIME` | 更新日時 | **NOT NULL** / DEFAULT `CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`。<br>自動更新。手動入力禁止。CSVにも含めないこと。 | `2025-06-10 09:30:00` |

---

## 2. 運用ルール・ガイドライン

### ① category の使い分け

| 値 | 表示セクション | 内容 | move_slug | 記述の深さ |
| :--- | :--- | :--- | :--- | :--- |
| `summary` | クイックサマリー | 試合前の3大重要ポイント（最大3件） | 基本NULL | 短く・結論のみ |
| `neutral` | 立ち回り | 間合い管理・距離の維持方針 | NULL可 | 距離感・有効技の根拠を含む |
| `pressure` | 連係・崩し対策 | 主要連係の逃げ方・暴れ所・読み合いの構造 | NULL可 | 読み合いの択を具体的に記述 |
| `punish` | 確定反撃リスト | frameの動的生成に対する手動補足テキスト | 必須 | 何F確定か・最大コンボへの言及 |
| `reversal` | 切り返し手段 | 無敵技・アーマー技への具体的な対処法 | 推奨 | 何F以内の連携で潰せるかなど |
| `oki` | 起き攻め対策 | 起き攻めパターンと対処法 | NULL可 | 各択への回答を具体的に記述 |
| `char_condition` | 固有能力対策 | 酔いレベル・風波ストック等への対策 | NULL可 | 状態ごとの対処を段階的に記述 |
| `gap` | 連係の隙間 | 特定連係への割り込み猶予フレームと割込み手段 | 推奨 | 何Fの隙があり何F技で割り込めるか |

---

### ② content の記述基準

**基本方針**
数値・フレームを交えた具体的な記述を必ず含めてください。「注意が必要」「対処しましょう」だけでは不十分です。

**category別の記述例**

```
-- punish（確定反撃補足）
弱昇龍拳ガード後は-23F。OD昇龍拳持ちキャラはリバーサルで確定。
持たないキャラは発生10F以内の技からコンボを入れること。

-- gap（連係の隙間）
ダブルインパクト(6HP~HP)の1段目ガード後は-3Fで不利だが、
2段目が出るまでに4Fの隙間がある。4F技の暴れで割り込み可能。

-- pressure（連係・読み合いの構造）
ドライブラッシュ後の2択：
・打撃（発生5F〜の攻め）→ ガード安定
・コマンド投げ → 後ろ歩きまたはジャンプで回避
距離が近いほど投げリーチが届くため、ラッシュを見たら後退を意識する。

-- char_condition（固有能力対策）
酔いレベル0-1：爆廻が使えないため中距離でも比較的安全。
酔いレベル2-3：爆廻（236HK）が解禁。前進技のため距離管理に注意。
酔いレベル4：最大火力状態。コンボダメージが約1.2倍になる。
```

---

### ② condition_tag の主な値

`condition_tag` は「自分が使うキャラがこの条件を満たす場合のみ表示する補足」に使用します。

| タグ | 意味 | 対象キャラ例 |
| :--- | :--- | :--- |
| `has_dp` | 無敵対空技（昇龍拳等）持ち | リュウ・ケン・ルーク・キャミィ等 |
| `is_grappler` | コマンド投げキャラ | ザンギエフ・マノン等 |
| `has_projectile` | 飛び道具持ち | リュウ・ガイル・DHalsim等 |
| `has_install` | 強化インストール技持ち | リュウ（電刃錬気）・本田（肩屋入り）等 |

> 全キャラ共通の対策（condition_tag不要）は `\N` を記述してください。

---

### ③ punish / reversal と frameテーブルの連携

`category = 'punish'` または `category = 'reversal'` のレコードは `move_slug` を使って frameテーブルの動的生成結果に補足テキストを付与します。

```
frameテーブル（guard_adv <= -4 の技）
    ↓ 動的生成
確定反撃リスト
    ↓ move_slug で紐付け
matchup_guides(category='punish') の content を補足テキストとして表示
```

`move_slug` を指定しない場合、確定反撃リストには技の硬直差とラベルのみが表示されます。

---

### ④ sort_order の採番方針

`category` ごとにブロックを分けて採番することを推奨します。

| category | sort_order の範囲（目安） |
| :--- | :--- |
| `summary` | 100〜300（最大3件） |
| `neutral` | 1000〜 |
| `pressure` | 2000〜 |
| `punish` | 3000〜 |
| `reversal` | 4000〜 |
| `oki` | 5000〜 |
| `char_condition` | 6000〜 |
| `gap` | 7000〜 |

---

### ⑤ created_at / updated_at の取り扱い

* MySQLが自動でセット・更新します。手動入力禁止。
* CSVインポート時もこの2カラムは**列ごと除外**してください。

---

## 3. CSVインポートガイドライン

### CSVに含めるカラム（列順）

```
opponent_char_id, category, difficulty, condition_tag,
title, content, move_slug, sort_order
```

> `id`, `created_at`, `updated_at` は**CSVに含めないこと**。

### NULL の記述方法

| 項目 | ルール |
| :--- | :--- |
| `condition_tag` | 全キャラ共通の解説は `\N` |
| `content` | 見出しのみで本文なしの場合は `\N` |
| `move_slug` | 特定技に紐付かない解説は `\N` |

---

## 4. インデックス設計

| インデックス名 | 対象カラム | 種別 | 用途 |
| :--- | :--- | :--- | :--- |
| PRIMARY | `id` | PRIMARY KEY | 主キー |
| `idx_opponent_char_id` | `opponent_char_id` | INDEX | キャラ別対策一覧の高速化 |
| `idx_category` | `category` | INDEX | category別フィルタリング高速化 |
| `idx_condition_tag` | `condition_tag` | INDEX | タグ別フィルタリング高速化 |
| `idx_move_slug` | `move_slug` | INDEX | frame紐付けの高速化 |

---

## 5. SQL定義

```sql
CREATE TABLE matchup_guides (
    id                 INT            NOT NULL AUTO_INCREMENT,
    opponent_char_id   INT            NOT NULL,
    category           ENUM('summary','neutral','pressure','punish','reversal','oki','char_condition','gap') NOT NULL,
    difficulty         TINYINT        NOT NULL DEFAULT 1,
    condition_tag      VARCHAR(50)             DEFAULT NULL,
    title              VARCHAR(150)   NOT NULL,
    content            TEXT,
    move_slug          VARCHAR(100)            DEFAULT NULL,
    sort_order         INT            NOT NULL,
    created_at         DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at         DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    INDEX `idx_opponent_char_id` (`opponent_char_id`),
    INDEX `idx_category`         (`category`),
    INDEX `idx_condition_tag`    (`condition_tag`),
    INDEX `idx_move_slug`        (`move_slug`),
    FOREIGN KEY (`opponent_char_id`) REFERENCES `characters`(`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 6. INSERT例

```sql
-- ジェイミー対策：summaryカテゴリ（3大重要ポイント）
INSERT INTO matchup_guides
    (opponent_char_id, category, difficulty, condition_tag,
     title, content, move_slug, sort_order)
VALUES
    (3, 'summary', 1, NULL,
     '酔いレベルを上げさせない',
     '積極的に攻めてターンを渡さずレベルアップの機会を与えないことが最優先。',
     NULL, 100),

    (3, 'summary', 2, NULL,
     'レベル2以降の爆廻に注意',
     '爆廻（236HK）はレベル2から解禁される突進技。中距離での前進に要注意。',
     NULL, 200),

    (3, 'summary', 3, NULL,
     '絶唱魔身（SA2）の発動を確認する',
     'SA2発動後は酔いレベル4相当になり火力が大幅上昇。ゲージ管理に注意。',
     NULL, 300);

-- ジェイミー対策：char_conditionカテゴリ（固有能力対策）
INSERT INTO matchup_guides
    (opponent_char_id, category, difficulty, condition_tag,
     title, content, move_slug, sort_order)
VALUES
    (3, 'char_condition', 2, NULL,
     'レベル管理の優先度',
     'レベル0-1：使用できる必殺技が少なく比較的対処しやすい。  \nレベル2-3：爆廻が解禁され選択肢が増加する。  \nレベル4：最大火力状態。長時間の被攻め展開を避ける。',
     NULL, 6100);

-- リュウ対策：punishカテゴリ（確定反撃補足）
INSERT INTO matchup_guides
    (opponent_char_id, category, difficulty, condition_tag,
     title, content, move_slug, sort_order)
VALUES
    (1, 'punish', 3, 'has_dp',
     '弱昇龍拳ガード後の確定反撃',
     '弱昇龍拳をガードすると-23F。OD昇龍拳を持つキャラならリバーサルで確定。持たないキャラは最大コンボを入れること。',
     'shoryuken', 3100);
```