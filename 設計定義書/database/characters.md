# characters テーブル定義書 (Street Fighter 6 Strategy Site)

このテーブルは、サイトに登場する全キャラクターの基本ステータスと管理情報を格納します。
「キャラクター選択画面の表示」「個別プロフィールの生成」「コンボデータとの紐付け」に使用されます。

---

## 1. カラム定義一覧

| カラム名 | 型 (SQL型) | 説明 | 入力ルール / 備考 | 具体例 |
| :--- | :--- | :--- | :--- | :--- |
| **id** | `INT` | 固有ID | **PRIMARY KEY / AUTO_INCREMENT**<br>システムが自動で振る連番。手動入力禁止。CSVにも含めないこと。 | `1`, `2`... |
| **char_slug** | `VARCHAR(50)` | 識別子 | **NOT NULL / UNIQUE** / 小文字英字のみ。<br>画像ファイル名（luke.png）やURLに使用。 | `luke`, `akuma` |
| **name_jp** | `VARCHAR(100)` | 日本語名 | **NOT NULL**。サイト表示用の正式名称（日本語）。 | `ルーク`, `豪鬼` |
| **name_en** | `VARCHAR(100)` | 英語名 | **NOT NULL**。サイト表示・デザイン用の名称（英語）。 | `LUKE`, `AKUMA` |
| **battle_type** | `ENUM` | タイプ | **NOT NULL**。取りうる値は固定：<br>`スタンダード` / `パワー` / `スピード` / `トリッキー` | `スタンダード` |
| **range_type** | `ENUM` | 間合い | **NOT NULL**。取りうる値は固定：<br>`ショートレンジ` / `ミドルレンジ` / `ロングレンジ` | `ミドルレンジ` |
| **difficulty** | `ENUM` | 操作難易度 | **NOT NULL**。取りうる値は固定：<br>`イージー` / `ノーマル` / `ハード` | `ノーマル` |
| **vitality** | `INT` | 体力値 | **NOT NULL** / DEFAULT `10000`。整数で入力。 | `10000`, `9000` |
| **profile_text** | `TEXT` | 紹介文 | NULL許可。**Markdown形式**で格納。<br>改行はスペース2つ + `\n`（`  \n`）を付与。<br>スペース2つのみでは改行されないので注意。<br>表示時は `Parsedown.php` でHTML変換する。 | `民間警備会社の...  \n余暇に楽しむのは...` |
| **season** | `TINYINT` | シーズン | **NOT NULL** / DEFAULT `0`。<br>初期キャラは `0`、シーズン1追加なら `1` を指定。 | `0`, `1`, `2` |
| **announce_date** | `DATE` | 発表日 | **NULL許可**。YYYY-MM-DD形式。初期キャラはNULL。<br>日程未定の場合もNULL（`release_season` を使用）。 | `2024-06-07` |
| **announce_event** | `VARCHAR(100)` | 発表場所 | **NULL許可**。イベント名など。初期キャラはNULL。 | `Summer Game Fest 2024` |
| **release_date** | `DATE` | 実装日（確定） | **NULL許可**。YYYY-MM-DD形式。<br>確定日が判明した時点で入力。未確定の間はNULL。 | `2024-09-24` |
| **release_season** | `VARCHAR(50)` | 実装シーズン（未確定） | **NULL許可**。`release_date` が未確定の間、実装時期の目安を文字列で格納。<br>`release_date` が確定したら NULL に更新する。 | `2025年夏`, `Season3前半` |
| **sort_order** | `INT` | 表示順 | **NOT NULL**。省略不可・必ず明示的に指定すること。<br>数値が小さいほど先に表示される。**100きざみの数値**（100, 200, 300...）を推奨。 | `100`, `200` |
| **created_at** | `DATETIME` | 作成日時 | **NOT NULL** / DEFAULT `CURRENT_TIMESTAMP`。<br>レコード作成時に自動セット。手動入力禁止。CSVにも含めないこと。 | `2025-06-01 12:00:00` |
| **updated_at** | `DATETIME` | 更新日時 | **NOT NULL** / DEFAULT `CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`。<br>レコード更新時に自動更新。手動入力禁止。CSVにも含めないこと。 | `2025-06-10 09:30:00` |

---

## 2. 運用ルール・ガイドライン

### ① 日付データの取り扱い（初期キャラ vs 追加キャラ）

* **初期キャラ (Season 0)**:
  `announce_date`, `announce_event`, `release_date`, `release_season` はすべて **NULL** とします。
  PHP側でNULLであれば「初期メンバー」というラベルを自動表示する運用にします。

* **追加キャラ（発表済み・日程確定）**:
  `release_date` に確定日を入力。`release_season` は NULL とします。

* **追加キャラ（発表済み・日程未確定）**:
  `release_date` は NULL のまま、`release_season` に「2025年夏」などの文字列を入力します。
  日程が確定したら `release_date` を入力し、`release_season` を NULL に更新してください。

