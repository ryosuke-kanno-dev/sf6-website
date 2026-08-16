# matchupテーブル定義書 (Street Fighter 6 Strategy Site)

このテーブルは、各キャラクターの対策概要・対戦前確認事項・対策難易度を管理します。
「matchup.php（キャラ対策）ページ」のクイックサマリーセクションで使用されます。
1キャラクターにつき1レコードを登録します。

---

## 1. カラム定義一覧

| カラム名 | 型 (SQL型) | 説明 | 入力ルール / 備考 | 具体例 |
| :--- | :--- | :--- | :--- | :--- |
| **id** | `INT` | 固有ID | **PRIMARY KEY / AUTO_INCREMENT**<br>手動入力禁止。CSVにも含めないこと。 | `1`, `2`... |
| **character_id** | `INT` | 対策対象キャラのID | **NOT NULL / FOREIGN KEY / UNIQUE**<br>`characters.id` と一致させる。<br>1キャラ1レコードのためUNIQUE制約あり。 | `3`（ジェイミー） |
| **matchup_difficulty** | `TINYINT` | 対策難易度（5段階） | **NOT NULL** / DEFAULT `3`。<br>1（簡単）〜5（難しい）で評価。 | `1`, `3`, `5` |
| **has_reversal** | `TINYINT(1)` | 無敵技フラグ | **NOT NULL** / DEFAULT `0`。<br>`1` = 無敵対空・無敵切り返し技あり。<br>PHP側でバッジ表示に使用。 | `0`, `1` |
| **has_projectile** | `TINYINT(1)` | 飛び道具フラグ | **NOT NULL** / DEFAULT `0`。<br>`1` = 飛び道具あり。 | `0`, `1` |
| **has_command_grab** | `TINYINT(1)` | コマンド投げフラグ | **NOT NULL** / DEFAULT `0`。<br>`1` = コマンド投げあり。 | `0`, `1` |
| **has_install** | `TINYINT(1)` | 強化インストールフラグ | **NOT NULL** / DEFAULT `0`。<br>`1` = 電刃錬気・肩屋入り等の強化インストール技あり。 | `0`, `1` |
| **key_points** | `TEXT` | 対戦前の注意点 | **NULL許可**。**Markdown形式**。箇条書き推奨。<br>対戦前に必ず意識する3〜5点を箇条書きで記述。<br>フラグ情報の補足や立ち回りの基本方針を含める。 | `- 波動拳を無闇に飛ばない  \n- 昇龍拳持ちのため攻め継続には注意  \n- 近距離は相手有利` |
| **overview** | `TEXT` | キャラ概要・立ち回り傾向 | **NULL許可**。**Markdown形式**。スペース2つ + `\n` で改行。<br>キャラの立ち回り傾向・強みと弱みの文章説明。<br>箇条書きの注意点は `key_points` に分離して記述。 | `波動拳による飛び道具戦と昇龍拳の対空が軸のオーソドックスなキャラ。  \n中距離を維持して波動拳を撒きながら相手の動きを制限してくる。` |
| **created_at** | `DATETIME` | 作成日時 | **NOT NULL** / DEFAULT `CURRENT_TIMESTAMP`。<br>自動セット。手動入力禁止。CSVにも含めないこと。 | `2025-06-01 12:00:00` |
| **updated_at** | `DATETIME` | 更新日時 | **NOT NULL** / DEFAULT `CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`。<br>自動更新。手動入力禁止。CSVにも含めないこと。 | `2025-06-10 09:30:00` |

---

## 2. 運用ルール・ガイドライン

### ① matchup_difficulty の基準

| 値 | 意味 | 目安 |
| :--- | :--- | :--- |
| `1` | 非常に簡単 | 固有能力なし・シンプルな立ち回り |
| `2` | 簡単 | 固有能力があるが影響が少ない |
| `3` | 普通 | 標準的な対策難易度（デフォルト） |
| `4` | 難しい | 固有能力が強力・択が多い |
| `5` | 非常に難しい | 固有能力が複雑・状況判断が多い |

---

### ② フラグカラムの使い方

フラグカラムはPHP側でバッジ・アイコン表示に使用します。

```php
// 対戦前確認事項のバッジ表示例
if ($matchup['has_reversal'])     echo '<span class="badge">無敵技あり</span>';
if ($matchup['has_projectile'])   echo '<span class="badge">飛び道具あり</span>';
if ($matchup['has_command_grab']) echo '<span class="badge">コマンド投げあり</span>';
if ($matchup['has_install'])      echo '<span class="badge">強化インストールあり</span>';
```

詳細な無敵技・飛び道具の対処法は `matchup_guides` テーブルの `category = 'reversal'` / `category = 'neutral'` に記述します。

---

### ③ key_points と overview の使い分け

