<?php
/**
 * Icopay 인라인 결제 헬퍼 (설정·API·웹훅 공통).
 */
require_once dirname(__FILE__) . '/icopay_pg_config.php';
require_once dirname(__FILE__) . '/IcopayMerchantApi.php';

function icopay_merchant_config_array(): array
{
	return array(
		'api_base_url' => defined('ICOPAY_PUBLIC_BASE') ? ICOPAY_PUBLIC_BASE : 'https://api.icopay.co.kr',
		'comp_id' => defined('ICOPAY_COMP_ID') ? ICOPAY_COMP_ID : '',
		'broker_secret' => defined('ICOPAY_BROKER_SECRET') ? ICOPAY_BROKER_SECRET : '',
		'default_vendor' => defined('ICOPAY_DEFAULT_VENDOR') ? ICOPAY_DEFAULT_VENDOR : IcopayMerchantApi::VENDOR_CHILLPAY,
	);
}

function icopay_merchant_api(): ?IcopayMerchantApi
{
	if (!defined('ICOPAY_CHILLPAY_ENABLED') || !ICOPAY_CHILLPAY_ENABLED) {
		return null;
	}
	$cfg = icopay_merchant_config_array();
	if ($cfg['comp_id'] === '' || $cfg['broker_secret'] === '') {
		return null;
	}
	return IcopayMerchantApi::fromConfig($cfg);
}

function icopay_inline_checkout_active(): bool
{
	if (!defined('ICOPAY_CHILLPAY_ENABLED') || !ICOPAY_CHILLPAY_ENABLED) {
		return false;
	}
	if (defined('ICOPAY_USE_LEGACY_CCD') && ICOPAY_USE_LEGACY_CCD) {
		return false;
	}
	return !defined('ICOPAY_INLINE_CHECKOUT') || ICOPAY_INLINE_CHECKOUT;
}

/**
 * 쇼핑몰 $_SESSION['lang'] (en|kr|jp|ch) → ICOPAY 결제창 언어 코드.
 * ICOPAY/ChillPay 가맹점 설정에서 허용된 언어만 실제 UI에 반영됩니다.
 */
function icopay_resolve_checkout_lang(): string
{
	if (defined('ICOPAY_CHECKOUT_LANG') && ICOPAY_CHECKOUT_LANG !== '') {
		return strtolower(trim((string)ICOPAY_CHECKOUT_LANG));
	}
	if (!empty($GLOBALS['ICOPAY_CHECKOUT_LANG'])) {
		return strtolower(trim((string)$GLOBALS['ICOPAY_CHECKOUT_LANG']));
	}
	$site = 'en';
	if (!empty($_SESSION['lang'])) {
		$site = strtolower(trim((string)$_SESSION['lang']));
	} elseif (!empty($_GET['lang'])) {
		$site = strtolower(trim((string)$_GET['lang']));
	}
	$map = array(
		'en' => 'en',
		'kr' => 'ko',
		'ko' => 'ko',
		'jp' => 'ja',
		'ja' => 'ja',
		'ch' => 'zh',
		'zh' => 'zh',
		'cn' => 'zh',
		'th' => 'th',
	);
	return isset($map[$site]) ? $map[$site] : 'en';
}

function icopay_append_lang_to_pay_url(string $payUrl, string $lang): string
{
	if ($payUrl === '' || $lang === '') {
		return $payUrl;
	}
	if (preg_match('/[?&]lang=/i', $payUrl)) {
		return $payUrl;
	}
	$sep = (strpos($payUrl, '?') !== false) ? '&' : '?';
	return $payUrl . $sep . 'lang=' . rawurlencode($lang);
}

function icopay_legacy_ccd_active(): bool
{
	if (!defined('ICOPAY_CHILLPAY_ENABLED') || !ICOPAY_CHILLPAY_ENABLED) {
		return false;
	}
	if (defined('ICOPAY_USE_LEGACY_CCD') && ICOPAY_USE_LEGACY_CCD) {
		return defined('ICOPAY_CCD_MERCHANT_CODE') && ICOPAY_CCD_MERCHANT_CODE !== ''
			&& defined('ICOPAY_CCD_API_KEY') && ICOPAY_CCD_API_KEY !== '';
	}
	return false;
}

