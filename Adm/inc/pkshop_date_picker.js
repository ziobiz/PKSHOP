/**
 * PKSHOP Admin — PG-style native date picker sync (ISO ↔ legacy y/m/d hidden fields).
 */
(function () {
  'use strict';

  function pad2(n) {
    n = parseInt(n, 10);
    if (isNaN(n) || n < 0) return '00';
    return n < 10 ? '0' + n : String(n);
  }

  function isoFromYmd(y, m, d) {
    y = parseInt(y, 10);
    m = parseInt(m, 10);
    d = parseInt(d, 10);
    if (isNaN(y) || isNaN(m) || isNaN(d) || y < 1 || m < 1 || d < 1) return '';
    return y + '-' + pad2(m) + '-' + pad2(d);
  }

  function ymdFromIso(iso) {
    if (!iso || typeof iso !== 'string') return null;
    var m = iso.match(/^(\d{4})-(\d{2})-(\d{2})$/);
    if (!m) return null;
    return { y: parseInt(m[1], 10), m: parseInt(m[2], 10), d: parseInt(m[3], 10) };
  }

  function syncDateRangeWrap(wrap) {
    if (!wrap) return;

    var fromInput = wrap.querySelector('[data-pg-date-from]');
    var toInput = wrap.querySelector('[data-pg-date-to]');
    var hY = wrap.querySelectorAll('input[type="hidden"][data-pg-hidden-y]');
    var hM = wrap.querySelectorAll('input[type="hidden"][data-pg-hidden-m]');
    var hD = wrap.querySelectorAll('input[type="hidden"][data-pg-hidden-d]');
    if (!fromInput || !toInput || hY.length < 2 || hM.length < 2 || hD.length < 2) return;

    var fp = ymdFromIso(fromInput.value);
    var tp = ymdFromIso(toInput.value);
    if (fp) {
      hY[0].value = fp.y;
      hM[0].value = fp.m;
      hD[0].value = fp.d;
    }
    if (tp) {
      hY[1].value = tp.y;
      hM[1].value = tp.m;
      hD[1].value = tp.d;
    }
  }

  function initDateRangeWrap(wrap) {
    if (!wrap || wrap.getAttribute('data-pg-date-inited') === '1') return;
    wrap.setAttribute('data-pg-date-inited', '1');

    var fromInput = wrap.querySelector('[data-pg-date-from]');
    var toInput = wrap.querySelector('[data-pg-date-to]');
    var hY = wrap.querySelectorAll('input[type="hidden"][data-pg-hidden-y]');
    var hM = wrap.querySelectorAll('input[type="hidden"][data-pg-hidden-m]');
    var hD = wrap.querySelectorAll('input[type="hidden"][data-pg-hidden-d]');

    if (fromInput && hY.length >= 1 && hM.length >= 1 && hD.length >= 1) {
      if (!fromInput.value) {
        fromInput.value = isoFromYmd(hY[0].value, hM[0].value, hD[0].value);
      }
    }
    if (toInput && hY.length >= 2 && hM.length >= 2 && hD.length >= 2) {
      if (!toInput.value) {
        toInput.value = isoFromYmd(hY[1].value, hM[1].value, hD[1].value);
      }
    }

    function onChange() { syncDateRangeWrap(wrap); }
    if (fromInput) fromInput.addEventListener('change', onChange);
    if (toInput) toInput.addEventListener('change', onChange);

    syncDateRangeWrap(wrap);
  }

  function syncAllInForm(form) {
    if (!form) return;
    form.querySelectorAll('[data-pg-date-range]').forEach(syncDateRangeWrap);
  }

  function initAll() {
    document.querySelectorAll('[data-pg-date-range]').forEach(initDateRangeWrap);
    document.querySelectorAll('form').forEach(function (form) {
      if (form.getAttribute('data-pg-date-form') === '1') return;
      form.setAttribute('data-pg-date-form', '1');
      form.addEventListener('submit', function () {
        syncAllInForm(form);
      });
    });
  }

  function setIsoDateRange(fromIso, toIso) {
    document.querySelectorAll('[data-pg-date-range]').forEach(function (wrap) {
      var fromInput = wrap.querySelector('[data-pg-date-from]');
      var toInput = wrap.querySelector('[data-pg-date-to]');
      if (fromInput && fromIso) fromInput.value = fromIso;
      if (toInput && toIso) toInput.value = toIso;
      syncDateRangeWrap(wrap);
    });
  }

  window.pkshopSyncDateRangeHidden = syncDateRangeWrap;
  window.pkshopSyncAllDateRanges = syncAllInForm;
  window.pkshopIsoFromYmd = isoFromYmd;
  window.pkshopSetIsoDateRange = setIsoDateRange;

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAll);
  } else {
    initAll();
  }
})();