| カラム | 形式 | 内容 |
| :--- | :--- | :--- |
| `key_points` | 箇条書き | 対戦前に必ず意識する3〜5点。「〜に注意」「〜しない」など行動指針を短く列挙 |
| `overview` | 文章 | キャラの立ち回り傾向・強みと弱みの説明。「なぜそのような立ち回りになるのか」の背景 |

```
-- key_points の記述例
- 波動拳を無闇に飛ばない（強波動はガードしても五分以上）
- 昇龍拳持ちのため固め継続は慎重に
- 電刃錬気後は特定の技が強化されることを意識する

-- overview の記述例
波動拳による飛び道具戦と昇龍拳の対空が軸のオーソドックスなキャラ。
中距離を維持しながら波動拳を撒き、ジャンプには昇龍拳で対空してくる。
電刃錬気でさらに技が強化されるため残体力管理が重要。
```

---

### ④ created_at / updated_at の取り扱い

* MySQLが自動でセット・更新します。手動入力禁止。
* CSVインポート時もこの2カラムは**列ごと除外**してください。

---

## 3. CSVインポートガイドライン

### CSVに含めるカラム（列順）

```
character_id, matchup_difficulty,
has_reversal, has_projectile, has_command_grab, has_install,
key_points, overview
```

> `id`, `created_at`, `updated_at` は**CSVに含めないこと**。

### NULL の記述方法

| 項目 | ルール |
| :--- | :--- |
| `key_points` | まだ記述なしの場合は `\N` |
| `overview` | まだ記述なしの場合は `\N` |
| `matchup_difficulty` | 省略不可。未確定の場合はデフォルト値 `3` を記述 |
| フラグカラム4列 | `0` または `1` を必ず記述（省略不可） |

---

## 4. インデックス設計

| インデックス名 | 対象カラム | 種別 | 用途 |
| :--- | :--- | :--- | :--- |
| PRIMARY | `id` | PRIMARY KEY | 主キー |
| `uq_character_id` | `character_id` | UNIQUE | 1キャラ1レコードの保証 |
| `idx_has_reversal` | `has_reversal` | INDEX | 無敵技持ちキャラのフィルタリング |
| `idx_has_projectile` | `has_projectile` | INDEX | 飛び道具持ちキャラのフィルタリング |

---

## 5. SQL定義

```sql
CREATE TABLE matchup (
    id                   INT          NOT NULL AUTO_INCREMENT,
    character_id         INT          NOT NULL,
    matchup_difficulty   TINYINT      NOT NULL DEFAULT 3,
    has_reversal         TINYINT(1)   NOT NULL DEFAULT 0,
    has_projectile       TINYINT(1)   NOT NULL DEFAULT 0,
    has_command_grab     TINYINT(1)   NOT NULL DEFAULT 0,
    has_install          TINYINT(1)   NOT NULL DEFAULT 0,
    key_points           TEXT,
    overview             TEXT,
    created_at           DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at           DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_character_id`  (`character_id`),
    INDEX `idx_has_reversal`      (`has_reversal`),
    INDEX `idx_has_projectile`    (`has_projectile`),
    FOREIGN KEY (`character_id`) REFERENCES `characters`(`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 6. INSERT例

```sql
-- リュウ
INSERT INTO matchup
    (character_id, matchup_difficulty,
     has_reversal, has_projectile, has_command_grab, has_install,
     key_points, overview)
VALUES (
    1, 3,
    1, 1, 0, 1,
    '- 波動拳を無闇に飛ばない（強波動はガードしても-2F）  \n- 昇龍拳があるため固め継続は慎重に  \n- 電刃錬気後は波動拳・波掌撃が強化される  \n- 中距離での牽制戦が主戦場',
    '波動拳による飛び道具戦と昇龍拳の対空が軸のオーソドックスなキャラ。  \n中距離を維持しながら波動拳を撒き、ジャンプには昇龍拳で対空してくる。  \n電刃錬気を溜めると技が強化されるため残体力管理が重要。'
);

-- ジェイミー
INSERT INTO matchup
    (character_id, matchup_difficulty,
     has_reversal, has_projectile, has_command_grab, has_install,
     key_points, overview)
VALUES (
    3, 4,
    0, 0, 0, 1,
    '- 酔いレベルを上げさせない（積極的に攻めてターンを渡さない）  \n- レベル2以降の爆廻（236HK）に注意  \n- SA2絶唱魔身の発動でレベル4相当になる  \n- 無敵技を持たないため固めに強い',
    '酔いレベルが上がるほど使用できる技が増え火力が上昇する特殊なキャラ。  \nレベル0-1は選択肢が少なく比較的対処しやすいが、レベル2以降は爆廻が解禁されコンボ火力が大幅に上昇する。'
);
```