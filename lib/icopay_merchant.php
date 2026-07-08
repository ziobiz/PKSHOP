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
		'default_vendor' => defined('ICOPAY_DEFAULT_VENDOR') ? ICOPAY_DEFAULT_VENDOR : IcopayMerchantApi::VENDOR_JPAY,
		'integration_mode' => icopay_integration_mode(),
		'pay_currency' => defined('ICOPAY_PAY_CURRENCY') ? ICOPAY_PAY_CURRENCY : 'JPY',
		'buyer_country_iso2' => defined('ICOPAY_BUYER_COUNTRY_ISO2') ? ICOPAY_BUYER_COUNTRY_ISO2 : 'JP',
	);
}

function icopay_integration_mode(): string
{
	if (defined('ICOPAY_INTEGRATION_MODE') && ICOPAY_INTEGRATION_MODE !== '') {
		$mode = strtolower(trim((string)ICOPAY_INTEGRATION_MODE));
		if (in_array($mode, array('unified', 'chillpay', 'jpay'), true)) {
			return $mode;
		}
	}
	return IcopayMerchantApi::INTEGRATION_UNIFIED;
}

function icopay_checkout_ui_mode(): string
{
	if (defined('ICOPAY_CHECKOUT_UI_MODE') && ICOPAY_CHECKOUT_UI_MODE !== '') {
		$mode = strtolower(trim((string)ICOPAY_CHECKOUT_UI_MODE));
		if (in_array($mode, array('url', 'inline'), true)) {
			return $mode;
		}
	}
	return 'inline';
}

function icopay_api_checkout_active(): bool
{
	if (!defined('ICOPAY_CHILLPAY_ENABLED') || !ICOPAY_CHILLPAY_ENABLED) {
		return false;
	}
	if (defined('ICOPAY_USE_LEGACY_CCD') && ICOPAY_USE_LEGACY_CCD) {
		return false;
	}
	$cfg = icopay_merchant_config_array();
	if ($cfg['comp_id'] === '' || $cfg['broker_secret'] === '') {
		return false;
	}
	$ui = icopay_checkout_ui_mode();
	return $ui === 'url' || $ui === 'inline';
}

function icopay_url_checkout_active(): bool
{
	return icopay_api_checkout_active() && icopay_checkout_ui_mode() === 'url';
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
	return icopay_api_checkout_active() && icopay_checkout_ui_mode() === 'inline';
}

function icopay_unified_checkout_active(): bool
{
	return icopay_api_checkout_active() && icopay_integration_mode() === IcopayMerchantApi::INTEGRATION_UNIFIED;
}

/** URL 결제(전체 페이지 이동)용 payUrl — embed=1 은 제거/0 으로 변경 */
function icopay_pay_url_for_redirect(string $payUrl): string
{
	if ($payUrl === '') {
		return '';
	}
	$payUrl = preg_replace('/([?&])embed=1(&|$)/i', '$1embed=0$2', $payUrl);
	if (preg_match('/[?&]embed=/i', $payUrl)) {
		return $payUrl;
	}
	return $payUrl . (strpos($payUrl, '?') !== false ? '&' : '?') . 'embed=0';
}

