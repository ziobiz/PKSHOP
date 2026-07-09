<?php
/**
 * Icopay broker — unified inline (recommended) or legacy ChillPay CCD.
 * 우선순위: icopay_pg_secrets.local.php > site_settings(관리자) > lib/config.php $GLOBALS > 환경변수
 */
$__icopay_site = null;
if (is_file(dirname(__FILE__) . '/../include/site_settings_lib.php')) {
	require_once dirname(__FILE__) . '/../include/site_settings_lib.php';
	$__icopay_site = pkshop_site_settings();
}

$__icopay_comp = '';
if (!empty($GLOBALS['ICOPAY_COMP_ID'])) {
	$__icopay_comp = trim((string)$GLOBALS['ICOPAY_COMP_ID']);
} elseif (getenv('ICOPAY_COMP_ID')) {
	$__icopay_comp = trim((string)getenv('ICOPAY_COMP_ID'));
} elseif (is_array($__icopay_site) && !empty($__icopay_site['icopay_comp_id'])) {
	$__icopay_comp = trim((string)$__icopay_site['icopay_comp_id']);
}

$__icopay_sec = '';
if (!empty($GLOBALS['ICOPAY_BROKER_SECRET'])) {
	$__icopay_sec = trim((string)$GLOBALS['ICOPAY_BROKER_SECRET']);
} elseif (getenv('ICOPAY_BROKER_SECRET')) {
	$__icopay_sec = trim((string)getenv('ICOPAY_BROKER_SECRET'));
}

$__icopay_local = dirname(__FILE__) . '/icopay_pg_secrets.local.php';
if (is_file($__icopay_local)) {
	include $__icopay_local;
}

if (!defined('ICOPAY_PUBLIC_BASE')) {
	$__api_base = 'https://api.icopay.co.kr';
	if (is_array($__icopay_site) && !empty($__icopay_site['icopay_api_base_url'])) {
		$__api_base = trim((string)$__icopay_site['icopay_api_base_url']);
	}
	define('ICOPAY_PUBLIC_BASE', $__api_base);
}

if (!defined('ICOPAY_COMP_ID')) {
	define('ICOPAY_COMP_ID', $__icopay_comp);
}

if (!defined('ICOPAY_BROKER_SECRET')) {
	define('ICOPAY_BROKER_SECRET', $__icopay_sec);
}

if (!defined('ICOPAY_CHILL_PAY_CURRENCY')) {
	$__cur = 'USD';
	if (!empty($GLOBALS['ICOPAY_CHILL_PAY_CURRENCY'])) {
		$__cur = trim((string)$GLOBALS['ICOPAY_CHILL_PAY_CURRENCY']);
	} elseif (getenv('ICOPAY_CHILL_PAY_CURRENCY')) {
		$__cur = trim((string)getenv('ICOPAY_CHILL_PAY_CURRENCY'));
	} elseif (is_file(dirname(__FILE__) . '/../include/site_settings_lib.php')) {
		require_once dirname(__FILE__) . '/../include/site_settings_lib.php';
		if (function_exists('pkshop_get_payment_currency')) {
			$__cur = pkshop_get_payment_currency();
		}
	}
	define('ICOPAY_CHILL_PAY_CURRENCY', $__cur);
}

if (!defined('ICOPAY_CCD_LANG')) {
	$__lang = 'en';
	if (!empty($GLOBALS['ICOPAY_CCD_LANG'])) {
		$__lang = trim((string)$GLOBALS['ICOPAY_CCD_LANG']);
	} elseif (getenv('ICOPAY_CCD_LANG')) {
		$__lang = trim((string)getenv('ICOPAY_CCD_LANG'));
	} elseif (is_array($__icopay_site) && !empty($__icopay_site['icopay_ccd_lang'])) {
		$__lang = trim((string)$__icopay_site['icopay_ccd_lang']);
	}
	define('ICOPAY_CCD_LANG', $__lang);
}

if (!defined('ICOPAY_CHILLPAY_ENABLED')) {
	define('ICOPAY_CHILLPAY_ENABLED', (ICOPAY_BROKER_SECRET !== '' && ICOPAY_COMP_ID !== ''));
}

if (!defined('ICOPAY_CCD_MERCHANT_CODE')) {
	$__ccd_m = '';
	if (!empty($GLOBALS['ICOPAY_CCD_MERCHANT_CODE'])) {
		$__ccd_m = trim((string)$GLOBALS['ICOPAY_CCD_MERCHANT_CODE']);
	} elseif (is_array($__icopay_site) && !empty($__icopay_site['icopay_ccd_merchant_code'])) {
		$__ccd_m = trim((string)$__icopay_site['icopay_ccd_merchant_code']);
	}
	define('ICOPAY_CCD_MERCHANT_CODE', $__ccd_m);
}

if (!defined('ICOPAY_CCD_API_KEY')) {
	$__ccd_k = '';
	if (!empty($GLOBALS['ICOPAY_CCD_API_KEY'])) {
		$__ccd_k = trim((string)$GLOBALS['ICOPAY_CCD_API_KEY']);
	} elseif (is_array($__icopay_site) && !empty($__icopay_site['icopay_ccd_api_key'])) {
		$__ccd_k = trim((string)$__icopay_site['icopay_ccd_api_key']);
	}
	define('ICOPAY_CCD_API_KEY', $__ccd_k);
}

