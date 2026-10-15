/**
 * フレームデータ表（includes/functions/frame_table.php が出力）の操作：
 *  表示項目のチェックボックス / 技種別の絞り込み / キーワード検索 / プリセット / 選択のブラウザ保存
 */
/* PURE-START（DOMに依存しない判定ロジック。テストしやすいよう分離） */
var FT_PRESET_BASIC = ['startup', 'active', 'recovery', 'hit_adv', 'guard_adv'];

// 検索用の正規化：全角/半角・大文字小文字・空白の違いを吸収する
function ftNormalize(s) {
  var t = String(s == null ? '' : s);
  if (t.normalize) { t = t.normalize('NFKC'); }
  return t.toLowerCase().replace(/\s+/g, '');
}

// row = {type, text(正規化済み)}, state = {types: {種別: true/false}, query(正規化済み)}
function ftRowVisible(row, state) {
  if (state.types && state.types[row.type] === false) return false;
  if (state.query && row.text.indexOf(state.query) === -1) return false;
  return true;
}

// コマンド表示形式の保存値：'icons' / 'text' 以外は 'icons'（初期値）に戻す
function ftParseCmdMode(raw) {
  return raw === 'text' ? 'text' : 'icons';
}

// 保存値の読み出し：配列でなければ null。存在しない項目キーは取り除く
function ftParseStored(raw, validKeys) {
  if (raw == null) return null;
  try {
    var a = JSON.parse(raw);
    if (!Array.isArray(a)) return null;
    return a.filter(function (k) { return validKeys.indexOf(k) !== -1; });
  } catch (e) {
    return null;
  }
}
/* PURE-END */

(function () {
  var STORE_KEY = 'sf6ft_cols_v1';
  var CMD_KEY   = 'sf6ft_cmd_v1';

  function toArray(list) { return Array.prototype.slice.call(list); }

  function init(wrap) {
    var toggles    = toArray(wrap.querySelectorAll('.ft-col-toggle'));
    var typeChecks = toArray(wrap.querySelectorAll('.ft-type-toggle'));
    var groupRows  = toArray(wrap.querySelectorAll('tbody tr.frame-group-row'));
    var rows = toArray(wrap.querySelectorAll('tbody tr.frame-row')).map(function (tr) {
      return { el: tr, type: tr.dataset.type, text: ftNormalize(tr.dataset.search) };
    });
    var cmdRadios = toArray(wrap.querySelectorAll('.ft-cmd-mode'));
    var search   = wrap.querySelector('.frame-search');
    var countEl  = wrap.querySelector('.frame-count');
    var colsInfo = wrap.querySelector('.ft-cols-count');

    var validKeys = toggles.map(function (t) { return t.value; });
    var defaults  = toggles.filter(function (t) { return t.dataset.default === '1'; }).map(function (t) { return t.value; });

    function currentKeys() {
      return toggles.filter(function (t) { return t.checked; }).map(function (t) { return t.value; });
    }

    // 表示項目の反映：外枠のクラス ft-hide-◯◯ で列を隠す（CSSで定義）。見出し行の colspan も合わせる
    function applyCols(keys) {
      toggles.forEach(function (t) {
        var on = keys.indexOf(t.value) !== -1;
        t.checked = on;
        wrap.classList.toggle('ft-hide-' + t.value, !on);
      });
      var span = 1 + keys.length;
      groupRows.forEach(function (g) { g.firstElementChild.colSpan = span; });
      if (colsInfo) colsInfo.textContent = '（' + keys.length + '/' + validKeys.length + '項目を表示中）';
    }
    function saveCols(keys) {
      try { localStorage.setItem(STORE_KEY, JSON.stringify(keys)); } catch (e) { /* 保存できなくても表示は動く */ }
    }
    function loadCols() {
      try { return ftParseStored(localStorage.getItem(STORE_KEY), validKeys); } catch (e) { return null; }
    }

    // 絞り込み（技種別・キーワード）の反映
    function applyFilter() {
      var state = { types: {}, query: ftNormalize(search ? search.value : '') };
      typeChecks.forEach(function (c) { state.types[c.value] = c.checked; });
      var shown = 0, shownByType = {};
      rows.forEach(function (r) {
        var ok = ftRowVisible(r, state);
        r.el.style.display = ok ? '' : 'none';
        if (ok) { shown++; shownByType[r.type] = (shownByType[r.type] || 0) + 1; }
      });
      groupRows.forEach(function (g) {
        g.style.display = shownByType[g.dataset.type] ? '' : 'none';
      });
      if (countEl) countEl.textContent = shown + ' / ' + rows.length + ' 技を表示';
    }

    toggles.forEach(function (t) {
      t.addEventListener('change', function () {
        var keys = currentKeys();
        applyCols(keys);
        saveCols(keys);
      });
    });
    typeChecks.forEach(function (c) { c.addEventListener('change', applyFilter); });
    if (search) search.addEventListener('input', applyFilter);

    // コマンド表示の切り替え（アイコン / テンキー表記）。外枠に ft-cmd-text を付けると文字表示になる（CSSで切替）
    function applyCmdMode(mode) {
      wrap.classList.toggle('ft-cmd-text', mode === 'text');
      cmdRadios.forEach(function (r) { r.checked = (r.value === mode); });
    }
    function loadCmdMode() {
      try { return ftParseCmdMode(localStorage.getItem(CMD_KEY)); } catch (e) { return 'icons'; }
    }
    cmdRadios.forEach(function (r) {
      r.addEventListener('change', function () {
        if (!r.checked) return;
        applyCmdMode(r.value);
        try { localStorage.setItem(CMD_KEY, r.value); } catch (e) { /* 保存できなくても表示は動く */ }
      });
    });

    toArray(wrap.querySelectorAll('.ft-preset')).forEach(function (btn) {
      btn.addEventListener('click', function () {
        var keys = btn.dataset.preset === 'basic' ? FT_PRESET_BASIC.filter(function (k) { return validKeys.indexOf(k) !== -1; })
                 : btn.dataset.preset === 'all'   ? validKeys.slice()
                 : defaults.slice();
        applyCols(keys);
        saveCols(keys);
      });
    });

    applyCols(loadCols() || defaults);
    applyCmdMode(loadCmdMode());
    applyFilter();
  }

  toArray(document.querySelectorAll('.frame-table-wrap[data-ft]')).forEach(init);
})();
