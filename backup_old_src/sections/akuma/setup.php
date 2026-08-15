<?php
/**
 * 豪鬼特設ページ - セットアップ
 * 静的コンテンツ（仮データ）
 * convertCommandToIcons() が includes/functions/command_converter.php で定義済みであることを前提とする。
 */
?>
<section id="setup" class="p-akuma__section">
    <div class="l-container">
        <div class="p-akuma__section-header">
            <h2 class="p-akuma__section-title">セットアップ（仮データ）</h2>
            <p class="p-akuma__section-desc">豪鬼固有のセットアップ択。インストール（IM）状態からの連携が主軸になる。</p>
        </div>

        <div class="p-akuma__override-banner" style="margin-bottom: var(--spacing-xl);">
            <span class="p-akuma__override-icon">🔥</span>
            <p class="p-akuma__override-text">
                豪鬼の<strong>インストール（[IM]）</strong>は、スーパーアーツ2「天魔轟砕陣」で発動する固有状態です。
                発動中は波動拳の速度アップ・竜巻の性能強化・追加コマンドが使用可能になります。
            </p>
        </div>

        <div class="p-akuma__setup-grid">

            <div class="p-akuma__setup-card">
                <div class="p-akuma__setup-card-header">
                    <div class="p-akuma__setup-title">インストール端コンボ</div>
                    <span class="p-akuma__setup-tag">IM状態</span>
                </div>
                <div class="p-akuma__setup-recipe">
                    <?php echo convertCommandToIcons('[IM] -> j.HP -> 2HP -> 214HP~6P -> 214HK'); ?>
                </div>
                <p class="p-akuma__setup-body">
                    インストール開始後の端コンボ基本ルート。
                    j.HPで詐欺り込みから2HPを当て、火炎波で追撃して竜巻でしめる。
                    ダメージ約3230、慣れたら最後をSA3に変えてリーサルを狙える。
                </p>
            </div>

            <div class="p-akuma__setup-card">
                <div class="p-akuma__setup-card-header">
                    <div class="p-akuma__setup-title">インストールダウン後セットアップ</div>
                    <span class="p-akuma__setup-tag">IM状態</span>
                </div>
                <div class="p-akuma__setup-recipe">
                    <?php echo convertCommandToIcons('[IM] -> [D] -> 2HP -> 236LP -> 214HK'); ?>
                </div>
                <p class="p-akuma__setup-body">
                    インストール中に空中ダウンを奪った後のルート（端）。
                    [D]はダウン追撃の技。2HPからLPゴウ波動〜竜巻で締め。
                    ダメージ約2970。安定感が高い端の確定ルート。
                </p>
            </div>

            <div class="p-akuma__setup-card">
                <div class="p-akuma__setup-card-header">
                    <div class="p-akuma__setup-title">生ラッシュからの基本コンボ</div>
                    <span class="p-akuma__setup-tag">汎用</span>
                </div>
                <div class="p-akuma__setup-recipe">
                    <?php echo convertCommandToIcons('[NR] -> HP -> MP~MP -> 214HK'); ?>
                </div>
                <p class="p-akuma__setup-body">
                    生ドライブラッシュ（Dゲージ3本消費）から始動する汎用コンボ。
                    遠距離から接近して大ダメージを確定させる攻め手段。
                    ダメージ約2920。ラッシュが繋がる状況で必ず使える選択肢。
                </p>
            </div>

        </div>
    </div>
</section>