if (!defined('ICOPAY_INTEGRATION_MODE')) {
	$__mode = 'unified';
	if (!empty($GLOBALS['ICOPAY_INTEGRATION_MODE'])) {
		$__mode = strtolower(trim((string)$GLOBALS['ICOPAY_INTEGRATION_MODE']));
	} elseif (getenv('ICOPAY_INTEGRATION_MODE')) {
		$__mode = strtolower(trim((string)getenv('ICOPAY_INTEGRATION_MODE')));
	} elseif (is_array($__icopay_site) && !empty($__icopay_site['icopay_integration_mode'])) {
		$__mode = strtolower(trim((string)$__icopay_site['icopay_integration_mode']));
	}
	define('ICOPAY_INTEGRATION_MODE', $__mode);
}

if (!defined('ICOPAY_PAYMENT_CURRENCY')) {
	$__pay_cur = '';
	if (!empty($GLOBALS['ICOPAY_PAYMENT_CURRENCY'])) {
		$__pay_cur = strtoupper(trim((string)$GLOBALS['ICOPAY_PAYMENT_CURRENCY']));
	} elseif (getenv('ICOPAY_PAYMENT_CURRENCY')) {
		$__pay_cur = strtoupper(trim((string)getenv('ICOPAY_PAYMENT_CURRENCY')));
	}
	if ($__pay_cur === '' && is_array($__icopay_site) && !empty($__icopay_site['icopay_payment_currency'])) {
		$__pay_cur = strtoupper(trim((string)$__icopay_site['icopay_payment_currency']));
	}
	if ($__pay_cur === '' && is_file(dirname(__FILE__) . '/../include/site_settings_lib.php')) {
		require_once dirname(__FILE__) . '/../include/site_settings_lib.php';
		if (function_exists('pkshop_get_payment_currency')) {
			$__pay_cur = pkshop_get_payment_currency();
		}
	}
	if ($__pay_cur === '') {
		$__pay_cur = 'JPY';
	}
	define('ICOPAY_PAYMENT_CURRENCY', $__pay_cur);
}

if (!defined('ICOPAY_BUYER_COUNTRY_ISO2')) {
	$__buyer_cc = 'JP';
	if (!empty($GLOBALS['ICOPAY_BUYER_COUNTRY_ISO2'])) {
		$__buyer_cc = strtoupper(substr(trim((string)$GLOBALS['ICOPAY_BUYER_COUNTRY_ISO2']), 0, 2));
	} elseif (getenv('ICOPAY_BUYER_COUNTRY_ISO2')) {
		$__buyer_cc = strtoupper(substr(trim((string)getenv('ICOPAY_BUYER_COUNTRY_ISO2')), 0, 2));
	} elseif (is_array($__icopay_site) && !empty($__icopay_site['icopay_buyer_country_iso2'])) {
		$__buyer_cc = strtoupper(substr(trim((string)$__icopay_site['icopay_buyer_country_iso2']), 0, 2));
	}
	if (strlen($__buyer_cc) !== 2) {
		$__buyer_cc = 'JP';
	}
	define('ICOPAY_BUYER_COUNTRY_ISO2', $__buyer_cc);
}

if (!defined('ICOPAY_CHECKOUT_LANG')) {
	$__ck_lang = 'JPN';
	if (!empty($GLOBALS['ICOPAY_CHECKOUT_LANG'])) {
		$__ck_lang = trim((string)$GLOBALS['ICOPAY_CHECKOUT_LANG']);
	} elseif (getenv('ICOPAY_CHECKOUT_LANG')) {
		$__ck_lang = trim((string)getenv('ICOPAY_CHECKOUT_LANG'));
	} elseif (is_array($__icopay_site) && !empty($__icopay_site['icopay_checkout_lang'])) {
		$__ck_lang = trim((string)$__icopay_site['icopay_checkout_lang']);
	}
	define('ICOPAY_CHECKOUT_LANG', $__ck_lang);
}

if (!defined('ICOPAY_UNIFIED_ENABLED')) {
	$__pg_on = true;
	if (is_array($__icopay_site) && isset($__icopay_site['payment_pg_enabled']) && $__icopay_site['payment_pg_enabled'] === '0') {
		$__pg_on = false;
	}
	$__unified = $__pg_on && (ICOPAY_BROKER_SECRET !== '' && ICOPAY_COMP_ID !== '' && ICOPAY_INTEGRATION_MODE === 'unified');
	define('ICOPAY_UNIFIED_ENABLED', $__unified);
}

if (!defined('ICOPAY_CHILLPAY_LEGACY_ENABLED')) {
	$__pg_on = true;
	if (is_array($__icopay_site) && isset($__icopay_site['payment_pg_enabled']) && $__icopay_site['payment_pg_enabled'] === '0') {
		$__pg_on = false;
	}
	$__legacy = $__pg_on && (ICOPAY_BROKER_SECRET !== '' && ICOPAY_COMP_ID !== '' && ICOPAY_INTEGRATION_MODE === 'chillpay');
	define('ICOPAY_CHILLPAY_LEGACY_ENABLED', $__legacy);
}