/** @param array<string,mixed> $payload */
function icopay_notify_payload_is_paid(array $payload): bool
{
	foreach (array('paid', 'Paid', 'isPaid', 'paymentSuccess', 'success') as $k) {
		if (isset($payload[$k])) {
			$v = $payload[$k];
			if ($v === true || $v === 1 || $v === '1' || $v === 'Y' || $v === 'y') {
				return true;
			}
		}
	}
	foreach (array('status', 'Status', 'paymentStatus', 'orderStatus', 'payStatus') as $k) {
		if (!isset($payload[$k])) {
			continue;
		}
		$v = strtoupper(trim((string)$payload[$k]));
		if (in_array($v, array('PAID', 'SUCCESS', 'SUCCEEDED', 'COMPLETED', 'APPROVED', 'CAPTURED'), true)) {
			return true;
		}
		if (in_array($v, array('FAIL', 'FAILED', 'CANCEL', 'CANCELLED', 'DECLINED'), true)) {
			return false;
		}
	}
	return false;
}

/** @param array<string,mixed> $payload */
function icopay_notify_extract_order_no(array $payload): string
{
	foreach (array('orderNo', 'order_no', 'merchantOrderId', 'merchant_order_id', 'ediDate', 'ordNo') as $k) {
		if (!empty($payload[$k])) {
			return trim((string)$payload[$k]);
		}
	}
	if (isset($payload['data']) && is_array($payload['data'])) {
		return icopay_notify_extract_order_no($payload['data']);
	}
	return '';
}

/** @param array<string,mixed> $payload */
function icopay_notify_extract_transaction_id(array $payload, string $fallbackOrderNo): string
{
	foreach (array('transactionId', 'transaction_id', 'tid', 'TxnId', 'paymentId', 'pgTxnId') as $k) {
		if (!empty($payload[$k])) {
			return trim((string)$payload[$k]);
		}
	}
	if (isset($payload['data']) && is_array($payload['data'])) {
		$inner = icopay_notify_extract_transaction_id($payload['data'], '');
		if ($inner !== '') {
			return $inner;
		}
	}
	return $fallbackOrderNo;
}

function icopay_json_response(array $payload, int $httpCode = 200): void
{
	while (ob_get_level() > 0) {
		ob_end_clean();
	}
	http_response_code($httpCode);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	exit;
}

/**
 * 카드 + Icopay 활성 시 order_ok2 가 JSON 으로 종료해야 할 때 공통 응답.
 *
 * @param array<string,mixed> $extra
 */
function icopay_order_save_json_exit($ediDate, $ordNo, $new_num, $total_settle_num, $title_11111, array $extra = array()): void
{
	$_SESSION['icopay_pending_checkout'] = array(
		'ediDate' => $ediDate,
		'amount' => (string)$total_settle_num,
		'ordNo' => $ordNo,
		'new_num' => $new_num,
		'description' => $title_11111 !== '' ? $title_11111 : '',
		'ts' => time(),
	);
	$body = array_merge(array(
		'result' => '1',
		'icopayChillpay' => true,
		'ediDate' => $ediDate,
		'ordNo' => $ordNo,
		'new_num' => $new_num,
		'amount' => $total_settle_num,
		'description' => $title_11111 !== '' ? $title_11111 : '',
	), $extra);
	icopay_json_response($body);
}

function icopay_should_return_card_json(): bool
{
	if (!defined('ICOPAY_CHILLPAY_ENABLED') || !ICOPAY_CHILLPAY_ENABLED) {
		return false;
	}
	if (!isset($_POST['paymentkind']) || (string)$_POST['paymentkind'] !== '1') {
		return false;
	}
	if (isset($GLOBALS['icopay_order_state']) && $GLOBALS['icopay_order_state'] === '결제완료') {
		return false;
	}
	return true;
}

function icopay_apply_order_paid(string $orderNo, string $tid = ''): void
{
	global $api_category;
	if ($orderNo === '') {
		return;
	}
	if ($tid === '') {
		$tid = $orderNo;
	}
	if (!isset($api_category) || $api_category === '') {
		include_once dirname(__FILE__) . '/../include/get_balance.php';
	}
	if (isset($api_category) && $api_category !== '') {
		curl_d($api_category, '&Type=orderUpdate&ediDate=' . rawurlencode($orderNo) . '&tid=' . rawurlencode($tid));
	}
}
