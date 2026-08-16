# 設計定義書

このフォルダは、SF6攻略サイト（`new-sf6-page`）に関するすべての設計・仕様ドキュメントを管理します。

## フォルダ構成

```
設計定義書/
├── architecture.md      # プロジェクト全体の設計・アーキテクチャ定義書
├── pages/               # ページ別の仕様設計書（各 .php ファイルに対応）
│   ├── index.md
│   ├── guide.md
│   ├── glossary.md
│   ├── roadmap.md
│   ├── training.md
│   ├── combo.md
│   ├── matchup.md
│   └── akuma.md
└── database/            # データベーステーブル定義書
    ├── README.md        # テーブル一覧・リレーション図
    ├── characters.md
    ├── combos.md
    ├── movelist.md
    ├── frame.md
    ├── matchup.md
    ├── matchup_guides.md
    └── _archive/        # 現在未使用のテーブル定義書
```

## ドキュメントの目的

| ファイル/フォルダ | 内容 |
| --- | --- |
| `architecture.md` | 技術スタック、ディレクトリ構成、設計ルール、デザインガイドなど全体像 |
| `pages/` | 各ページの目的、データソース、コンポーネント構成、保守ルール |
| `database/` | 各DBテーブルのカラム定義、SQL、CSVインポートガイドライン |
