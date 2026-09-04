# STREET FIGHTER 6 Strategy & Training Portal

ストリートファイター6のキャラクター攻略・フレームデータ・確定反撃・練習メニューを統合管理・閲覧できる、レスポンシブ対応のWebポータルサイトです。
既存のデータベース資産（旧仕様のDBスキーマ）を引き継ぎつつ、PHP 8とJSON駆動を組み合わせたモジュール化設計で保守性の高いアーキテクチャへ再構築しました。

---

## 📷 スクリーンショット / UI Overview

| ホーム / トップページ | キャラクター攻略 / コンボ表示 |
| :---: | :---: |
| ![ホーム画面](Images/screenshot_home.png) | ![キャラ攻略画面](Images/screenshot_character.png) |
| *クイックナビゲーションと最新情報* | *タブ切り替えによるコンボ・確定反撃・フレーム表の表示* |

| トレモ練習メニュー | 上達ロードマップ |
| :---: | :---: |
| ![トレモ練習画面](Images/screenshot_training.png) | ![ロードマップ画面](Images/screenshot_roadmap.png) |
| *JSON動的読み込みによるカード表示・フィルタリング* | *ランク帯別アコーディオン＆ページ内目次* |

---

## 💡 システムの特長・設計の工夫

* **ハイブリッドデータ管理 (MySQL PDO × JSON)**
  * キャラクター情報・フレームデータ・確定反撃データなど、構造が固まっている情報はMySQL（PDO・プレースホルダによるSQLインジェクション対策）で管理。
  * 用語集・チュートリアル・トレーニングメニューなど更新頻度の高いコンテンツ系データはJSON化し、BOM混入対策や構造揺れへのフォールバック処理を実装して読み込みの堅牢性を高めています。

* **レスポンシブ＆コンポーネント指向UI**
  * モバイル・デスクトップ双方での可読性を意識したCSSコンポーネント設計（CSS変数によるカラーテーマ管理）。
  * Vanilla JavaScriptによるタブ切り替え・キャラクター選択モーダル・アコーディオンUIの実装。

* **クリーンURL & SEO / OGP対応**
  * `.htaccess` によるURL拡張子（`.php`）の非表示化と、内部ディレクトリへの直接アクセス制御。
  * ページ単位で差し替え可能な動的メタタグ（OGP / Twitter Card）出力によるSNSシェア時の表示最適化。

* **入力コマンドの視認性向上アルゴリズム**
  * `弱P`, `236K` のようなテキスト形式の技コマンド表記を、対応するアイコン画像・バッジ表示へ自動変換するコンバーターを実装。

---

## 🛠️ 使用技術 (Tech Stack)

| カテゴリ | 技術・ツール |
| :--- | :--- |
| **Backend** | PHP 8.x（PDO、関数ベースのモジュール構成） |
| **Database** | MySQL |
| **Frontend** | HTML5, CSS3（CSS変数によるテーマ管理）, JavaScript（Vanilla / ES6+） |
| **Markdown変換** | [Parsedown](https://github.com/erusev/parsedown) |
| **Server / Routing** | Apache（`.htaccess` によるRewrite・直接アクセス制御） |
| **Data Format** | JSON |
| **Environment** | XAMPP（ローカル開発環境） |

---

## 📁 ディレクトリ構成

```text
src/
├── .htaccess                    # クリーンURL・セキュリティ制御
├── index.php                    # ホームページ
├── character.php                # キャラクター詳細（コンボ / 対策 / フレーム表タブ）
├── guide.php                    # 初期設定・操作タイプ比較・チュートリアル
├── training.php                 # トレモ練習メニュー
├── roadmap.php                  # ランク帯別 上達ロードマップ
├── glossary.php                 # 格ゲー用語集
│
├── includes/                    # 共通パーツ・ロジック
│   ├── .htaccess                # 直接アクセス拒否
│   ├── head.php                 # SEO / OGPメタタグ・CSS読込
│   ├── header.php
│   ├── sidebar.php               # ページ内目次（ページごとに出し分け）
│   ├── footer.php
│   ├── char-modal.php           # キャラクター選択モーダル
│   ├── db.php                   # PDO接続設定
│   └── functions/
│       ├── db_helpers.php       # DBアクセス関数・Markdown変換ラッパー
│       ├── command_converter.php # コマンド表記→アイコン変換
│       └── Parsedown.php        # Markdownパーサー（サードパーティ）
│
├── css/
│   ├── themes/                  # カラーテーマ（ライト/ダーク切替）
│   ├── layouts/                 # レイアウトパターン別CSS
│   └── components/              # コンポーネント単位のスタイル
│
├── js/
│   └── theme-toggle.js          # テーマ切替スクリプト
│
├── data/                        # コンテンツ管理用JSON
│   ├── glossary.json
│   ├── training_menus.json
│   ├── tutorials.json
│   └── devices.json
│
└── img/                         # キャラクター・デバイス画像
    ├── character/
    └── device/
```

---

## 🗄️ データベース構成（抜粋）

| テーブル | 役割 |
| :--- | :--- |
| `characters` | キャラクター基本情報 |
| `combos` | コンボレシピ・状況（画面端 / パニカン等）・難易度 |
| `frame` | 技ごとのフレームデータ（発生・持続・硬直差） |
| `matchup` | キャラクター対策の総評（対策難易度・特徴フラグ） |
| `matchup_guides` | 状況別（立ち回り・確反・切り返し等）の対策コラム |

---

## 📝 今後の展望

* チュートリアル内の動画コンテンツ（GIFアニメーション）の追加
* デバイス比較セクションの製品画像対応
* トレーニングメニューへの「習得済み」記録機能の追加
