<?php
/**
 * ICOPAY checkout bridge — thin proxy + shop-required UI/prefill.
 *
 * Hosted page needs PG_API_BASE + ?m=/?session= when not on api.icopay.co.kr.
 * Merchant admin settings (header/shipping/merchant/product) often do not apply
 * through this proxy path, so we enforce the shop's expected UI here.
 */
while (ob_get_level() > 0) {
	ob_end_clean();
}

include dirname(__FILE__) . '/../include/get_balance.php';
include dirname(__FILE__) . '/../include/login_check.php';

$bridge = isset($_SESSION['icopay_checkout_bridge']) && is_array($_SESSION['icopay_checkout_bridge'])
	? $_SESSION['icopay_checkout_bridge']
	: null;

if (!$bridge || empty($bridge['payUrl']) || empty($bridge['ts']) || (time() - (int)$bridge['ts']) > 3600) {
	header('Content-Type: text/plain; charset=utf-8', true, 400);
	echo 'Checkout session expired. Please restart payment from the order form.';
	exit;
}

$payUrl = trim((string)$bridge['payUrl']);
$parts = parse_url($payUrl);
$host = isset($parts['host']) ? strtolower((string)$parts['host']) : '';
$scheme = isset($parts['scheme']) ? strtolower((string)$parts['scheme']) : '';
if ($scheme !== 'https' || !preg_match('/(^|\.)icopay\.co\.kr$/', $host)) {
	header('Content-Type: text/plain; charset=utf-8', true, 400);
	echo 'Invalid payment URL host.';
	exit;
}

$apiOrigin = $scheme . '://' . $host;

$payQuery = array();
if (!empty($parts['query'])) {
	parse_str((string)$parts['query'], $payQuery);
}
if (!is_array($payQuery)) {
	$payQuery = array();
}
foreach (array('m', 'compId', 'session', 'entry', 'embed', 'lang') as $qk) {
	if (isset($_GET[$qk]) && trim((string)$_GET[$qk]) !== '') {
		$payQuery[$qk] = trim((string)$_GET[$qk]);
	}
}
if (empty($payQuery['m']) && defined('ICOPAY_COMP_ID') && ICOPAY_COMP_ID !== '') {
	$payQuery['m'] = ICOPAY_COMP_ID;
}
if (empty($payQuery['m']) && !empty($bridge['compId'])) {
	$payQuery['m'] = (string)$bridge['compId'];
}

$ch = curl_init($payUrl);
curl_setopt_array($ch, array(
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_SSL_VERIFYPEER => true,
	CURLOPT_HTTPHEADER => array(
		'Accept: text/html,application/xhtml+xml',
		'User-Agent: Mozilla/5.0 PKSHOP-ICOPAY-Bridge',
	),
));
$html = curl_exec($ch);
$errno = curl_errno($ch);
$code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($errno || $code < 200 || $code >= 400 || !is_string($html) || $html === '') {
	header('Content-Type: text/plain; charset=utf-8', true, 502);
	echo 'Failed to load ICOPAY checkout page.';
	exit;
}

$html = preg_replace('#(href|src)=(["\'])/(?!/)#i', '$1=$2' . $apiOrigin . '/', $html);
$html = preg_replace('#url\((["\']?)/(?!/)#i', 'url($1' . $apiOrigin . '/', $html);

$payload = json_encode(array(
	'firstName' => isset($bridge['firstName']) ? (string)$bridge['firstName'] : '',
	'lastName' => isset($bridge['lastName']) ? (string)$bridge['lastName'] : '',
	'email' => isset($bridge['email']) ? (string)$bridge['email'] : '',
	'phone' => isset($bridge['phone']) ? (string)$bridge['phone'] : '',
	'countryIso2' => isset($bridge['countryIso2']) ? (string)$bridge['countryIso2'] : 'JP',
	'amount' => isset($bridge['amount']) ? (string)$bridge['amount'] : '',
	'compId' => !empty($payQuery['m']) ? (string)$payQuery['m'] : '',
	'apiBase' => $apiOrigin,
), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

$boot = <<<HTML
<style id="pkshop-icopay-bridge-ui">
/* Fit content height (no tall empty shell) */
html, body {
  margin: 0 !important;
  padding: 0 !important;
  height: auto !important;
  min-height: 0 !important;
  overflow: hidden !important;
  background: #fff !important;
}
.pay-shell, .pay-card, .pay-wrap, .container, main {
  min-height: 0 !important;
  height: auto !important;
  max-height: none !important;
}
.pay-shell {
  padding-top: 6px !important;
  padding-bottom: 4px !important;
}
.pay-card {
  padding-bottom: 4px !important;
  margin-bottom: 0 !important;
}
#submitBtn, .pay-submit, button[type="submit"] {
  position: static !important;
  bottom: auto !important;
  margin-top: 8px !important;
  margin-bottom: 2px !important;
}

/* Scrollbars off */
html, body, .pay-shell, .pay-card {
  scrollbar-width: none !important;
  -ms-overflow-style: none !important;
}
html::-webkit-scrollbar, body::-webkit-scrollbar,
.pay-shell::-webkit-scrollbar, .pay-card::-webkit-scrollbar {
  width: 0 !important; height: 0 !important; display: none !important;
}

