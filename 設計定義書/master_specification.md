# SF6攻略サイト Webアプリケーション マスター統合仕様書 (Master Specification)

> **このドキュメントについて**  
> 本ファイルは、`設計定義書` フォルダ配下に分散していたすべての設計・仕様情報（プロジェクト概要、技術スタック、ディレクトリ構造、全8ページの役割とビュー・データソース関係、MySQLデータベース全テーブル定義、静的JSON構造、共通モジュール、デザインガイドライン）を1つに集約した**統合マスター仕様書**です。  
> **AIアシスタントや共同開発者にこの1ファイル（`master_specification.md`）を共有するだけで、Webサイト全体の構成・実装仕様・データ連携が即座に共有・理解できます。**

---

## 1. プロジェクト概要・コンセプト

### 1-1. プロジェクト名 & コンセプト
* **プロジェクト名**: SF6 攻略・上達ガイド（SF6 Strategy Guide）
* **コンセプト**: 「初心者がマスターを目指し、特定キャラ（豪鬼）を極めるまでの成長を支援するデータ駆動型攻略サイト」
* **ターゲット層**:
  - SF6を始めたばかりの初心者（デバイス選び、操作タイプ、ゲームシステムの理解）
  - ランクマッチで伸び悩む中級者（効率的な練習メニュー、実戦的コンボ、キャラ対策）
  - 詳細データを求める上級者（フレームデータ、技の確定反撃、マニアックなセットアップ）
* **開発環境**: XAMPP (Apache + MySQL / PHP 8+)

### 1-2. 技術スタック（Tech Stack）
| 分類 | 技術・ライブラリ | 用途・詳細 |
| --- | --- | --- |
| **サーバーサイド** | PHP 8+ (ピュアPHP) | フロントコントローラー、ルーティング、データバインディング |
| **データベース** | MySQL (PDO接続) | キャラクター情報、コンボレシピ、フレームデータ等の動的データ |
| **フロントエンド** | Vanilla CSS / JavaScript | 自作デザインシステム（CSS Variables）、レスポンシブ、リアルタイムインタラクション |
| **Markdown処理** | `Parsedown.php` | Markdown記事の動的HTMLパース（`setSafeMode(true)`適用） |
| **コマンド変換** | `command_converter.php` | コマンド文字列（例: `236P`）のボタン/方向キーアイコン画像自動置換 |
| **ウェブサーバー** | Apache (`.htaccess`) | クリーンURLルーティング、セキュリティ制御 |

---

## 2. システムアーキテクチャ & ディレクトリ構成

### 2-1. フロントコントローラーパターンの採用
セキュリティと保守性を高めるため、外部ブラウザからアクセス可能な領域を `public/` フォルダのみに制限する**フロントコントローラーパターン**を採用しています。  
すべてのURLリクエストは `.htaccess` によって `public/index.php` に集約され、裏側で `src/pages/` 配下の適切なページロジックを呼び出します。

### 2-2. ディレクトリ構造
```text
SF6_WebSite/ (プロジェクトルート)
├── public/                    # ドキュメントルート（公開領域）
│   ├── index.php              # フロントコントローラー（すべてのリクエストを処理）
│   ├── css/                   # 共通CSS、ページ固有CSS
│   ├── img/                   # 画像ファイル
│   ├── js/                    # JSファイル
│   └── videos/                # 動画ファイル
├── src/                       # アプリケーションロジック（非公開領域）
│   ├── pages/                 # ページコントローラー群 (home.php, combo.php 等)
│   ├── includes/              # ヘッダー/フッター、DB接続設定、共通関数群
│   │   └── functions/         # db_helpers.php, command_converter.php 等
│   ├── sections/              # 各ページのHTMLビューコンポーネント
│   │   ├── _shared/           # char_select.php (共通キャラ選択UI)
│   │   ├── home/, guide/ 等
│   └── lib/                   # 外部ライブラリ (Parsedown.php)
├── data/                      # 静的JSONデータ群 (glossary.json, training_menus.json 等)
├── sql/                       # テーブル定義・初期データSQLファイル
├── 設計定義書/                # 仕様・設計ドキュメント群 (本ファイル含む)
└── .htaccess                  # URLリライトおよびルーティング設定
```

### 2-3. URLルーティング & パス管理
* **クリーンURL**: `.htaccess` により `https://example.com/combo?char=akuma` のように `.php` 拡張子を露出させない設計。
* **堅牢なパス管理**: PHP側で定数（`DATA_PATH`, `SRC_PATH` 等）を定義し、HTML側では `<base href="/">` を活用することで、相対パス崩れやリンク切れを防止。

