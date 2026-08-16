# データベーステーブル定義書 一覧

このフォルダには、`sf6` データベースを構成する各テーブルのカラム定義・運用ルール・SQLを記載した定義書を格納しています。

## 現在使用中のテーブル

| ファイル | テーブル名 | 主な用途 | 利用ページ |
| --- | --- | --- | --- |
| [characters.md](characters.md) | `characters` | キャラクター基本情報 | combo.php, matchup.php, akuma.php |
| [combos.md](combos.md) | `combos` | コンボレシピ・難易度 | combo.php, akuma.php |
| [movelist.md](movelist.md) | `movelist` | コマンドリスト（技名・コマンド） | combo.php, matchup.php |
| [frame.md](frame.md) | `frame` | フレームデータ（発生・硬直など） | matchup.php, akuma.php |
| [matchup.md](matchup.md) | `matchup` | キャラ対策の基本情報 | matchup.php |
| [matchup_guides.md](matchup_guides.md) | `matchup_guides` | 立ち回り・確定反撃などの詳細テキスト | matchup.php |

## テーブルリレーション

```
characters (1)
  ├── combos (N)         [character_id → characters.id]
  ├── movelist (N)       [character_id → characters.id]
  ├── frame (N)          [character_id → characters.id]
  ├── matchup (N)        [character_id → characters.id]
  └── matchup_guides (N) [matchup_id  → matchup.id]
```

## _archive フォルダについて
現在は使用されていないが、将来的に使用する可能性があるテーブル定義書を格納しています。
- `move_notation_map.md`: コマンド記法 ↔ フレームデータの変換テーブル（ダメージ自動計算機能の実装時に再活用予定）