PHP側での表示分岐イメージ：

```php
if ($char['release_date']) {
    echo date('Y年m月d日', strtotime($char['release_date'])); // 例：2025年08月05日
} elseif ($char['release_season']) {
    echo $char['release_season'];                             // 例：2025年夏
} else {
    echo '初期メンバー';
}
```

### ② sort_order（表示順）の決め方（ギャップ法）
* 後から「リュウの隣にケンを置きたい」といった要望に対応するため、最初から **100, 200, 300...** と間隔を開けて設定してください。
* 間に差し込みたい場合は `150` や `250` という数値を使うことで、既存データの書き換えを回避します。
* **`sort_order` にデフォルト値はありません。INSERT時に必ず明示的に指定してください。**
  未指定のままだとエラーになるよう設計することで、表示順の設定漏れを防ぎます。

### ③ char_slug の命名規則
* すべて **小文字** で記述してください。
* スペースは含めず、必要であればハイフン（`-`）を使用します（例：`m-bison`）。
* このスラグは `/assets/images/chars/` フォルダ内の画像名と一致させる必要があります。

### ④ ENUMカラムの値追加について
* `battle_type`, `range_type`, `difficulty` の取りうる値は**ENUM型で固定**しています。
* ゲームのアップデートなどで新分類が追加された場合は、`ALTER TABLE` によるENUM定義の変更が必要です。
  変更時はステージング環境で動作確認を行ってから本番に適用してください。

### ⑤ profile_text の記述形式（Markdown + Parsedown.php）

#### なぜMarkdownで保存するのか

| 方式 | 問題点 |
| :--- | :--- |
| 生テキスト + `nl2br()` | 改行のみ対応。将来的な装飾（太字・リストなど）に対応不可 |
| HTMLをDBに直接保存 | XSSリスクが高く、DBの可読性も損なわれる |
| **Markdownで保存 + Parsedown** | 安全・柔軟・将来性あり ✅ |

#### 改行の記述ルール

DBのTEXTカラムに1行の文字列として格納する場合、改行文字は自動で挿入されません。
**スペース2つ + `\n`（`  \n`）をセットで記述する**必要があります。

| 場面 | 必要な記述 | 理由 |
| :--- | :--- | :--- |
| `.md` ファイル | スペース2つ + Enter | EnterキーがそのままM`\n`になる |
| DBのTEXTカラム | スペース2つ + `\n` | 改行文字を明示しないと1行のまま |

```
-- DBに保存する値のイメージ（行末の「  \n」がスペース2つ + 改行文字）

民間警備会社のコントラクター。米軍特殊部隊上がりで、初心者に総合格闘技を指導している。  \n余暇に楽しむのはスナック菓子とゲーム、格闘。  \n勝負事となると勝ちは決して譲らない
```

#### PHP側の実装

```php
require 'lib/Parsedown.php';

$Parsedown = new Parsedown();
$Parsedown->setSafeMode(true); // XSS対策：必ずONにすること

// DBから取得したMarkdownテキストをHTMLに変換して出力
echo $Parsedown->text($character['profile_text']);
```

> **`setSafeMode(true)` は必須です。** DBに万が一悪意あるHTMLタグが混入していた場合でも自動でエスケープされます。

### ⑥ created_at / updated_at の取り扱い
* どちらも **MySQLが自動でセット・更新** します。アプリケーション側からの手動入力は禁止です。
* CSVインポート時もこの2カラムは**列ごと除外**してください。
* `updated_at` はキャッシュの鮮度確認やデバッグ時のトレースに活用できます。

---

## 3. CSVインポートガイドライン

### CSVに含めるカラム（列順）

```
char_slug, name_jp, name_en, battle_type, range_type, difficulty,
vitality, profile_text, season,
announce_date, announce_event, release_date, release_season,
sort_order
```

> `id`, `created_at`, `updated_at` は**CSVに含めないこと**。MySQLが自動で処理します。

### 注意事項

| 項目 | ルール |
| :--- | :--- |
| `range_type` の値 | `ショートレンジ`（`ショート` は不可。ENUMエラーになる） |
| 空のNULL項目 | 列を空のまま（カンマだけ）でOK。トリガーが自動でNULLに変換する |
| `\N` の使用 | 空欄でもトリガーが処理するため不要。ただし記述しても問題なし |
| `release_date` と `release_season` | どちらか一方のみ入力。両方空欄も可（初期キャラ） |
| `profile_text` の改行 | スペース2つ + `\n`（`  \n`）で記述 |

---

## 4. インデックス設計

| インデックス名 | 対象カラム | 種別 | 用途 |
| :--- | :--- | :--- | :--- |
| PRIMARY | `id` | PRIMARY KEY | 主キー |
| `uq_char_slug` | `char_slug` | UNIQUE | スラグの重複防止・URL検索の高速化 |
| `idx_season` | `season` | INDEX | シーズン別絞り込みの高速化 |

