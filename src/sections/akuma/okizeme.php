<?php
/**
 * 豪鬼特設ページ - 起き攻め
 * 静的コンテンツ（仮データ）
 * convertCommandToIcons() が includes/functions/command_converter.php で定義済みであることを前提とする。
 */
?>
<section id="okizeme" class="p-akuma__section p-akuma__section--dark">
    <div class="l-container">
        <div class="p-akuma__section-header">
            <h2 class="p-akuma__section-title">起き攻め（仮データ）</h2>
            <p class="p-akuma__section-desc">ダウンを奪った後の継続圧力。打撃・投げ・阿修羅の三択を使い分ける。</p>
        </div>

        <div class="p-akuma__setup-grid">

            <div class="p-akuma__setup-card">
                <div class="p-akuma__setup-card-header">
                    <div class="p-akuma__setup-title">竜巻旋風脚後の重ね打撃</div>
                    <span class="p-akuma__setup-tag">起き攻め</span>
                </div>
                <div class="p-akuma__setup-recipe">
                    <?php echo convertCommandToIcons('214HK -> 2LK'); ?>
                </div>
                <p class="p-akuma__setup-body">
                    竜巻旋風脚（HK版）でダウンを奪った後、素早く2LKを重ねる基本セットアップ。
                    相手の受け身タイミングに合わせて有利な状況を作れる。
                    ヒット確認後はコンボに繋げる。
                </p>
            </div>

            <div class="p-akuma__setup-card">
                <div class="p-akuma__setup-card-header">
                    <div class="p-akuma__setup-title">昇竜拳後の重ね択</div>
                    <span class="p-akuma__setup-tag">対空後</span>
                </div>
                <div class="p-akuma__setup-recipe">
                    <?php echo convertCommandToIcons('623HP -> 2LK or 6LK'); ?>
                </div>
                <p class="p-akuma__setup-body">
                    豪昇竜（HP版）で対空後、ダッシュして有利状況を作り起き攻め。
                    2LKで打撃重ね or 6LK（投げ）で択をかける。
                    相手の受け身方向を読んで使い分けが重要。
                </p>
            </div>

            <div class="p-akuma__setup-card">
                <div class="p-akuma__setup-card-header">
                    <div class="p-akuma__setup-title">阿修羅閃空で裏択</div>
                    <span class="p-akuma__setup-tag">詐欺り込み</span>
                </div>
                <div class="p-akuma__setup-recipe">
                    <?php echo convertCommandToIcons('214HK -> 6KKK'); ?>
                </div>
                <p class="p-akuma__setup-body">
                    竜巻後に阿修羅閃空（前）で相手を飛び越え、めくり起き攻め。
                    表裏が分かりにくいため、相手の入力方向を惑わせることができる。
                    慣れると先読みの投げを通しやすい状況が生まれる。
                </p>
            </div>

        </div>
    </div>
</section>
