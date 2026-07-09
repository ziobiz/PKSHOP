<?php
if (!function_exists('pkshop_currency_js_config')) {
    require_once dirname(__FILE__) . '/site_settings_lib.php';
}
$pkshop_currency_cfg = pkshop_currency_js_config();
?>
<script>
(function() {
	var cfg = <?=json_encode($pkshop_currency_cfg, JSON_UNESCAPED_UNICODE)?>;

	function convertUsd(usd, code) {
		usd = parseFloat(usd) || 0;
		if (usd <= 0) return 0;
		var rate = (cfg.rates && cfg.rates[code]) ? parseFloat(cfg.rates[code]) : 1;
		var amt = usd * rate;
		var unit = (cfg.ceil_units && cfg.ceil_units[code]) ? parseInt(cfg.ceil_units[code], 10) : 0;
		if (unit > 0) {
			amt = Math.ceil(amt / unit) * unit;
		} else {
			amt = Math.round(amt);
		}
		return amt;
	}

	function formatAmount(amt, code) {
		var sym = (cfg.symbols && cfg.symbols[code]) ? cfg.symbols[code] : code;
		return sym + ' ' + String(amt).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
	}

	function formatByOrder(usd, order) {
		var parts = [];
		(order || cfg.enabled || []).forEach(function(code) {
			parts.push(formatAmount(convertUsd(usd, code), code));
		});
		return parts.join(' / ');
	}

	window.PKSHOP_CURRENCY = cfg;
	window.pkshopFormatUsdPrice = function(usd) {
		return formatByOrder(usd, cfg.enabled);
	};
	window.pkshopFormatCheckoutUsdPrice = function(usd) {
		return formatByOrder(usd, cfg.display_order || cfg.enabled);
	};
})();
</script>
