<footer class="site-footer">
    &copy; <?php echo date('Y'); ?> SF6 攻略ポータル | ファンメイド非公式サイト
  </footer>
</div>

<!-- __DIR__ を使うことで同じ includes フォルダ内のファイルを安全に読み込みます -->
<?php include __DIR__ . '/char-modal.php'; ?>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('is-open');
    document.body.style.overflow = sidebar.classList.contains('is-open') ? 'hidden' : '';
  }

  function toggleCharModal(isOpen) {
    const modal = document.getElementById('charModal');
    if (isOpen) {
      modal.classList.add('is-active');
      document.getElementById('sidebar').classList.remove('is-open');
    } else {
      modal.classList.remove('is-active');
    }
  }
</script>
<script src="js/theme-toggle.js"></script>
</body>
</html>