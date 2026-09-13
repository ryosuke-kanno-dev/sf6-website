<footer class="site-footer">
    &copy; <?php echo date('Y'); ?> SF6 攻略ポータル | ファンメイド非公式サイト
  </footer>
</div>

<button class="back-to-top" id="backToTop" aria-label="トップへ戻る">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</button>

<!-- __DIR__ を使うことで同じ includes フォルダ内のファイルを安全に読み込みます -->
<?php include __DIR__ . '/char-modal.php'; ?>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
      // 左サイドバーがあるページ（guide/training/character/roadmap/glossary）
      sidebar.classList.toggle('is-open');
      document.body.style.overflow = sidebar.classList.contains('is-open') ? 'hidden' : '';
      return;
    }
    // 左サイドバーが無いページ（index.php）は、ヘッダーナビ自体を開閉する
    const headerNav = document.querySelector('.site-header .header-nav');
    if (headerNav) {
      headerNav.classList.toggle('is-open');
    }
  }

  function toggleCharModal(isOpen) {
    const modal = document.getElementById('charModal');
    const sidebar = document.getElementById('sidebar');
    if (isOpen) {
      modal.classList.add('is-active');
      if (sidebar) {
        sidebar.classList.remove('is-open');
      }
    } else {
      modal.classList.remove('is-active');
    }
  }

  (function () {
    const backToTop = document.getElementById('backToTop');
    if (!backToTop) return;
    window.addEventListener('scroll', () => {
      backToTop.classList.toggle('show', window.scrollY > 400);
    });
    backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  })();
</script>
<script src="js/theme-toggle.js"></script>
</body>
</html>