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

if (!function_exists('icopay_unified_split_name_parts')) {
	/**
	 * 주문서 firstName(buyername)·Last Name(buyername_l) → ICOPAY buyer name 필드.
	 * 규칙: 첫 단어 → lastName, 나머지 → firstName. 한 단어만 있으면 양쪽에 동일 값.
	 *
	 * @param array<string,mixed> $post
	 * @return array{firstName:string,lastName:string,name:string}
	 */
	function icopay_unified_split_name_parts($post) {
		$first = '';
		$last = '';
		$name = '';

		if (!empty($post['buyer']['name'])) {
			$name = trim((string)$post['buyer']['name']);
		} elseif (!empty($post['name'])) {
			$name = trim((string)$post['name']);
		}

		if (!empty($post['buyer']['firstName'])) {
			$first = trim((string)$post['buyer']['firstName']);
		} elseif (!empty($post['firstName'])) {
			$first = trim((string)$post['firstName']);
		} elseif (isset($post['buyername'])) {
			$first = trim((string)$post['buyername']);
		}

		if (!empty($post['buyer']['lastName'])) {
			$last = trim((string)$post['buyer']['lastName']);
		} elseif (!empty($post['lastName'])) {
			$last = trim((string)$post['lastName']);
		} elseif (isset($post['buyername_l'])) {
			$last = trim((string)$post['buyername_l']);
		}

		if ($first !== '' && $last === '') {
			$parts = preg_split('/\s+/u', $first, -1, PREG_SPLIT_NO_EMPTY);
			if (is_array($parts) && count($parts) >= 2) {
				$last = $parts[0];
				$first = implode(' ', array_slice($parts, 1));
			} else {
				$last = $first;
			}
		} elseif ($last !== '' && $first === '') {
			$parts = preg_split('/\s+/u', $last, -1, PREG_SPLIT_NO_EMPTY);
			if (is_array($parts) && count($parts) >= 2) {
				$last = $parts[0];
				$first = implode(' ', array_slice($parts, 1));
			} else {
				$first = $last;
			}
		}

		if ($name === '') {
			$name = trim($last . ' ' . $first);
		}
		if ($name === '') {
			$name = $first !== '' ? $first : $last;
		}
		if (($first === '' || $last === '') && $name !== '') {
			$parts = preg_split('/\s+/u', $name, -1, PREG_SPLIT_NO_EMPTY);
			if (is_array($parts) && count($parts) >= 2) {
				if ($last === '') {
					$last = $parts[0];
				}
				if ($first === '') {
					$first = implode(' ', array_slice($parts, 1));
				}
			} else {
				if ($first === '') {
					$first = $name;
				}
				if ($last === '') {
					$last = $name;
				}
			}
		}

		return array(
			'firstName' => $first,
			'lastName' => $last,
			'name' => $name,
		);
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
		$names = icopay_unified_split_name_parts(is_array($post) ? $post : array());
		$buyer = array(
			'email' => $email,
			'phone' => $phone,
			'countryIso2' => $country,
		);
		if ($names['name'] !== '') {
			$buyer['name'] = $names['name'];
		}
		if ($names['firstName'] !== '') {
			$buyer['firstName'] = $names['firstName'];
		}
		if ($names['lastName'] !== '') {
			$buyer['lastName'] = $names['lastName'];
		}
		return $buyer;
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
