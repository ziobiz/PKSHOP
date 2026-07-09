<?php
/**
 * ICOPAY unified inline checkout helpers.
 */
if (!defined('ICOPAY_PUBLIC_BASE')) {
	include_once dirname(__FILE__) . '/../lib/icopay_pg_config.php';
}

if (!function_exists('icopay_unified_api_client')) {
	function icopay_unified_api_client() {
		require_once dirname(__FILE__) . '/../lib/IcopayMerchantApi.php';
		return IcopayMerchantApi::fromConfig(array(
			'api_base_url' => ICOPAY_PUBLIC_BASE,
			'comp_id' => ICOPAY_COMP_ID,
			'broker_secret' => ICOPAY_BROKER_SECRET,
		));
	}
}

if (!function_exists('icopay_unified_payment_currency')) {
	function icopay_unified_payment_currency() {
		if (defined('ICOPAY_PAYMENT_CURRENCY') && ICOPAY_PAYMENT_CURRENCY !== '') {
			return ICOPAY_PAYMENT_CURRENCY;
		}
		if (function_exists('pkshop_get_payment_currency')) {
			return pkshop_get_payment_currency();
		}
		return 'JPY';
	}
}

if (!function_exists('icopay_unified_checkout_lang')) {
	function icopay_unified_checkout_lang() {
		if (defined('ICOPAY_CHECKOUT_LANG') && ICOPAY_CHECKOUT_LANG !== '') {
			return strtoupper(trim((string)ICOPAY_CHECKOUT_LANG));
		}
		return 'JPN';
	}
}

if (!function_exists('icopay_unified_buyer_country_iso2')) {
	function icopay_unified_buyer_country_iso2() {
		if (defined('ICOPAY_BUYER_COUNTRY_ISO2') && ICOPAY_BUYER_COUNTRY_ISO2 !== '') {
			return strtoupper(substr(trim((string)ICOPAY_BUYER_COUNTRY_ISO2), 0, 2));
		}
		return 'JP';
	}
}

if (!function_exists('icopay_unified_amount_from_usd')) {
	function icopay_unified_amount_from_usd($usd_total) {
		$currency = icopay_unified_payment_currency();
		if (function_exists('pkshop_convert_usd_amount')) {
			return (int)pkshop_convert_usd_amount($usd_total, $currency);
		}
		return (int)round((float)$usd_total);
	}
}

if (!function_exists('icopay_unified_normalize_phone')) {
	function icopay_unified_normalize_phone($phone) {
		$digits = preg_replace('/\D+/', '', (string)$phone);
		return $digits !== '' ? $digits : '0000000000';
	}
}

if (!function_exists('icopay_unified_buyer_from_post')) {
	function icopay_unified_buyer_from_post($post) {
		$email = isset($post['email']) ? trim((string)$post['email']) : '';
		$phone = icopay_unified_normalize_phone(isset($post['htel']) ? $post['htel'] : '');
		$country = icopay_unified_buyer_country_iso2();
		if (!empty($post['countryIso2'])) {
			$country = strtoupper(substr(trim((string)$post['countryIso2']), 0, 2));
		}
		if (strlen($country) !== 2) {
			$country = icopay_unified_buyer_country_iso2();
		}
		return array(
			'email' => $email,
			'phone' => $phone,
			'countryIso2' => $country,
		);
	}
}

if (!function_exists('icopay_unified_is_paid_status')) {
	function icopay_unified_is_paid_status($status) {
		$s = strtoupper(trim((string)$status));
		return in_array($s, array('PAID', 'SUCCESS', 'APPROVED', 'COMPLETED', 'COMPLETE'), true);
	}
}

if (!function_exists('icopay_unified_finalize_order')) {
	function icopay_unified_finalize_order($ediDate, $tid, $user_id, $api_category) {
		if ($ediDate === '' || $user_id === '') {
			return false;
		}
		if (!function_exists('curl_d')) {
			include_once dirname(__FILE__) . '/../include/com.php';
		}
		curl_d($api_category, '&Type=orderUpdate&ediDate=' . rawurlencode($ediDate) . '&tid=' . rawurlencode($tid));
		return true;
	}
}
