<?php
/**
 * ヘッダーコンポーネント
 * グローバルナビゲーション
 */
$currentPage = isset($_GET['p']) && $_GET['p'] !== '' ? basename($_GET['p']) : 'home';
?>
<header class="c-header">
    <div class="c-header__container">
        <a href="./" class="c-header__logo">SF6 攻略</a>
        
        <nav class="c-header__menu" id="navMenu">
            <a href="./" class="c-header__link <?php echo $currentPage === 'home' ? 'active' : ''; ?>">ホーム</a>
            <a href="guide" class="c-header__link <?php echo $currentPage === 'guide' ? 'active' : ''; ?>">ガイド</a>
            <a href="training" class="c-header__link <?php echo $currentPage === 'training' ? 'active' : ''; ?>">練習する</a>
            <a href="combo" class="c-header__link <?php echo $currentPage === 'combo' ? 'active' : ''; ?>">コンボ集</a>
            <a href="matchup" class="c-header__link <?php echo $currentPage === 'matchup' ? 'active' : ''; ?>">キャラ対策</a>
            <a href="roadmap" class="c-header__link <?php echo $currentPage === 'roadmap' ? 'active' : ''; ?>">上達法</a>
            <a href="glossary" class="c-header__link <?php echo $currentPage === 'glossary' ? 'active' : ''; ?>">用語集</a>
            
            <button class="c-theme-toggle" id="themeToggle" aria-label="テーマ切り替え">
                <span class="c-theme-toggle__icon" id="themeIcon">🌙</span>
                <span id="themeText">ダーク</span>
            </button>
        </nav>
        
        <button class="c-mobile-menu-btn" id="mobileMenuBtn" aria-label="メニュー">
            ☰
        </button>
    </div>
</header>
