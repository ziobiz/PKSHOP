(function () {
  'use strict';

  var MAX_TOP_TABS = 12;
  var THEME_KEY = 'pkshop-shell-theme';
  var SIDEBAR_KEY = 'pkshop-sidebar-collapsed';
  var TABS_KEY = 'pkshop-nav-tabs';

  var init = window.PKSHOP_SHELL_INIT || {};
  var menuInfo = window.PKSHOP_MENU_INFO || {};
  var homeUrl = '/Adm/main/main.php';

  function normalizeUrl(url) {
    if (!url) return '';
    var a = document.createElement('a');
    a.href = url;
    var path = a.pathname || '';
    if (path.indexOf('/Adm/') >= 0) {
      path = path.substring(path.indexOf('/Adm/'));
    }
    path = path.replace(/\/$/, '') || path;
    var out = path;
    if (a.search && a.search.length > 1) {
      var params = {};
      a.search.substring(1).split('&').forEach(function (pair) {
        if (!pair) return;
        var kv = pair.split('=');
        var k = decodeURIComponent(kv[0] || '');
        var v = decodeURIComponent((kv[1] || '').replace(/\+/g, ' '));
        if (k) params[k] = v;
      });
      var keys = Object.keys(params).sort();
      var qs = keys.map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(params[k]);
      }).join('&');
      if (qs) out += '?' + qs;
    }
    return out;
  }

  function loadTabs() {
    try {
      var raw = localStorage.getItem(TABS_KEY);
      if (!raw) return [];
      var tabs = JSON.parse(raw);
      return Array.isArray(tabs) ? tabs : [];
    } catch (e) {
      return [];
    }
  }

  function saveTabs(tabs) {
    localStorage.setItem(TABS_KEY, JSON.stringify(tabs));
  }

  function tabLabel(url) {
    var key = normalizeUrl(url);
    if (menuInfo[key]) return menuInfo[key].label;
    var pathOnly = key.split('?')[0];
    var best = null;
    Object.keys(menuInfo).forEach(function (k) {
      if (k.split('?')[0] === pathOnly) best = menuInfo[k].label;
    });
    return best || '페이지';
  }

  function ensureCurrentTab() {
    var current = init.currentUrl || normalizeUrl(window.location.href);
    var tabs = loadTabs();
    var exists = tabs.some(function (t) { return normalizeUrl(t.url) === current; });
    if (!exists) {
      tabs.push({ url: current, label: tabLabel(current) });
      while (tabs.length > MAX_TOP_TABS) {
        var removed = false;
        for (var i = 0; i < tabs.length; i++) {
          if (normalizeUrl(tabs[i].url) !== normalizeUrl(homeUrl)) {
            tabs.splice(i, 1);
            removed = true;
            break;
          }
        }
        if (!removed) tabs.shift();
      }
      saveTabs(tabs);
    }
    return tabs;
  }

  function renderTabs() {
    var bar = document.getElementById('pg-tab-bar');
    if (!bar) return;
    var tabs = ensureCurrentTab();
    var current = init.currentUrl || normalizeUrl(window.location.href);
    var list = document.createElement('div');
    list.className = 'pg-tab-list';

    tabs.forEach(function (tab) {
      var url = tab.url;
      var norm = normalizeUrl(url);
      var active = norm === current;
      var item = document.createElement('div');
      item.className = 'pg-tab-item' + (active ? ' is-active' : '');

      var link = document.createElement('a');
      link.className = 'pg-tab-link';
      link.href = url;
      link.textContent = tab.label || tabLabel(url);
      link.title = tab.label || tabLabel(url);
      item.appendChild(link);

      if (tabs.length > 1) {
        var close = document.createElement('button');
        close.type = 'button';
        close.className = 'pg-tab-close';
        close.setAttribute('aria-label', '탭 닫기');
        close.textContent = '×';
        close.addEventListener('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          closeTab(url);
        });
        item.appendChild(close);
      }

      list.appendChild(item);
    });

    bar.innerHTML = '';
    bar.appendChild(list);
    updateCloseAllButton(tabs.length);
  }

  function closeTab(url) {
    var norm = normalizeUrl(url);
    var tabs = loadTabs().filter(function (t) {
      return normalizeUrl(t.url) !== norm;
    });
    if (!tabs.length) {
      tabs = [{ url: homeUrl, label: tabLabel(homeUrl) }];
    }
    saveTabs(tabs);
    var current = init.currentUrl || normalizeUrl(window.location.href);
    if (norm === current) {
      window.location.href = tabs[tabs.length - 1].url;
      return;
    }
    renderTabs();
  }

  function closeAllTabs() {
    var tabs = [{ url: homeUrl, label: tabLabel(homeUrl) }];
    saveTabs(tabs);
    var current = init.currentUrl || normalizeUrl(window.location.href);
    if (normalizeUrl(current) !== normalizeUrl(homeUrl)) {
      window.location.href = homeUrl;
    } else {
      renderTabs();
    }
  }

  function updateCloseAllButton(count) {
    var btn = document.getElementById('pg-tab-close-all');
    if (!btn) return;
    if (count > 1) {
      btn.classList.remove('pg-session-close-idle');
      btn.classList.add('pg-session-close-active');
      btn.disabled = false;
    } else {
      btn.classList.add('pg-session-close-idle');
      btn.classList.remove('pg-session-close-active');
      btn.disabled = true;
    }
  }

  function applyTheme(theme) {
    document.documentElement.setAttribute('data-shell-theme', theme);
    localStorage.setItem(THEME_KEY, theme);
    document.querySelectorAll('.pg-theme-btn').forEach(function (btn) {
      btn.classList.toggle('is-active', btn.getAttribute('data-theme') === theme);
    });
  }

  function initTheme() {
    var stored = localStorage.getItem(THEME_KEY) || 'default';
    applyTheme(stored);
    document.querySelectorAll('.pg-theme-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        applyTheme(btn.getAttribute('data-theme'));
      });
    });
  }

  function initSidebarFold() {
    var btn = document.getElementById('pg-sidebar-fold');
    var label = document.getElementById('pg-sidebar-fold-label');
    if (!btn) return;

    if (localStorage.getItem(SIDEBAR_KEY) === '1') {
      document.body.classList.add('pg-sidebar-collapsed');
      if (label) label.textContent = '»';
    }

    btn.addEventListener('click', function () {
      var collapsed = document.body.classList.toggle('pg-sidebar-collapsed');
      localStorage.setItem(SIDEBAR_KEY, collapsed ? '1' : '0');
      if (label) label.textContent = collapsed ? '»' : '« 접기';
      hideFlyout();
    });
  }

  function closeSideGroup(group) {
    if (!group) return;
    group.classList.remove('is-open');
    var parentBtn = group.querySelector('.pg-side-parent:not(.pg-side-parent-single)');
    var children = group.querySelector('.pg-side-children');
    if (parentBtn) parentBtn.setAttribute('aria-expanded', 'false');
    if (children) children.hidden = true;
  }

  function openSideGroup(group) {
    if (!group) return;
    group.classList.add('is-open');
    var parentBtn = group.querySelector('.pg-side-parent:not(.pg-side-parent-single)');
    var children = group.querySelector('.pg-side-children');
    if (parentBtn) parentBtn.setAttribute('aria-expanded', 'true');
    if (children) children.hidden = false;
  }

  function closeAllSideGroups(exceptGroup) {
    document.querySelectorAll('.pg-side-group').forEach(function (group) {
      if (group === exceptGroup) return;
      if (!group.querySelector('.pg-side-children')) return;
      closeSideGroup(group);
    });
  }

  function initMenuAccordion() {
    document.querySelectorAll('.pg-side-group').forEach(function (group) {
      var parentBtn = group.querySelector('.pg-side-parent:not(.pg-side-parent-single)');
      if (!parentBtn) return;
      var children = group.querySelector('.pg-side-children');
      parentBtn.addEventListener('click', function () {
        if (document.body.classList.contains('pg-sidebar-collapsed')) {
          hideFlyout();
          showFlyout(group, parentBtn);
          return;
        }
        var wasOpen = group.classList.contains('is-open');
        closeAllSideGroups(null);
        if (!wasOpen) {
          openSideGroup(group);
        }
      });
    });

    document.querySelectorAll('.pg-side-child a, .pg-side-parent-single, .pg-logo-link').forEach(function (link) {
      link.addEventListener('click', function () {
        var url = link.getAttribute('data-tab-url') || link.getAttribute('href');
        if (!url) return;
        registerTabNavigation(url);
      });
    });

    document.querySelectorAll('.pg-subtab').forEach(function (link) {
      link.addEventListener('click', function () {
        var url = link.getAttribute('data-tab-url') || link.getAttribute('href');
        if (url) registerTabNavigation(url);
      });
    });
  }

  function registerTabNavigation(url) {
    var norm = normalizeUrl(url);
    var tabs = loadTabs();
    var exists = tabs.some(function (t) { return normalizeUrl(t.url) === norm; });
    if (!exists) {
      tabs.push({ url: url, label: tabLabel(url) });
      while (tabs.length > MAX_TOP_TABS) {
        for (var i = 0; i < tabs.length; i++) {
          if (normalizeUrl(tabs[i].url) !== normalizeUrl(homeUrl)) {
            tabs.splice(i, 1);
            break;
          }
        }
      }
      saveTabs(tabs);
    }
  }

  var flyout = null;
  function ensureFlyout() {
    if (!flyout) {
      flyout = document.createElement('div');
      flyout.id = 'pg-side-flyout';
      document.body.appendChild(flyout);
      document.addEventListener('click', function (e) {
        if (flyout && !flyout.contains(e.target) && !e.target.closest('.pg-side-parent')) {
          hideFlyout();
        }
      });
    }
    return flyout;
  }

  function showFlyout(group, anchor) {
    var el = ensureFlyout();
    var children = group.querySelectorAll('.pg-side-child a');
    var current = init.currentUrl || normalizeUrl(window.location.href);
    var html = '';
    children.forEach(function (a) {
      var url = a.getAttribute('data-tab-url') || a.getAttribute('href');
      var active = normalizeUrl(url) === current ? ' class="is-active"' : '';
      html += '<a href="' + a.getAttribute('href') + '" data-tab-url="' + url + '"' + active + '>' + a.textContent + '</a>';
    });
    el.innerHTML = html;
    var rect = anchor.getBoundingClientRect();
    el.style.left = rect.right + 6 + 'px';
    el.style.top = rect.top + 'px';
    el.classList.add('is-open');
    el.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () {
        registerTabNavigation(a.getAttribute('data-tab-url') || a.getAttribute('href'));
        hideFlyout();
      });
    });
  }

  function hideFlyout() {
    if (flyout) flyout.classList.remove('is-open');
  }

  function initClock() {
    var el = document.getElementById('pg-access-time');
    if (!el) return;
    function tick() {
      var d = new Date();
      var y = d.getFullYear();
      var m = String(d.getMonth() + 1).padStart(2, '0');
      var day = String(d.getDate()).padStart(2, '0');
      var h = String(d.getHours()).padStart(2, '0');
      var min = String(d.getMinutes()).padStart(2, '0');
      var s = String(d.getSeconds()).padStart(2, '0');
      var wd = ['일', '월', '화', '수', '목', '금', '토'][d.getDay()];
      el.textContent = y + '. ' + m + '. ' + day + ' ' + h + ':' + min + ':' + s + ' ' + wd;
    }
    tick();
    setInterval(tick, 1000);
  }

  function initCloseAll() {
    var btn = document.getElementById('pg-tab-close-all');
    if (!btn) return;
    btn.addEventListener('click', function () {
      if (btn.disabled) return;
      closeAllTabs();
    });
  }

  function isLayoutTable(tbl) {
    if (!tbl || tbl.classList.contains('pg-screen-search-form')) return true;
    if (tbl.classList.contains('pg-legacy-grid') || tbl.classList.contains('pg-data-grid')) return false;
    var rows = tbl.rows;
    if (!rows || rows.length === 0) return true;
    if (rows.length === 1 && rows[0].cells.length <= 2) return true;
    return false;
  }

  function isDataTable(tbl) {
    if (!tbl || isLayoutTable(tbl)) return false;
    if (tbl.classList.contains('pg-table') || tbl.classList.contains('adm-table')) return true;
    if (tbl.querySelector('tr[bgcolor]')) return true;
    if (tbl.tHead) return true;
    if (tbl.rows.length >= 2 && tbl.rows[0].cells.length >= 4) return true;
    return false;
  }

  function wrapResponsiveTable(tbl) {
    if (!tbl || tbl.parentElement && tbl.parentElement.classList.contains('pg-table-responsive')) return;
    var wrap = document.createElement('div');
    wrap.className = 'pg-table-responsive';
    tbl.parentNode.insertBefore(wrap, tbl);
    wrap.appendChild(tbl);
  }

  function initFileAttachInputs() {
    var scope = document.querySelector('.pg-frame-body');
    if (!scope) return;

    scope.querySelectorAll('input[type="file"]').forEach(function (input) {
      if (input.dataset.attachUi === '1') return;
      if (input.dataset.pkshopAttachUi === '1') return;
      if (input.classList.contains('pg-file-attach-hidden')) return;
      if (input.closest('.pg-file-attach-picker')) return;
      if (input.closest('.pg-favicon-upload-form')) return;

      input.dataset.attachUi = '1';

      if (!input.id) {
        input.id = 'pg_file_' + Math.random().toString(36).slice(2, 10);
      }

      var displayId = input.id + '_display';
      var picker = document.createElement('div');
      picker.className = 'pg-file-attach-picker';

      var display = document.createElement('input');
      display.type = 'text';
      display.id = displayId;
      display.className = 'pg-input pg-file-attach-name';
      display.readOnly = true;
      display.placeholder = '선택된 파일 없음';

      var browse = document.createElement('label');
      browse.className = 'pg-btn pg-btn-outline pg-btn-file-browse';
      browse.setAttribute('for', input.id);
      browse.textContent = '파일 선택';

      input.classList.add('pg-file-attach-hidden');

      var parent = input.parentNode;
      parent.insertBefore(picker, input);
      picker.appendChild(display);
      picker.appendChild(browse);
      picker.appendChild(input);

      input.addEventListener('change', function () {
        if (input.files && input.files.length > 0) {
          display.value = input.files[0].name;
        } else {
          display.value = '';
        }
      });
    });
  }

  function initTableColumnResize() {
    var tables = document.querySelectorAll('.pg-frame-body table.pg-data-grid, .pg-frame-body table.adm-table, .pg-admin-content table.pg-data-grid, .pg-admin-content table.adm-table');
    tables.forEach(function (table) {
      if (table.dataset.colResizeInit === '1') return;
      table.dataset.colResizeInit = '1';
      table.classList.add('pg-data-grid--resizable');

      var thead = table.tHead;
      if (!thead || !thead.rows.length) return;

      var ths = thead.rows[0].cells;
      for (var i = 0; i < ths.length; i++) {
        (function (th, colIndex) {
          if (th.querySelector('.pg-col-resizer')) return;
          th.classList.add('pg-col-head-cell');
          var resizer = document.createElement('span');
          resizer.className = 'pg-col-resizer';
          resizer.setAttribute('aria-hidden', 'true');
          resizer.title = '열 너비 조절';
          th.appendChild(resizer);

          resizer.addEventListener('mousedown', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var startX = e.pageX;
            var startWidth = th.getBoundingClientRect().width;
            var minWidth = 48;

            function setColWidth(width) {
              var w = Math.max(minWidth, Math.round(width)) + 'px';
              th.style.width = w;
              th.style.minWidth = w;
              th.style.maxWidth = w;
              var rows = table.rows;
              for (var r = 0; r < rows.length; r++) {
                var cell = rows[r].cells[colIndex];
                if (!cell) continue;
                cell.style.width = w;
                cell.style.minWidth = w;
                cell.style.maxWidth = w;
              }
              table.style.tableLayout = 'fixed';
            }

            function onMove(ev) {
              setColWidth(startWidth + (ev.pageX - startX));
            }
            function onUp() {
              document.removeEventListener('mousemove', onMove);
              document.removeEventListener('mouseup', onUp);
              document.body.classList.remove('pg-col-resizing');
            }

            document.body.classList.add('pg-col-resizing');
            document.addEventListener('mousemove', onMove);
            document.addEventListener('mouseup', onUp);
          });
        })(ths[i], i);
      }
    });
  }

  function upgradeLegacyAdminUi() {
    /* Disabled: auto-wrapping legacy tables broke product/form pages. Use native pg-* markup per page. */
  }

  document.addEventListener('DOMContentLoaded', function () {
    initTheme();
    initSidebarFold();
    initMenuAccordion();
    initClock();
    initCloseAll();
    renderTabs();
    initTableColumnResize();
    initFileAttachInputs();
    upgradeLegacyAdminUi();
  });
})();
