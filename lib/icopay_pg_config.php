<?php
/**
 * Icopay broker (통합 인라인 / JPAY / ChillPay).
 * 우선순위: icopay_pg_secrets.local.php 의 define > lib/config.php 의 $GLOBALS > 환경변수
 */
$__icopay_comp = '';
if (!empty($GLOBALS['ICOPAY_COMP_ID'])) {
	$__icopay_comp = trim((string)$GLOBALS['ICOPAY_COMP_ID']);
} elseif (getenv('ICOPAY_COMP_ID')) {
	$__icopay_comp = trim((string)getenv('ICOPAY_COMP_ID'));
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
	define('ICOPAY_PUBLIC_BASE', 'https://api.icopay.co.kr');
}

if (!defined('ICOPAY_COMP_ID')) {
	define('ICOPAY_COMP_ID', $__icopay_comp);
}

if (!defined('ICOPAY_BROKER_SECRET')) {
	define('ICOPAY_BROKER_SECRET', $__icopay_sec);
}

if (!defined('ICOPAY_CHILL_PAY_CURRENCY')) {
	$__cur = 'JPY';
	if (!empty($GLOBALS['ICOPAY_PAY_CURRENCY'])) {
		$__cur = trim((string)$GLOBALS['ICOPAY_PAY_CURRENCY']);
	} elseif (!empty($GLOBALS['ICOPAY_CHILL_PAY_CURRENCY'])) {
		$__cur = trim((string)$GLOBALS['ICOPAY_CHILL_PAY_CURRENCY']);
	} elseif (getenv('ICOPAY_PAY_CURRENCY')) {
		$__cur = trim((string)getenv('ICOPAY_PAY_CURRENCY'));
	} elseif (getenv('ICOPAY_CHILL_PAY_CURRENCY')) {
		$__cur = trim((string)getenv('ICOPAY_CHILL_PAY_CURRENCY'));
	}
	define('ICOPAY_CHILL_PAY_CURRENCY', $__cur);
}

if (!defined('ICOPAY_PAY_CURRENCY')) {
	define('ICOPAY_PAY_CURRENCY', ICOPAY_CHILL_PAY_CURRENCY);
}

if (!defined('ICOPAY_CHILLPAY_ENABLED')) {
	define('ICOPAY_CHILLPAY_ENABLED', (ICOPAY_BROKER_SECRET !== '' && ICOPAY_COMP_ID !== ''));
}

if (!defined('ICOPAY_CCD_MERCHANT_CODE')) {
	$__ccd_m = '';
	if (!empty($GLOBALS['ICOPAY_CCD_MERCHANT_CODE'])) {
		$__ccd_m = trim((string)$GLOBALS['ICOPAY_CCD_MERCHANT_CODE']);
	}
	define('ICOPAY_CCD_MERCHANT_CODE', $__ccd_m);
}

if (!defined('ICOPAY_CCD_API_KEY')) {
	$__ccd_k = '';
	if (!empty($GLOBALS['ICOPAY_CCD_API_KEY'])) {
		$__ccd_k = trim((string)$GLOBALS['ICOPAY_CCD_API_KEY']);
	}
	define('ICOPAY_CCD_API_KEY', $__ccd_k);
}

if (!defined('ICOPAY_USE_LEGACY_CCD')) {
	$__legacy = false;
	if (!empty($GLOBALS['ICOPAY_USE_LEGACY_CCD'])) {
		$__legacy = (bool)$GLOBALS['ICOPAY_USE_LEGACY_CCD'];
	} elseif (getenv('ICOPAY_USE_LEGACY_CCD') === '1' || getenv('ICOPAY_USE_LEGACY_CCD') === 'true') {
		$__legacy = true;
	}
	define('ICOPAY_USE_LEGACY_CCD', $__legacy);
}

