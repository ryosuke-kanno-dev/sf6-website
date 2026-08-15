// ページ読み込み時に初期テーマを設定
document.addEventListener("DOMContentLoaded", () => {
  const themeToggleBtn = document.getElementById("theme-toggle-btn");

  // 1. ローカルストレージまたはOSの設定から初期テーマを取得
  const savedTheme = localStorage.getItem("theme");
  const systemPrefersDark = window.matchMedia(
    "(prefers-color-scheme: dark)",
  ).matches;

  // 保存された設定があればそれを優先、なければOS設定（またはデフォルト’dark’）
  let currentTheme = savedTheme || (systemPrefersDark ? "dark" : "light");

  // 初期状態を適用
  applyTheme(currentTheme);

  // 2. ボタン押下時の切り替え処理
  if (themeToggleBtn) {
    themeToggleBtn.addEventListener("click", () => {
      currentTheme = currentTheme === "dark" ? "light" : "dark";
      applyTheme(currentTheme);
      // ローカルストレージに保存（次回訪問時も維持）
      localStorage.setItem("theme", currentTheme);
    });
  }

  // テーマ適用とUI更新の共通関数
  function applyTheme(theme) {
    document.documentElement.setAttribute("data-theme", theme);
    if (themeToggleBtn) {
      // ボタンの見た目・アイコンを反転表示
      themeToggleBtn.textContent = theme === "dark" ? "☀️ Light" : "🌙 Dark";
      themeToggleBtn.setAttribute("aria-label", `${theme}モードから変更`);
    }
  }
});
