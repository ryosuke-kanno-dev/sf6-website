# コンボ集 (combo.php) 仕様設計書

## 1. ページの目的 (Purpose)
全キャラクターの「実用的な」コンボを提供するデータベースです。単なる全コンボの羅列ではなく、状況（画面中央、端、カウンター、ドライブゲージ状況）に応じた「とりあえずこれ」という実戦向けコンボを素早く検索できるようにします。

## 2. ターゲットユーザー (Target User)
- 新しいキャラクターを触り始めたプレイヤー（基礎コンボを知りたい）
- 自分のメインキャラの火力を伸ばしたいプレイヤー（最適コンボを探している）

## 3. データソースと管理方法 (Data Source)
- **DB (MySQL)**: `sf6` データベース
  - `characters` テーブル: キャラクターの基本情報
  - `combos` テーブル: コンボのレシピ、ダメージ、ゲージ消費、始動条件
  - `movelist` テーブル: コンボレシピに表示する技名・コマンドの参照用
- **共通ロジック**: `includes/functions/db_helpers.php` の `getAllCharacters()` や `getCharacterBySlug()` を使用。
- **コマンドアイコン化**: `includes/functions/command_converter.php` を使用し、DB上のテキスト（例: `236P`）を画像アイコン（波動拳コマンド）に変換して出力する。

## 4. コンポーネント構成 (Component Structure)
- `sections/_shared/char_select.php`: （`matchup.php`と共通）キャラクター選択グリッド
- `sections/combo/char_detail.php`: 選択されたキャラクターのコンボリストやコマンドリストを表示するメインコンテンツ

## 5. UI / 機能の振る舞い (UI / Functional Behavior)
- **URLパラメーターによるルーティング**:
  - `?char=` なしの場合: `_shared/char_select.php` を表示（キャラ一覧）
  - `?char={slug}` （例: `?char=ryu`）の場合: `char_detail.php` を表示し、対象キャラのデータを展開。
- **コマンドアイコンの動的生成**: `command_converter.php` によって、コンボレシピのテキストが直感的な方向キー・ボタンのアイコン（`.c-cmd-img`）に置換される。
- **コンボカードUI**: ダメージ量や消費ゲージ（ドライブゲージ、SAゲージ）を一目で視認できるバッジ（`.c-cmd-badge`）を配置する。

## 6. 運用・保守の注意点 (Maintenance)
- コンボデータはゲームのアップデート（パッチ）でダメージや繋がりが変わる可能性があるため、常に「対応バージョン」を意識したDB設計を保つ。
- コンボ表記（レシピ）の書き方は統一する。独自の記号を使わず、必ず `command_converter.php` が解釈できるフォーマットでDBに登録すること。