/* Hide ICOPAY brand header (admin DISABLED) */
#epBrandBlock, .pay-brand, .pay-brand-logo, .pay-brand-sub {
  display: none !important;
}

/* Show FX rows (DISPLAY_FX_THB) */
#payFxDisplayCurrencyRow,
#payFxQuoteRow {
  display: flex !important;
}
#payFxDisplayCurrencyRow.d-none,
#payFxQuoteRow.d-none {
  display: flex !important;
}
</style>
<script>
(function () {
  var PREFILL = {$payload};
  window.PG_API_BASE = PREFILL.apiBase || 'https://api.icopay.co.kr';
  try {
    var sp = new URLSearchParams(window.location.search || '');
    var changed = false;
    if (!(sp.get('m') || sp.get('compId') || sp.get('merchant')) && PREFILL.compId) {
      sp.set('m', String(PREFILL.compId));
      changed = true;
    }
    if (changed) {
      window.history.replaceState(null, '', window.location.pathname + '?' + sp.toString() + (window.location.hash || ''));
    }
  } catch (eHist) {}
})();
</script>
HTML;

$inject = <<<HTML
<script>
(function () {
  var PREFILL = {$payload};
  var fxLoaded = false;

  function hideEl(el) {
    if (!el) return;
    el.style.setProperty('display', 'none', 'important');
  }
  function hideRowById(id) {
    var el = document.getElementById(id);
    if (!el) return;
    hideEl(el.closest ? el.closest('.pay-row') : null);
    hideEl(el.closest ? el.closest('.pay-row-static') : null);
    hideEl(el);
  }
  function hideBySelector(sel) {
    var list = document.querySelectorAll(sel);
    for (var i = 0; i < list.length; i++) hideEl(list[i]);
  }

  function notifyParentHeight() {
    try {
      var body = document.body;
      var html = document.documentElement;
      var h = 0;
      // Prefer bottom of Pay button so parent Cancel sits right under it.
      var pay = document.getElementById('submitBtn')
        || document.querySelector('.pay-submit, button[type="submit"], .btn-pay, #payBtn');
      if (pay && pay.getBoundingClientRect) {
        var r = pay.getBoundingClientRect();
        var top = (window.pageYOffset || html.scrollTop || body.scrollTop || 0);
        h = Math.ceil(r.bottom + top + 12);
      }
      if (!(h > 100)) {
        var shell = document.querySelector('.pay-card, .pay-shell, .pay-wrap, form');
        if (shell) {
          h = Math.max(shell.scrollHeight || 0, shell.offsetHeight || 0) + 8;
        }
      }
      if (!(h > 100)) {
        h = Math.max(
          body ? body.scrollHeight : 0,
          html ? html.scrollHeight : 0
        );
      }
      if (!(h > 100)) return;
      if (window.parent && window.parent !== window) {
        window.parent.postMessage({
          source: 'icopay-checkout-bridge',
          type: 'icopay-bridge-resize',
          height: h
        }, '*');
      }
    } catch (eResize) {}
  }

  function applyShopUiRules() {
    // 1) Brand header
    hideEl(document.getElementById('epBrandBlock'));
    hideBySelector('.pay-brand, .pay-brand-logo, .pay-brand-sub');

    // 2) Merchant + product
    hideRowById('merchantNameDisplay');
    hideRowById('item');
    hideBySelector('.pay-row-static');

    // 3) Shipping / billing address
    hideEl(document.getElementById('billingLabel'));
    hideEl(document.getElementById('billingAddressRow'));
    hideRowById('payStreetAddress1');
    hideRowById('payCity');
    hideRowById('payPostcode');
    hideBySelector('[data-i18n="shipping"]');
    // hide parent rows that contain shipping label
    var shipLabels = document.querySelectorAll('[data-i18n="shipping"]');
    for (var s = 0; s < shipLabels.length; s++) {
      var p = shipLabels[s].closest('.pay-label, .pay-row, .mb-1, .mb-2, .mb-3');
      hideEl(p);
    }

    // 4) FX rows visible
    ['payFxDisplayCurrencyRow', 'payFxQuoteRow'].forEach(function (id) {
      var row = document.getElementById(id);
      if (!row) return;
      row.classList.remove('d-none');
      row.style.setProperty('display', 'flex', 'important');
    });
    var hint = document.getElementById('payAmountCurrencyHint');
    if (hint) hint.textContent = '(JPY)';
    var sel = document.getElementById('payDisplayCurrencySelect');
    if (sel) sel.style.display = 'none';
    var staticCur = document.getElementById('payFxDisplayCurrencyStatic');
    if (staticCur) {
      staticCur.style.display = '';
      staticCur.textContent = 'JPY';
    }

    notifyParentHeight();
  }

  function setVal(id, value, force) {
    if (value == null) return;
    var v = String(value).trim();
    if (!v) return;
    var el = document.getElementById(id);
    if (!el) return;
    if (!force && String(el.value || '').trim() !== '') return;
    el.value = v;
    try { el.dispatchEvent(new Event('input', { bubbles: true })); } catch (e1) {}
    try { el.dispatchEvent(new Event('change', { bubbles: true })); } catch (e2) {}
  }

  function formatCharge(n) {
    try { return Number(n).toLocaleString('en-US'); } catch (e) { return String(n); }
  }
  function ceilCharge(amt, perUnit, margin) {
    var v = Number(amt) * Number(perUnit) * (1 + Number(margin || 0));
    if (!(v > 0)) return null;
    return Math.ceil(v - 1e-9);
  }

  function loadFxQuote() {
    if (fxLoaded) return;
    var amountEl = document.getElementById('amount');
    var amt = amountEl ? String(amountEl.value || '').replace(/,/g, '') : '';
    if (!amt && PREFILL.amount) amt = String(PREFILL.amount);
    if (!(parseFloat(amt) > 0)) return;

    var sp = new URLSearchParams(window.location.search || '');
    var session = sp.get('session') || '';
    var compId = sp.get('m') || sp.get('compId') || PREFILL.compId || '';
    if (!session || !compId) return;

    var apiBase = (window.PG_API_BASE || PREFILL.apiBase || 'https://api.icopay.co.kr').replace(/\/$/, '');
    var qs = 'compId=' + encodeURIComponent(compId)
      + '&amount=' + encodeURIComponent(amt)
      + '&displayCurrency=JPY'
      + '&session=' + encodeURIComponent(session)
      + '&entry=merchant_api';

    fxLoaded = true;
    fetch(apiBase + '/api/pay/url/display-fx-quote?' + qs, {
      credentials: 'omit',
      cache: 'no-store',
      headers: { 'Accept': 'application/json' }
    }).then(function (r) { return r.json(); }).then(function (j) {
      applyShopUiRules();
      var d = (j && j.success && j.data) ? j.data : null;
      var el = document.getElementById('payFxThbEstimateText');
      if (!el) { notifyParentHeight(); return; }
      if (!d) { el.textContent = '—'; fxLoaded = false; notifyParentHeight(); return; }
      var per = d.settlementPerUnit != null ? d.settlementPerUnit : d.thbPerUnit;
      var mgn = d.marginRate != null ? d.marginRate : 0;
      var charged = ceilCharge(amt, per, mgn);
      var cur = (d.settlementCurrency || 'THB').toUpperCase();
      if (charged != null) {
        el.textContent = formatCharge(charged) + ' ' + cur;
        el.removeAttribute('data-fx-err');
      } else {
        el.textContent = '—';
        fxLoaded = false;
      }
      notifyParentHeight();
    }).catch(function () {
      fxLoaded = false;
      var el = document.getElementById('payFxThbEstimateText');
      if (el) el.textContent = '—';
      notifyParentHeight();
    });
  }

  function fillBuyer() {
    applyShopUiRules();

    // Amount (JPY)
    if (PREFILL.amount) {
      setVal('amount', PREFILL.amount, true);
      var amountEl = document.getElementById('amount');
      if (amountEl) {
        try { amountEl.readOnly = true; } catch (eRo) {}
      }
    }
    var hint = document.getElementById('payAmountCurrencyHint');
    if (hint) hint.textContent = '(JPY)';

    // Buyer contact / name from shop order form
    setVal('payFirstname', PREFILL.firstName, true);
    setVal('payLastname', PREFILL.lastName, true);
    setVal('payEmailAddress', PREFILL.email, true);
    setVal('payTelephone', PREFILL.phone, true);
    if (PREFILL.countryIso2) {
      setVal('payCountryIsoCode2', PREFILL.countryIso2, true);
      var cc = document.getElementById('payContactCountryCode');
      if (cc) {
        cc.value = String(PREFILL.countryIso2).toUpperCase();
        try { cc.dispatchEvent(new Event('change', { bubbles: true })); } catch (e3) {}
      }
    }

    loadFxQuote();
    notifyParentHeight();
  }

  var n = 0;
  var timer = setInterval(function () {
    fillBuyer();
    n += 1;
    if (n >= 40) clearInterval(timer);
  }, 250);
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', fillBuyer);
  } else {
    fillBuyer();
  }
  window.addEventListener('load', function () {
    applyShopUiRules();
    notifyParentHeight();
  });
  setTimeout(notifyParentHeight, 400);
  setTimeout(notifyParentHeight, 1200);
})();
</script>
HTML;

if (stripos($html, '<head>') !== false) {
	$html = preg_replace('/<head>/i', '<head>' . $boot, $html, 1);
} elseif (stripos($html, '<head ') !== false) {
	$html = preg_replace('/<head(\s[^>]*)>/i', '<head$1>' . $boot, $html, 1);
} else {
	$html = $boot . $html;
}

if (stripos($html, '</body>') !== false) {
	$html = preg_replace('/<\/body>/i', $inject . '</body>', $html, 1);
} else {
	$html .= $inject;
}

header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
echo $html;
exit;