/** prepare API 오류 메시지 — SPLIT_PAY_MODE 등 가맹 설정 안내 */
function icopay_format_prepare_error(array $prep): string
{
	$msg = isset($prep['message']) ? trim((string)$prep['message']) : 'prepare failed';
	$code = isset($prep['errorCode']) ? strtoupper(trim((string)$prep['errorCode'])) : '';
	if ($code === 'SPLIT_PAY_MODE') {
		return $msg . "\n\n"
			. 'ICOPAY 가맹 URL결제설정이 분할결제입니다. URL(redirect) 모드 대신 ICOPAY_CHECKOUT_UI_MODE=inline(통합 인라인)을 사용하세요.'
			. "\n또는 ICOPAY 본사에 URL결제설정·가맹 API 연동 채널(REDIRECT) 변경을 요청하세요.";
	}
	return $msg;
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

/** 통합 checkout prepare API 용 언어 코드 (ENG, KOR, JPN …). */
function icopay_resolve_checkout_lang_api(): string
{
	if (defined('ICOPAY_CHECKOUT_LANG') && ICOPAY_CHECKOUT_LANG !== '') {
		return icopay_map_lang_to_api_code((string)ICOPAY_CHECKOUT_LANG);
	}
	if (!empty($GLOBALS['ICOPAY_CHECKOUT_LANG'])) {
		return icopay_map_lang_to_api_code((string)$GLOBALS['ICOPAY_CHECKOUT_LANG']);
	}
	$site = 'en';
	if (!empty($_SESSION['lang'])) {
		$site = strtolower(trim((string)$_SESSION['lang']));
	} elseif (!empty($_GET['lang'])) {
		$site = strtolower(trim((string)$_GET['lang']));
	}
	return icopay_map_lang_to_api_code($site);
}

function icopay_map_lang_to_api_code(string $lang): string
{
	$lang = strtolower(trim($lang));
	$map = array(
		'en' => 'ENG',
		'eng' => 'ENG',
		'kr' => 'KOR',
		'ko' => 'KOR',
		'kor' => 'KOR',
		'jp' => 'JPN',
		'ja' => 'JPN',
		'jpn' => 'JPN',
		'ch' => 'CHN',
		'zh' => 'CHN',
		'cn' => 'CHN',
		'chn' => 'CHN',
		'th' => 'THA',
		'tha' => 'THA',
	);
	return isset($map[$lang]) ? $map[$lang] : 'ENG';
}

/**
 * 통합 prepare buyer(email·phone·countryIso2).
 *
 * @param array<string,mixed> $in
 * @return array{email:string,phone:string,countryIso2:string}
 */
function icopay_resolve_buyer(array $in = array()): array
{
	$cfg = icopay_merchant_config_array();
	$country = $cfg['buyer_country_iso2'];
	$email = '';
	$phone = '';

	if (isset($in['buyer']) && is_array($in['buyer'])) {
		$email = trim((string)($in['buyer']['email'] ?? ''));
		$phone = trim((string)($in['buyer']['phone'] ?? ''));
		if (!empty($in['buyer']['countryIso2'])) {
			$country = strtoupper(trim((string)$in['buyer']['countryIso2']));
		}
	}
	if ($email === '' && !empty($in['email'])) {
		$email = trim((string)$in['email']);
	}
	if ($phone === '' && !empty($in['phone'])) {
		$phone = trim((string)$in['phone']);
	}
	if ($email === '' && !empty($_POST['email'])) {
		$email = trim((string)$_POST['email']);
	}
	if ($phone === '' && !empty($_POST['htel'])) {
		$phone = trim((string)$_POST['htel']);
	}
	if ($email === '' && !empty($_POST['sndEmail'])) {
		$email = trim((string)$_POST['sndEmail']);
	}

	$phone = preg_replace('/\D+/', '', $phone);
	if ($phone === null) {
		$phone = '';
	}

	return array(
		'email' => $email,
		'phone' => $phone,
		'countryIso2' => $country !== '' ? $country : 'JP',
	);
}

function icopay_validate_buyer(array $buyer): ?string
{
	if (trim((string)($buyer['email'] ?? '')) === '') {
		return 'Buyer email is required for ICOPAY checkout.';
	}
	if (trim((string)($buyer['phone'] ?? '')) === '') {
		return 'Buyer phone is required for ICOPAY checkout.';
	}
	if (trim((string)($buyer['countryIso2'] ?? '')) === '') {
		return 'Buyer country (countryIso2) is required for ICOPAY checkout.';
	}
	return null;
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
		'amountUsd' => isset($extra['amountUsd']) ? (string)$extra['amountUsd'] : '',
		'currency' => 'JPY',
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
