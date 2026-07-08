<?php
/**
 * ICOPAY 가맹점 인라인 결제 API 클라이언트 (PHP 7.4+).
 * prepare → embed 스크립트 → postMessage / 웹훅 으로 완료 처리.
 */
final class IcopayMerchantApi
{
	public const VENDOR_CHILLPAY = 'chillpay';
	public const VENDOR_JPAY = 'jpay';
	public const INTEGRATION_UNIFIED = 'unified';
	public const HEADER_BROKER_SECRET = 'X-Icopay-Merchant-Broker-Secret';
	public const EMBED_TARGET_UNIFIED = 'icopay-checkout';

	private string $apiBase;
	private string $compId;
	private string $brokerSecret;

	public function __construct(string $apiBase, string $compId, string $brokerSecret)
	{
		$this->apiBase = rtrim(trim($apiBase), '/');
		$this->compId = trim($compId);
		$this->brokerSecret = trim($brokerSecret);
	}

	public static function fromConfig(array $cfg): self
	{
		return new self(
			(string)($cfg['api_base_url'] ?? ''),
			(string)($cfg['comp_id'] ?? ''),
			(string)($cfg['broker_secret'] ?? '')
		);
	}

	/**
	 * 통합 인라인 결제(권장) — 운영 PG(JPAY 등) 자동 분기.
	 * buyer: email, phone, countryIso2 필수.
	 *
	 * @param array{email?:string,phone?:string,countryIso2?:string} $buyer
	 * @return array{success:bool,data?:array,message?:string,errorCode?:string}
	 */
	public function prepareUnifiedCheckout(
		string $orderNo,
		$amount,
		array $buyer,
		string $currency = '',
		string $productName = '',
		string $lang = ''
	): array {
		return $this->postJson(
			'/api/middleware/v1/merchant/checkout/prepare',
			$this->buildUnifiedPrepareBody($orderNo, $amount, $buyer, $currency, $productName, $lang)
		);
	}

	/**
	 * 통합 리다이렉트 — buyer 필수, returnUrl/cancelUrl body 금지.
	 *
	 * @param array{email?:string,phone?:string,countryIso2?:string} $buyer
	 * @return array{success:bool,data?:array,message?:string,errorCode?:string}
	 */
	public function prepareUnifiedRedirectCheckout(
		string $orderNo,
		$amount,
		array $buyer,
		string $currency = '',
		string $productName = '',
		string $lang = ''
	): array {
		return $this->postJson(
			'/api/middleware/v1/merchant/checkout/redirect/prepare',
			$this->buildUnifiedPrepareBody($orderNo, $amount, $buyer, $currency, $productName, $lang)
		);
	}

	/** @return array{success:bool,data?:array,message?:string,errorCode?:string} */
	public function getUnifiedPaymentStatus(string $orderNo): array
	{
		$qs = http_build_query(array(
			'compId' => $this->compId,
			'orderNo' => $orderNo,
		));
		return $this->getJson('/api/middleware/v1/merchant/checkout/status?' . $qs);
	}

	/** @return array{success:bool,data?:array,message?:string,errorCode?:string} */
	public function getUnifiedRedirectPaymentStatus(string $orderNo): array
	{
		$qs = http_build_query(array(
			'compId' => $this->compId,
			'orderNo' => $orderNo,
		));
		return $this->getJson('/api/middleware/v1/merchant/checkout/redirect/status?' . $qs);
	}

	public function getUnifiedEmbedTargetId(): string
	{
		return self::EMBED_TARGET_UNIFIED;
	}

	public function getUnifiedEmbedScriptUrl(): string
	{
		return $this->apiBase . '/v1/embed-checkout/' . rawurlencode($this->compId);
	}

	public function buildUnifiedEmbedHtml(string $sessionToken, string $targetId = '', string $lang = ''): string
	{
		$target = $targetId !== '' ? $targetId : $this->getUnifiedEmbedTargetId();
		$tokEnc = htmlspecialchars($sessionToken, ENT_QUOTES, 'UTF-8');
		$src = htmlspecialchars($this->getUnifiedEmbedScriptUrl(), ENT_QUOTES, 'UTF-8');
		$targetEsc = htmlspecialchars($target, ENT_QUOTES, 'UTF-8');
		$html = '<div id="' . $targetEsc . '"></div>' . "\n"
			. '<script src="' . $src . '"'
			. ' data-session-token="' . $tokEnc . '"'
			. ' data-target="' . $targetEsc . '"';
		if ($lang !== '') {
			$html .= ' data-lang="' . htmlspecialchars(strtoupper($lang), ENT_QUOTES, 'UTF-8') . '"';
		}
		return $html . ' async defer charset="utf-8"></script>';
	}

	/** @return array{success:bool,data?:array,message?:string,errorCode?:string} */
	public function prepareInlineCheckout(
		string $vendor,
		string $orderNo,
		$amount,
		string $currency = '',
		string $productName = '',
		string $lang = ''
	): array {
		$path = $this->preparePath($vendor);
		$body = array(
			'compId' => $this->compId,
			'orderNo' => $orderNo,
			'amount' => $amount,
		);
		if ($currency !== '') {
			$body['currency'] = strtoupper($currency);
		}
		if ($productName !== '') {
			$body['productName'] = $productName;
		}
		if ($lang !== '') {
			$body['lang'] = strtolower($lang);
			$body['locale'] = strtolower($lang);
		}
		return $this->postJson($path, $body);
	}