---

## 3. 全ページ一覧 & データソース対応表（マスターマトリクス）

サイトは目的別の全8ページで構成されています。

| URLスラッグ | ページ名 | 主な目的 | 呼び出されるビュー (`src/sections/`) | 主なデータソース |
| --- | --- | --- | --- | --- |
| `/` (`/home`) | 攻略トップ | 玄関口。最新情報・主要コンテンツへの導線 | `home/hero.php`, `home/quick_nav.php` | JSON (`site_info.json`) |
| `/guide` | スタートガイド | 初心者向け導入（設定・操作タイプ） | `guide/getting_started.php` 等 | JSON (`guide.json`) |
| `/glossary` | 用語集 | 格ゲー用語・システム用語の辞書 | `glossary/` | JSON (`glossary.json`) |
| `/roadmap` | 上達ロードマップ | ランク別の成長指針と練習への誘導 | `roadmap/` | Markdown / JSON |
| `/training` | トレモ実践 | 動画・レコード設定付きの練習メニュー | `training/` | JSON (`training_menus.json`) |
| `/combo` | コンボ集 | 全キャラ対応のコンボ検索・閲覧 | `_shared/char_select.php`, `combo/char_detail.php` | **MySQL** (`characters`, `combos`, `movelist`) |
| `/matchup` | キャラ対策 | 相手キャラの対策・確反・フレームデータ | `_shared/char_select.php`, `matchup/char_detail.php` | **MySQL** (`characters`, `frame`, `matchup`, `matchup_guides`) |
| `/akuma` | 豪鬼特設ページ | 豪鬼専用の深掘り・セットアップ解説 | `akuma/` | **MySQL** + **JSON** |

---

## 4. 各ページ詳細仕様 & データフロー

### 4-1. index.php (攻略トップ)
* **目的**: サイト全体のハブ。全コンテンツへのクイックアクセスを提供。
* **データ構造**: `data/site_info.json` から更新履歴やお知らせを取得して表示。

### 4-2. guide.php (スタートガイド)
* **目的**: 初心者が最初に読書・設定すべき情報を集約（クラシック/モダン比較、デバイス推奨等）。
* **データ構造**: 静的なHTMLセクション + JSONによるチュートリアルデータ。

### 4-3. glossary.php (用語集)
* **目的**: 専門用語（「キャンセル」「フレーム」「ドライブゲージ」等）を五十音順（あ〜わ行）で検索・閲覧。
* **データ構造**: `data/glossary.json`（用語名、読み、カテゴリ、解説テキスト、関連用語）。

### 4-4. roadmap.php (上達法・ロードマップ)
* **目的**: ビギナー〜マスターまでの各ランク帯における課題と練習ステップを可視化。
* **データ構造**: 読み物部分は Markdown テキスト、練習項目は `training.php` へのリンク。

### 4-5. training.php (トレモ実践)
* **目的**: トレーニングモードの具体的なダミー設定（レコード設定）と意識するポイントの提示。
* **データ構造**: `data/training_menus.json` (メニュー名、難易度、ダミー設定、解説、動画URL)。

### 4-6. combo.php (コンボ集)
* **目的**: キャラごとの「実戦的」コンボレシピを高速検索。
* **データフロー**:
  1. `?char=` なし ➔ `_shared/char_select.php` （キャラ選択一覧を表示）。
  2. `?char=akuma` ➔ `combo/char_detail.php` で `combos` テーブルより対象キャラのコンボ一覧を取得。
  3. レシピ文字列（例: `236P > 623HP`）を `command_converter.php` で矢印・ボタン画像へ自動変換。

### 4-7. matchup.php (キャラ対策)
* **目的**: 対戦相手キャラの弱点、立ち回り、確定反撃（確反）、フレームデータを閲覧。
* **データフロー**:
  1. `?char=luke` ➔ `matchup/char_detail.php` を呼び出し。
  2. `matchup` & `matchup_guides` テーブルから対策文章・コラムを取得。
  3. `frame` テーブルからガード時マイナスフレーム技を抽出し、「確定反撃リスト」として自動バインド。
  4. アコーディオンUIで長い対策テキストを折りたたみ表示。

### 4-8. akuma.php (豪鬼特設ページ)
* **目的**: 豪鬼メインプレイヤー向け特化ページ（専用セットアップ、SA判断、フレーム活用）。
* **データフロー**:
  `matchup.php` で使用している DB データ（豪鬼のフレームデータ等）を流用・連携しつつ、豪鬼独自の戦略・コンボを補加して表示。

