<?php
/**
 * Icopay → ChillPay (middleware) HTTP 헬퍼.
 */
if (!defined('ICOPAY_PUBLIC_BASE')) {
	include_once dirname(__FILE__) . '/../lib/icopay_pg_config.php';
}

function icopay_chillpay_config_url() {
	return ICOPAY_PUBLIC_BASE . '/api/middleware/v1/pg/chillpay/config';
}

function icopay_chillpay_request_url() {
	return ICOPAY_PUBLIC_BASE . '/api/middleware/v1/pg/chillpay/request';
}

function icopay_chillpay_http_json($method, $url, $headers, $body_array) {
	$ch = curl_init($url);
	$h = array_merge(array('Accept: application/json'), $headers);
	if ($method === 'POST') {
		$json = json_encode($body_array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$h[] = 'Content-Type: application/json; charset=utf-8';
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	} else {
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
	}
	curl_setopt_array($ch, array(
		CURLOPT_HTTPHEADER => $h,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 45,
		CURLOPT_SSL_VERIFYPEER => 1,
	));
	$raw = curl_exec($ch);
	$err = curl_error($ch);
	$code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	$decoded = is_string($raw) ? json_decode($raw, true) : null;
	return array('httpCode' => $code, 'raw' => $raw, 'json' => $decoded, 'curlError' => $err);
}

function icopay_chillpay_fetch_pg_config() {
	if (!ICOPAY_CHILLPAY_ENABLED) {
		return null;
	}
	$r = icopay_chillpay_http_json('GET', icopay_chillpay_config_url(), array(
		'X-Icopay-Merchant-Broker-Secret: ' . ICOPAY_BROKER_SECRET,
	), array());
	if ($r['httpCode'] >= 400 || !is_array($r['json']) || empty($r['json']['success'])) {
		return null;
	}
	return isset($r['json']['data']) && is_array($r['json']['data']) ? $r['json']['data'] : null;
}
