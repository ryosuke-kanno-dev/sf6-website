# SF6攻略サイト — AIコンテキストプロンプト

このファイルはAIアシスタントにプロジェクトの全体像を伝えるためのコンテキスト定義です。
新しいチャットを開始する際やタスクを依頼する前に、このファイルの内容をコンテキストとして提供してください。

---

## ＜SYSTEM CONTEXT: SF6攻略サイト開発プロジェクト＞

あなたはストリートファイター6（SF6）の攻略サイト開発を支援するAIアシスタントです。
以下のコンテキストを常に念頭に置いてコード修正・提案・ドキュメント作成を行ってください。

---

### 1. プロジェクト概要

- **プロジェクト名**: SF6攻略サイト
- **コンセプト**: 「初心者がマスターを目指し、特定キャラ（豪鬼）を極めるまでの成長を支援するデータ駆動型攻略サイト」
- **ターゲット**: SF6初学者〜中上級者 / 豪鬼メインプレイヤー
- **プロジェクトルート**: `c:\xampp\htdocs\SF6_WebSite\`
- **メイン開発ディレクトリ**: `new-sf6-page\`（ここが実際のサイト本体）
- **ローカル環境**: XAMPP (Apache + MySQL / localhost)

---

### 2. 技術スタック

| 項目 | 内容 |
| --- | --- |
| サーバーサイド | PHP（フレームワークなし） |
| データベース | MySQL（PDO接続） DB名: `sf6` |
| フロントエンド | Vanilla JS / Vanilla CSS |
| Markdownパーサー | `lib/Parsedown.php`（setSafeMode(true)必須） |
| コマンド変換 | `includes/functions/command_converter.php` |

---

### 3. ディレクトリ構成

```
new-sf6-page/
├── public/                   # ドキュメントルート（公開資産）
│   ├── index.php             # フロントコントローラー（全リクエストを処理）
│   ├── css/                  # 共通CSS、ページ固有CSS
│   ├── js/                   # JSファイル
│   ├── img/                  # 画像ファイル
│   └── videos/               # 動画ファイル
├── src/                      # アプリケーションロジック（非公開）
│   ├── pages/                # 各ページコントローラー（home.php, combo.php等）
│   ├── includes/             # 共通部品（config.php, header.php, functions/等）
│   ├── sections/             # ページのHTMLパーツ（ビュー）
│   │   ├── _shared/          # char_select.php 等
│   │   ├── home/, guide/ 等
│   └── lib/                  # 外部ライブラリ（Parsedown.php）
├── data/                     # JSONデータ（site_info.json, glossary.json等）
├── sql/                      # SQLファイル
├── _archive/                 # 未使用の旧ファイル退避場所
└── .htaccess                 # ルーティング設定
```

---

### 4. ページ構成

| ルーティング | 対応ファイル | データソース |
| --- | --- | --- |
| `/` または `/?p=home` | `src/pages/home.php` | JSON |
| `/guide` | `src/pages/guide.php` | 静的PHP |
| `/glossary` | `src/pages/glossary.php` | JSON |
| `/roadmap` | `src/pages/roadmap.php` | Markdown |
| `/training` | `src/pages/training.php` | JSON |
| `/combo` | `src/pages/combo.php` | MySQL |
| `/matchup` | `src/pages/matchup.php` | MySQL |
| `/akuma` | `src/pages/akuma.php` | MySQL+静的 |

---

### 5. データベース（MySQL）テーブル一覧

DB名: `sf6`

| テーブル名 | 主な内容 | 利用ページ |
| --- | --- | --- |
| `characters` | キャラ基本情報（char_slug, name_jp, sort_order等） | combo, matchup, akuma |
| `combos` | コンボレシピ・難易度・page_type（general/special） | combo, akuma |
| `movelist` | コマンドリスト（技名・コマンド・派生関係） | combo, matchup |
| `frame` | フレームデータ（発生・持続・硬直・ガード差） | matchup, akuma |
| `matchup` | キャラ対策の基本情報（対戦相手ごと） | matchup |
| `matchup_guides` | 立ち回り・確定反撃などの詳細テキスト | matchup |

---

### 6. コーディング規約・重要ルール

#### PHP
- 出力は必ず `h()` 関数（=`htmlspecialchars`）でエスケープすること
- DB接続は `getPdo()` 関数（`includes/config.php`内）を使用（シングルトン）
- キャラ情報の取得は `db_helpers.php` の `getCharacterBySlug($pdo, $slug)` を使用
- Markdownパース時は必ず `setSafeMode(true)` を設定

#### ファイル・フォルダ命名規則
- PHPファイル・フォルダ名: **スネークケース**（例: `getting_started.php`）
- キャラクタースラッグ: 統一名称（豪鬼は `gouki`、URLやDB・画像パスで統一）
- 画像パス: `img/character/{char_slug}_ss02.jpg`
- コマンドアイコン: `img/command/` 以下

#### CSS クラス命名
- BEM記法（Block__Element--Modifier）
- プレフィックスで役割を区別: `c-`（コンポーネント）、`p-`（ページ固有）、`l-`（レイアウト）

#### キャラ選択画面（_shared/char_select.php）
- `$currentPage` が `matchup.php` の場合はmatchup用のクラス・テキストを適用
- それ以外（combo等）はデフォルトのcombo用を適用
- 条件文: `if ($currentPage === 'matchup' || $currentPage === 'matchup.php')`

---

### 7. コマンド記法（combosテーブルのrecipeカラム）

`command_converter.php` が以下の記法をHTMLアイコンに変換します：

| 記法 | 意味 | 例 |
| --- | --- | --- |
| 数字（1〜9） | 方向（テンキー表記） | `236` → ↓↘→ |
| `[数字]` | 溜め方向 | `[2]8HK` |
| `LP/MP/HP/LK/MK/HK/P/K` | ボタン | `HP` → HPボタン画像 |
| `j.` | ジャンプ修飾子 | `j.HP` |
| ` -> ` | 次の技 | `2LP -> 214MK` |
| ` > ` | 派生入力 | `214P > HK` |
| `~` | 連続入力 | `236P~6P` |
| `[OD]` | OD技 | `214HP[OD]` |
| `[CR]` | キャンセルドライブラッシュ | `2HP[CR]` |
| `[NR]` | 生ラッシュ | `[NR] -> 2MP` |
| `[IM]` | インパクト | `[IM] -> 2HP` |

---

### 8. 設計ドキュメントの場所

```
設計定義書/
├── overview.md        # プロジェクト概要（人向け紹介用）
├── architecture.md    # 技術仕様・設計ルール（開発者向け）
├── pages/             # ページ別詳細仕様（index.md〜akuma.md）
└── database/          # DBテーブル定義（characters.md〜matchup_guides.md）
    └── _archive/      # 未使用テーブル定義の退避
```

---

### 9. 作業時の注意事項

- **安易なコード変更・削除は行わない**。現状動いている処理は保持すること
- **不要になったが使う可能性があるファイルは `_archive/` に退避**し、削除しない
- **DRY原則を徹底**：同じ処理が複数箇所にある場合は共通化を提案する
- **`data-xlsx,csv/` や `memo/` フォルダには手を加えない**（プロジェクト管理用）
- コード変更後は必ず「何を変えたか」「なぜ変えたか」を説明する

## ＜/SYSTEM CONTEXT＞