---

## 5. データベース (MySQL) 完全設計書

データベース名: `sf6`  
全テーブルは `character_id`（外部キー）を介して `characters` テーブルとリレーションを持っています。

### 5-1. ER図・テーブル関係
```text
characters (1)  [ID / char_slug / 日本語名 / 英語名 / 体力 / ステータス]
  ├── combos (N)         [character_id → characters.id] (コンボレシピ/ダメージ/難易度)
  ├── movelist (N)       [character_id → characters.id] (技名/コマンド記法)
  ├── frame (N)          [character_id → characters.id] (発生/ガード硬直/判定)
  ├── matchup (N)        [character_id → characters.id] (対戦キャラ基本対策)
  └── matchup_guides (N) [matchup_id  → matchup.id]    (詳細対策コラム/画像)
```

### 5-2. テーブル定義詳細

#### ① `characters` テーブル (キャラクター基本情報)
| カラム名 | 型 | 制約 / 備考 | 説明 |
| --- | --- | --- | --- |
| `id` | `INT` | PK, AUTO_INCREMENT | 固有ID |
| `char_slug` | `VARCHAR(50)` | UNIQUE, NOT NULL | 識別子 (例: `ryu`, `akuma`, `luke`) |
| `name_jp` | `VARCHAR(100)` | NOT NULL | 日本語表記 (例: `豪鬼`) |
| `name_en` | `VARCHAR(100)` | NOT NULL | 英語表記 (例: `AKUMA`) |
| `battle_type` | `ENUM` | NOT NULL | タイプ (`スタンダード`/`パワー`/`スピード`/`トリッキー`) |
| `vitality` | `INT` | NOT NULL (DEFAULT 10000) | 体力値 (豪鬼は9000等) |
| `profile_text`| `TEXT` | NULL許可 | キャラクター紹介 (Markdown形式) |
| `sort_order` | `INT` | NOT NULL | 表示順 (ギャップ法: 100, 200, 300...) |

#### ② `combos` テーブル (コンボレシピ)
| カラム名 | 型 | 制約 / 備考 | 説明 |
| --- | --- | --- | --- |
| `id` | `INT` | PK, AUTO_INCREMENT | コンボID |
| `character_id`| `INT` | FK -> characters.id | 対象キャラクター |
| `category` | `ENUM` | NOT NULL | コンボ区分 (`基本`/`応用`/`ドライブラッシュ`/`パニカン`/`リーサル`) |
| `situation` | `VARCHAR(100)`| NOT NULL | 始動状況 (例: `中央・ノーゲージ`, `画面端`) |
| `recipe` | `TEXT` | NOT NULL | コンボレシピテキスト (例: `2HP > 236PP > 623HP`) |
| `damage` | `INT` | NOT NULL | ダメージ量 |
| `drive_cost` | `INT` | DEFAULT 0 | 消費ドライブゲージ量 |
| `sa_cost` | `INT` | DEFAULT 0 | 消費SAゲージ量 |
| `difficulty` | `ENUM` | NOT NULL | 難易度 (`★1`/`★2`/`★3`/`★4`/`★5`) |
| `comment` | `TEXT` | NULL許可 | 補足・使いどころの解説 |

#### ③ `movelist` テーブル (技コマンドリスト)
| カラム名 | 型 | 制約 / 備考 | 説明 |
| --- | --- | --- | --- |
| `id` | `INT` | PK, AUTO_INCREMENT | 技ID |
| `character_id`| `INT` | FK -> characters.id | 対象キャラクター |
| `move_type` | `ENUM` | NOT NULL | 区分 (`通常技`/`特殊技`/`必殺技`/`スーパーアーツ`) |
| `move_name` | `VARCHAR(100)`| NOT NULL | 技名 (例: `豪波動拳`) |
| `command` | `VARCHAR(100)`| NOT NULL | コマンド表記 (例: `236P`) |

#### ④ `frame` テーブル (フレームデータ)
| カラム名 | 型 | 制約 / 備考 | 説明 |
| --- | --- | --- | --- |
| `id` | `INT` | PK, AUTO_INCREMENT | ID |
| `character_id`| `INT` | FK -> characters.id | 対象キャラクター |
| `move_name` | `VARCHAR(100)`| NOT NULL | 対象技名 |
| `startup` | `INT` | NOT NULL | 発生フレーム (F) |
| `active` | `VARCHAR(50)` | NOT NULL | 持続フレーム |
| `recovery` | `INT` | NOT NULL | 硬直フレーム |
| `on_block` | `INT` | NOT NULL | **ガード時硬直差** (例: `-3`, `-8` ➔ 確定反撃判定に使用) |
| `on_hit` | `INT` | NOT NULL | ヒット時硬直差 |

