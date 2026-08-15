/**
 * メインJavaScript
 * SF6攻略ガイド
 */

document.addEventListener('DOMContentLoaded', function () {
  // ==================== テーマ切り替え ====================
  const themeToggle = document.getElementById('themeToggle');
  const themeIcon = document.getElementById('themeIcon');
  const themeText = document.getElementById('themeText');
  const html = document.documentElement;

  // 保存されたテーマを読み込む、デフォルトはダークモード
  const currentTheme = localStorage.getItem('theme') || 'dark';
  html.setAttribute('data-theme', currentTheme);
  updateThemeButton(currentTheme);

  // テーマ切り替えボタン
  if (themeToggle) {
    themeToggle.addEventListener('click', function () {
      const currentTheme = html.getAttribute('data-theme');
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

      html.setAttribute('data-theme', newTheme);
      localStorage.setItem('theme', newTheme);
      updateThemeButton(newTheme);
    });
  }

  function updateThemeButton(theme) {
    if (themeIcon && themeText) {
      if (theme === 'dark') {
        themeIcon.textContent = '🌙';
        themeText.textContent = 'ダーク';
      } else {
        themeIcon.textContent = '☀️';
        themeText.textContent = 'ライト';
      }
    }
  }

  // ==================== モバイルメニュー ====================
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const navMenu = document.getElementById('navMenu');

  if (mobileMenuBtn && navMenu) {
    mobileMenuBtn.addEventListener('click', function () {
      navMenu.classList.toggle('active');

      // アイコン切り替え
      if (navMenu.classList.contains('active')) {
        mobileMenuBtn.textContent = '✕';
      } else {
        mobileMenuBtn.textContent = '☰';
      }
    });

    // メニュー外をクリックしたら閉じる
    document.addEventListener('click', function (event) {
      if (!navMenu.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
        navMenu.classList.remove('active');
        mobileMenuBtn.textContent = '☰';
      }
    });
  }

  // ==================== スムーススクロール ====================
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');

      // # のみの場合はページトップへ
      if (href === '#') {
        e.preventDefault();
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
        return;
      }

      // セクションIDへのスクロール
      const targetElement = document.querySelector(href);
      if (targetElement) {
        e.preventDefault();
        const headerOffset = 80;
        const elementPosition = targetElement.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

        window.scrollTo({
          top: offsetPosition,
          behavior: 'smooth'
        });
      }
    });
  });

  // ==================== ナビゲーションハイライト ====================
  const navLinks = document.querySelectorAll('.nav-link');
  const currentPath = window.location.pathname;

  navLinks.forEach(link => {
    const linkPath = new URL(link.href).pathname;
    if (currentPath === linkPath ||
      (currentPath.endsWith('/') && linkPath.endsWith('index.php'))) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });

  // ==================== スクロール時のナビゲーション ====================
  let lastScroll = 0;
  const nav = document.querySelector('.global-nav');

  if (nav) {
    nav.style.transition = 'transform 0.3s ease';

    window.addEventListener('scroll', function () {
      const currentScroll = window.pageYOffset;

      // 下スクロール時
      if (currentScroll > lastScroll && currentScroll > 100) {
        nav.style.transform = 'translateY(-100%)';
      }
      // 上スクロール時
      else {
        nav.style.transform = 'translateY(0)';
      }

      lastScroll = currentScroll;
    });
  }

  // ==================== アニメーション（スクロール時に表示） ====================
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver(function (entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, observerOptions);

  // アニメーション対象要素
  document.querySelectorAll('.card, .nav-card, .feature-card, .update-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
  });

  // ==================== 画像遅延読み込み ====================
  if ('loading' in HTMLImageElement.prototype) {
    const images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(img => {
      img.src = img.dataset.src || img.src;
    });
  } else {
    // Intersection Observer でフォールバック
    const imageObserver = new IntersectionObserver(function (entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src || img.src;
          imageObserver.unobserve(img);
        }
      });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
      imageObserver.observe(img);
    });
  }

  // ==================== ページトップボタン ====================
  const backToTopBtn = document.createElement('button');
  backToTopBtn.innerHTML = '↑';
  backToTopBtn.className = 'back-to-top';
  backToTopBtn.setAttribute('aria-label', 'ページトップへ戻る');
  backToTopBtn.style.cssText = `
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: var(--accent-gold);
    color: var(--bg-primary);
    border: none;
    border-radius: 50%;
    font-size: 24px;
    font-weight: 900;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 10000;
    box-shadow: 0 4px 20px rgba(255, 215, 0, 0.4);
  `;

  document.body.appendChild(backToTopBtn);

  // スクロール位置に応じて表示/非表示
  window.addEventListener('scroll', function () {
    if (window.pageYOffset > 300) {
      backToTopBtn.style.opacity = '1';
      backToTopBtn.style.visibility = 'visible';
    } else {
      backToTopBtn.style.opacity = '0';
      backToTopBtn.style.visibility = 'hidden';
    }
  });

  backToTopBtn.addEventListener('click', function () {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  backToTopBtn.addEventListener('mouseenter', function () {
    this.style.transform = 'scale(1.1)';
    this.style.boxShadow = '0 8px 30px rgba(255, 215, 0, 0.6)';
  });

  backToTopBtn.addEventListener('mouseleave', function () {
    this.style.transform = 'scale(1)';
    this.style.boxShadow = '0 4px 20px rgba(255, 215, 0, 0.4)';
  });

  // ==================== コンソールメッセージ ====================
  console.log('%c🎮 SF6攻略ガイド', 'font-size: 24px; font-weight: bold; color: #FFD700;');
  console.log('%cStreet Fighter 6 完全攻略サイト', 'font-size: 14px; color: #00FFFF;');
  console.log('%c初心者から上級者まで、あなたのランクに合わせた最適な練習法を提供', 'font-size: 12px; color: #b0b0b0;');
});