if (!defined('ICOPAY_INLINE_CHECKOUT')) {
	$__inline = true;
	if (isset($GLOBALS['ICOPAY_INLINE_CHECKOUT'])) {
		$__inline = (bool)$GLOBALS['ICOPAY_INLINE_CHECKOUT'];
	} elseif (getenv('ICOPAY_INLINE_CHECKOUT') === '0' || getenv('ICOPAY_INLINE_CHECKOUT') === 'false') {
		$__inline = false;
	}
	if (ICOPAY_USE_LEGACY_CCD) {
		$__inline = false;
	}
	define('ICOPAY_INLINE_CHECKOUT', $__inline);
}

if (!defined('ICOPAY_CHECKOUT_LANG')) {
	$__clang = '';
	if (!empty($GLOBALS['ICOPAY_CHECKOUT_LANG'])) {
		$__clang = trim((string)$GLOBALS['ICOPAY_CHECKOUT_LANG']);
	} elseif (getenv('ICOPAY_CHECKOUT_LANG')) {
		$__clang = trim((string)getenv('ICOPAY_CHECKOUT_LANG'));
	}
	define('ICOPAY_CHECKOUT_LANG', $__clang);
}

if (!defined('ICOPAY_DEFAULT_VENDOR')) {
	$__vendor = 'jpay';
	if (!empty($GLOBALS['ICOPAY_DEFAULT_VENDOR'])) {
		$__vendor = trim((string)$GLOBALS['ICOPAY_DEFAULT_VENDOR']);
	} elseif (getenv('ICOPAY_DEFAULT_VENDOR')) {
		$__vendor = trim((string)getenv('ICOPAY_DEFAULT_VENDOR'));
	}
	define('ICOPAY_DEFAULT_VENDOR', $__vendor);
}

if (!defined('ICOPAY_INTEGRATION_MODE')) {
	$__mode = 'unified';
	if (!empty($GLOBALS['ICOPAY_INTEGRATION_MODE'])) {
		$__mode = strtolower(trim((string)$GLOBALS['ICOPAY_INTEGRATION_MODE']));
	} elseif (getenv('ICOPAY_INTEGRATION_MODE')) {
		$__mode = strtolower(trim((string)getenv('ICOPAY_INTEGRATION_MODE')));
	}
	if (!in_array($__mode, array('unified', 'chillpay', 'jpay'), true)) {
		$__mode = 'unified';
	}
	define('ICOPAY_INTEGRATION_MODE', $__mode);
}

if (!defined('ICOPAY_BUYER_COUNTRY_ISO2')) {
	$__country = 'JP';
	if (!empty($GLOBALS['ICOPAY_BUYER_COUNTRY_ISO2'])) {
		$__country = strtoupper(trim((string)$GLOBALS['ICOPAY_BUYER_COUNTRY_ISO2']));
	} elseif (getenv('ICOPAY_BUYER_COUNTRY_ISO2')) {
		$__country = strtoupper(trim((string)getenv('ICOPAY_BUYER_COUNTRY_ISO2')));
	}
	define('ICOPAY_BUYER_COUNTRY_ISO2', $__country);
}

if (!defined('ICOPAY_CHECKOUT_UI_MODE')) {
	$__ui = '';
	if (!empty($GLOBALS['ICOPAY_CHECKOUT_UI_MODE'])) {
		$__ui = strtolower(trim((string)$GLOBALS['ICOPAY_CHECKOUT_UI_MODE']));
	} elseif (getenv('ICOPAY_CHECKOUT_UI_MODE')) {
		$__ui = strtolower(trim((string)getenv('ICOPAY_CHECKOUT_UI_MODE')));
	}
	if ($__ui === '' && defined('ICOPAY_INLINE_CHECKOUT') && !ICOPAY_INLINE_CHECKOUT) {
		$__ui = 'url';
	} elseif ($__ui === '') {
		$__ui = 'url';
	}
	if (!in_array($__ui, array('url', 'inline'), true)) {
		$__ui = 'url';
	}
	define('ICOPAY_CHECKOUT_UI_MODE', $__ui);
}