#### ⑤ `matchup` & `matchup_guides` テーブル (キャラ対策)
* **`matchup`**: 対象キャラに対する難易度・総合相性・対策概要。
* **`matchup_guides`**: 「注意すべき主要技」「確定反撃ポイント」「ドライブリバーサル使いどころ」などの具体的な記事コンテンツ（Markdown対応）。

---

## 6. 静的データ (JSON / Markdown) 仕様

### 6-1. JSONファイル一覧 (`data/`)
* **`site_info.json`**: サイト基本設定、アプデ情報、お知らせ一覧。
* **`glossary.json`**:
  ```json
  [
    {
      "id": "frame",
      "term": "フレーム (F)",
      "kana": "ふれーむ",
      "category": "システム用語",
      "definition": "ゲーム内の時間の最小単位。SF6では1秒間が60フレームで構成される。"
    }
  ]
  ```
* **`training_menus.json`**: トレモ練習項目のリスト（メニュー名、レコード手順、動画リンク）。

### 6-2. Markdownファイル連携
* 長文の攻略コラムやキャラ紹介文は Markdown 形式で DB や `.md` ファイルに保存。
* 表示時は `src/lib/Parsedown.php` を経由し、セキュリティに配慮して `setSafeMode(true)` の上で HTML 変換してレンダリング。

---

## 7. 共通機能・モジュール・ロジック

### 7-1. `command_converter.php` (コマンド自動変換エンジン)
* **機能**: DB内のテキスト形式コマンド（例: `236P`, `623HK`, `46P`）を検知し、方向キー画像およびボタンアイコン画像（`.c-cmd-img`）の HTML へ自動置換する処理。
* **メリット**: DB入力時はシンプルな文字列で入力でき、フロントエンドでは直感的なグラフィックとして表示可能。

### 7-2. `db_helpers.php` (DBアクセス共通化)
* **機能**: PDO接続の共通化、および `getAllCharacters()`, `getCharacterBySlug($slug)`, `getCombosByCharId($id)` などの頻出クエリ関数を一元定義（DRY原則の徹底）。

### 7-3. `char_select.php` (共通キャラ選択コンポーネント)
* **機能**: `combo.php` と `matchup.php` で共通使用されるキャラクターグリッド選択画面。
* `$currentPage` 変数の値に応じて、遷移先URL（`/combo?char=...` または `/matchup?char=...`）を自動切替。

---

## 8. UI/UX デザインガイドライン

### 8-1. カラーパレット (自作CSS Variables)
SF6本編のアーバンポップ＆ダークな世界観を踏襲したデザイン。
* **ベース背景**: `#121212` (深いダークグレー)
* **コンテンツカード背景**: `#1E1E1E` (カード領域の視認性確保)
* **メインアクセント**: `#FFD700` (ゴールド) / `#FF4500` (オレンジレッド)
* **サブアクセント**: `#00FFFF` (ネオンシアン)
* **ポジティブ (有利・確反あり)**: `#00FF7F` (ネオングリーン)
* **ネガティブ (不利・危険)**: `#FF3E3E` (ネオンレッド)

### 8-2. レスポンシブ設計
* **デスクトップ**: 左サイドバーにグローバルナビゲーションを配置。
* **モバイル**: 下部固定ナビゲーションバーを配置。フレームデータなどの巨大テーブルは横スクロール化またはアコーディオン展開に切り替え。

---

## 9. 開発ルール & 保守ガイド

1. **命名規則**: ファイル名、PHP変数、DBカラム名はすべて**スネークケース**（例: `char_detail.php`, `character_id`）で統一。
2. **キャラ名スラッグ**: URLや画像ファイル名、CSSクラス名には統一された英字スラッグ（豪鬼 ➔ `akuma`, ルーク ➔ `luke`）を使用。
3. **退避ルール**: 不要になった旧ファイルは削除せず `_archive/` ディレクトリに保管。

---

> **まとめ：AI / 開発者への共有指示**  
> このWebアプリケーションの開発や改修を依頼する際は、本ファイル（`master_specification.md`）を参照元として読み込ませることで、サイトの構造・仕様・データ連携を正確に把握させることができます。