	/** @return array{success:bool,data?:array,message?:string,errorCode?:string} */
	public function getPaymentStatus(string $vendor, string $orderNo): array
	{
		$path = $this->statusPath($vendor);
		$qs = http_build_query(array(
			'compId' => $this->compId,
			'orderNo' => $orderNo,
		));
		return $this->getJson($path . '?' . $qs);
	}

	public function getEmbedTargetId(string $vendor): string
	{
		return strtolower(trim($vendor)) === self::VENDOR_JPAY ? 'icopay-jpay-checkout' : 'icopay-pay-checkout';
	}

	public function getEmbedScriptUrl(string $vendor): string
	{
		$v = strtolower(trim($vendor));
		$embedPath = ($v === self::VENDOR_JPAY) ? '/v1/embed-jpay-pay/' : '/v1/embed-pay/';
		return $this->apiBase . $embedPath . rawurlencode($this->compId);
	}

	public function buildEmbedHtml(string $vendor, string $sessionToken, string $targetId = ''): string
	{
		$target = $targetId !== '' ? $targetId : $this->getEmbedTargetId($vendor);
		$tokEnc = htmlspecialchars($sessionToken, ENT_QUOTES, 'UTF-8');
		$src = htmlspecialchars($this->getEmbedScriptUrl($vendor), ENT_QUOTES, 'UTF-8');
		$targetEsc = htmlspecialchars($target, ENT_QUOTES, 'UTF-8');
		return '<div id="' . $targetEsc . '"></div>' . "\n"
			. '<script src="' . $src . '"'
			. ' data-session-token="' . $tokEnc . '"'
			. ' data-target="' . $targetEsc . '"'
			. ' async defer charset="utf-8"></script>';
	}

	/** @param array{email?:string,phone?:string,countryIso2?:string} $buyer */
	private function buildUnifiedPrepareBody(
		string $orderNo,
		$amount,
		array $buyer,
		string $currency,
		string $productName,
		string $lang
	): array {
		$body = array(
			'compId' => $this->compId,
			'orderNo' => $orderNo,
			'amount' => $amount,
			'buyer' => array(
				'email' => trim((string)($buyer['email'] ?? '')),
				'phone' => trim((string)($buyer['phone'] ?? '')),
				'countryIso2' => strtoupper(trim((string)($buyer['countryIso2'] ?? ''))),
			),
		);
		if ($currency !== '') {
			$body['currency'] = strtoupper($currency);
		}
		if ($productName !== '') {
			$body['productName'] = $productName;
		}
		if ($lang !== '') {
			$body['lang'] = strtoupper($lang);
		}
		return $body;
	}

	private function preparePath(string $vendor): string
	{
		return strtolower(trim($vendor)) === self::VENDOR_JPAY
			? '/api/middleware/v1/merchant/jpay/inline-checkout/prepare'
			: '/api/middleware/v1/merchant/chillpay/inline-checkout/prepare';
	}

	private function statusPath(string $vendor): string
	{
		return strtolower(trim($vendor)) === self::VENDOR_JPAY
			? '/api/middleware/v1/merchant/jpay/inline-checkout/status'
			: '/api/middleware/v1/merchant/chillpay/inline-checkout/status';
	}

	/** @return array{success:bool,data?:array,message?:string,errorCode?:string} */
	private function postJson(string $path, array $body): array
	{
		$url = $this->apiBase . $path;
		$json = json_encode($body, JSON_UNESCAPED_UNICODE);
		if ($json === false) {
			return array('success' => false, 'message' => 'JSON encode failed', 'errorCode' => 'LOCAL_ERROR');
		}
		$ch = curl_init($url);
		curl_setopt_array($ch, array(
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $json,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 45,
			CURLOPT_SSL_VERIFYPEER => 1,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Accept: application/json',
				self::HEADER_BROKER_SECRET . ': ' . $this->brokerSecret,
			),
		));
		$raw = curl_exec($ch);
		$errno = curl_errno($ch);
		$err = curl_error($ch);
		curl_close($ch);
		if ($errno !== 0) {
			return array('success' => false, 'message' => 'HTTP error: ' . $err, 'errorCode' => 'NETWORK_ERROR');
		}
		$decoded = json_decode((string)$raw, true);
		if (!is_array($decoded)) {
			return array('success' => false, 'message' => 'Invalid JSON response', 'errorCode' => 'PARSE_ERROR');
		}
		return $decoded;
	}

	/** @return array{success:bool,data?:array,message?:string,errorCode?:string} */
	private function getJson(string $pathWithQuery): array
	{
		$url = $this->apiBase . $pathWithQuery;
		$ch = curl_init($url);
		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 45,
			CURLOPT_SSL_VERIFYPEER => 1,
			CURLOPT_HTTPHEADER => array(
				'Accept: application/json',
				self::HEADER_BROKER_SECRET . ': ' . $this->brokerSecret,
			),
		));
		$raw = curl_exec($ch);
		$errno = curl_errno($ch);
		$err = curl_error($ch);
		curl_close($ch);
		if ($errno !== 0) {
			return array('success' => false, 'message' => 'HTTP error: ' . $err, 'errorCode' => 'NETWORK_ERROR');
		}
		$decoded = json_decode((string)$raw, true);
		if (!is_array($decoded)) {
			return array('success' => false, 'message' => 'Invalid JSON response', 'errorCode' => 'PARSE_ERROR');
		}
		return $decoded;
	}
}