> **補足**: キャラクター総数は50件未満であるため、現時点でインデックスの効果は限定的です。
> サイト規模の拡大やクエリの複雑化に備えた先行設定として位置づけてください。

---

## 5. SQL定義

```sql
CREATE TABLE characters (
    id             INT           NOT NULL AUTO_INCREMENT,
    char_slug      VARCHAR(50)   NOT NULL,
    name_jp        VARCHAR(100)  NOT NULL,
    name_en        VARCHAR(100)  NOT NULL,
    battle_type    ENUM('スタンダード', 'パワー', 'スピード', 'トリッキー') NOT NULL,
    range_type     ENUM('ショートレンジ', 'ミドルレンジ', 'ロングレンジ')   NOT NULL,
    difficulty     ENUM('イージー', 'ノーマル', 'ハード')                   NOT NULL,
    vitality       INT           NOT NULL DEFAULT 10000,
    profile_text   TEXT,
    season         TINYINT       NOT NULL DEFAULT 0,
    announce_date  DATE                   DEFAULT NULL,
    announce_event VARCHAR(100)           DEFAULT NULL,
    release_date   DATE                   DEFAULT NULL,
    release_season VARCHAR(50)            DEFAULT NULL,
    sort_order     INT           NOT NULL,
    created_at     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_char_slug` (`char_slug`),
    INDEX `idx_season` (`season`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### トリガー定義

CSVインポート時に空文字列 `''` が渡された場合でも、自動でNULLに変換するトリガーです。
INSERT・UPDATE どちらの操作にも対応しています。

```sql
-- INSERT時に空文字をNULLに変換
DELIMITER //
CREATE TRIGGER trg_characters_null_before_insert
BEFORE INSERT ON characters
FOR EACH ROW
BEGIN
    IF NEW.announce_date  = '' THEN SET NEW.announce_date  = NULL; END IF;
    IF NEW.announce_event = '' THEN SET NEW.announce_event = NULL; END IF;
    IF NEW.release_date   = '' THEN SET NEW.release_date   = NULL; END IF;
    IF NEW.release_season = '' THEN SET NEW.release_season = NULL; END IF;
    IF NEW.profile_text   = '' THEN SET NEW.profile_text   = NULL; END IF;
END //
DELIMITER ;

-- UPDATE時にも同様に変換
DELIMITER //
CREATE TRIGGER trg_characters_null_before_update
BEFORE UPDATE ON characters
FOR EACH ROW
BEGIN
    IF NEW.announce_date  = '' THEN SET NEW.announce_date  = NULL; END IF;
    IF NEW.announce_event = '' THEN SET NEW.announce_event = NULL; END IF;
    IF NEW.release_date   = '' THEN SET NEW.release_date   = NULL; END IF;
    IF NEW.release_season = '' THEN SET NEW.release_season = NULL; END IF;
    IF NEW.profile_text   = '' THEN SET NEW.profile_text   = NULL; END IF;
END //
DELIMITER ;
```

> **補足**: このトリガーにより、CSVの空欄に `\N` を記述しなくても自動でNULLに変換されます。ただし `\N` を使う運用を維持しても問題ありません。

---

## 6. INSERT例

```sql
-- 初期キャラ（Season 0）：日付系・release_seasonはすべてNULL
INSERT INTO characters
    (char_slug, name_jp, name_en, battle_type, range_type, difficulty,
     vitality, profile_text, season, sort_order)
VALUES
    (
        'ryu', 'リュウ', 'RYU', 'スタンダード', 'ミドルレンジ', 'ノーマル', 10000,
        '真の強さを求め修行を続ける格闘家。  \n礼儀正しく誠実な性格で、自分より強い相手と闘うために世界を旅する。',
        0, 1100
    );

-- 追加キャラ（release_date 確定済み）：release_season は NULL
INSERT INTO characters
    (char_slug, name_jp, name_en, battle_type, range_type, difficulty,
     vitality, profile_text, season,
     announce_date, announce_event, release_date, release_season, sort_order)
VALUES
    (
        'terry', 'テリー', 'TERRY', 'スタンダード', 'ミドルレンジ', 'ノーマル', 10000,
        '腕を磨くために世界をさすらい、闘い続ける熱いファイター。',
        2, '2024-06-07', 'Summer Game Fest 2024', '2024-09-24', NULL, 2400
    );

-- 追加キャラ（release_date 未確定）：release_season に時期の目安を入力
INSERT INTO characters
    (char_slug, name_jp, name_en, battle_type, range_type, difficulty,
     vitality, profile_text, season,
     announce_date, announce_event, release_date, release_season, sort_order)
VALUES
    (
        'newcomer', '新キャラ', 'NEW CHAR', 'パワー', 'ミドルレンジ', 'ノーマル', 10000,
        '未公開。',
        3, '2025-06-07', 'Summer Game Fest 2025', NULL, '2025年冬', 3000
    );
```