<?php

namespace PingPong\src\Request;

use Exception;
use PingPong\src\Core\HttpClient;
use PingPong\src\Core\PPConfigs;
use PingPong\src\Core\PPXLog;
use PingPong\src\Request\RequestPayload\CheckOut\CheckOutPayLoad;
use PingPong\src\Response\PPXCheckOutResponse;

/**
 * Class CheckOut
 * @package PingPong\src\Request
 */
class CheckOut extends AbstractRequest
{
	public const PATH = 'v2/checkout';
	/**
	 * @var $checkOutPayLoad CheckOutPayLoad
	 */
	public $checkOutPayLoad;

	public function __construct(PPConfigs $ppConfigs, CheckOutPayLoad $checkOutPayLoad)
	{
		$checkOutPayLoad->setSign($ppConfigs->salt);
		$this->checkOutPayLoad = $checkOutPayLoad;

		parent::__construct($ppConfigs->gateway);
	}

	public function getRequestUrl(): string
	{
		return $this->gateway . self::PATH;
	}

	/**
	 * @param callable|null $success
	 * @param callable|null $fail
	 * @return PPXCheckOutResponse
	 * @throws Exception
	 */
	public function request(?callable $success = null, ?callable $fail = null): PPXCheckOutResponse
	{
		$responseArray = $this->getHttpClient()->request($this->getRequestUrl(), $this->checkOutPayLoad);
		$responseCode = $responseArray['code'] ?? null;

		PPXLog::write([
			'request' => $this->checkOutPayLoad,
			'response' => $responseArray
		], false, 'checkout_request.log');

		if ( is_null($responseCode) ) {
			throw new Exception('request has some thing wrong');
		}

		if ( !in_array((string)$responseCode, [ '000000', '001000', '002000' ], true) ) {
			throw new Exception('request filed');
		}

		if ( empty($responseArray['token']) ) {
			throw new Exception('request token failed');
		}

		return new PPXCheckOutResponse(
			$responseArray['accId'],
			$responseArray['clientId'],
			$responseArray['code'],
			$responseArray['description'],
			$responseArray['innerJsUrl'],
			$responseArray['merchantTransactionId'],
			$responseArray['paymentUrl'],
			$responseArray['sign'],
			$responseArray['signType'],
			$responseArray['token']
		);
	}


}
