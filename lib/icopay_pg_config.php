<?php
/**
 * Icopay broker (ChillPay CCD).
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
	$__cur = 'THB';
	if (!empty($GLOBALS['ICOPAY_CHILL_PAY_CURRENCY'])) {
		$__cur = trim((string)$GLOBALS['ICOPAY_CHILL_PAY_CURRENCY']);
	} elseif (getenv('ICOPAY_CHILL_PAY_CURRENCY')) {
		$__cur = trim((string)getenv('ICOPAY_CHILL_PAY_CURRENCY'));
	}
	define('ICOPAY_CHILL_PAY_CURRENCY', $__cur);
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
