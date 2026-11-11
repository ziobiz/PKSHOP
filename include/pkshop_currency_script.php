<?php
if (!function_exists('pkshop_currency_js_config')) {
    require_once dirname(__FILE__) . '/site_settings_lib.php';
}
$pkshop_currency_cfg = pkshop_currency_js_config();
?>
<script>
(function() {
	var cfg = <?=json_encode($pkshop_currency_cfg, JSON_UNESCAPED_UNICODE)?>;

	function applyRounding(amt) {
		var unit = parseFloat(cfg.round_unit);
		if (!(unit > 0)) unit = 10;
		var mode = cfg.round_mode || 'floor';
		var scaled = amt / unit;
		var adj;
		var eps = 1e-10;
		if (mode === 'ceil') {
			adj = (amt > 0) ? Math.ceil(scaled - eps) : Math.floor(scaled + eps);
		} else if (mode === 'floor') {
			adj = (amt > 0) ? Math.floor(scaled + eps) : Math.ceil(scaled - eps);
		} else if (mode === 'banker') {
			var n = Math.floor(Math.abs(scaled) + eps);
			var frac = Math.abs(scaled) - n;
			var sign = scaled < 0 ? -1 : 1;
			if (Math.abs(frac - 0.5) < 1e-10) {
				adj = sign * ((n % 2 === 0) ? n : n + 1);
			} else {
				adj = sign * Math.round(Math.abs(scaled));
			}
		} else {
			adj = Math.round(scaled);
		}
		var out = adj * unit;
		var dec = parseInt(cfg.round_decimals, 10) || 0;
		if (dec <= 0) return Math.round(out);
		var p = Math.pow(10, dec);
		return Math.round(out * p) / p;
	}

	function convertUsd(usd, code) {
		usd = parseFloat(usd) || 0;
		if (usd <= 0) return 0;
		var rate = (cfg.rates && cfg.rates[code]) ? parseFloat(cfg.rates[code]) : 1;
		return applyRounding(usd * rate);
	}

	function formatAmount(amt, code) {
		var sym = (cfg.symbols && cfg.symbols[code]) ? cfg.symbols[code] : code;
		var dec = parseInt(cfg.round_decimals, 10) || 0;
		var n = Number(amt);
		var fixed = n.toFixed(dec);
		var parts = fixed.split('.');
		parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
		return sym + ' ' + parts.join('.');
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
