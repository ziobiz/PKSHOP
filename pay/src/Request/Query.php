<?php

namespace PingPong\src\Request;

use Exception;
use PingPong\src\Core\HttpClient;
use PingPong\src\Core\PPConfigs;
use PingPong\src\Core\PPSignType;
use PingPong\src\Core\PPXLog;
use PingPong\src\Response\PPXQueryResponse;
use PingPong\src\Signature\Sign;

class Query extends AbstractRequest
{
	public const PATH = 'v2/query';
	/**
	 * @var $ppConfigs PPConfigs
	 */
	protected $ppConfigs;
	protected $merchantTransactionId;
	protected $transactionId;
	protected $signType;
	protected $requestData;

	/**
	 * PPXPaymentQueryRequest constructor.
	 * @param PPConfigs $ppConfigs
	 * @param $merchantTransactionId
	 * @param $transactionId
	 * @param $signType
	 * @throws Exception
	 */
	public function __construct(PPConfigs $ppConfigs, $merchantTransactionId, $transactionId, $signType = PPSignType::SIGN_TYPE_MD5)
	{
		//init params
		$this->ppConfigs = $ppConfigs;
		$this->merchantTransactionId = $merchantTransactionId;
		$this->transactionId = $transactionId;
		$this->signType = $signType;
		$this->requestData = [
			'accId' => $this->ppConfigs->accId,
			'signType' => $this->signType,
			'transactionId' => $this->transactionId,
			'merchantTransactionId' => $this->merchantTransactionId,
		];

		$this->buildParams();

		parent:: __construct($ppConfigs->gateway);
	}

	public function getRequestUrl(): string
	{
		return $this->gateway . self::PATH;
	}

	/**
	 * @param callable|null $success
	 * @param callable|null $fail
	 * @return PPXQueryResponse
	 * @throws
	 */
	public function request(?callable $success = null, ?callable $fail = null): PPXQueryResponse
	{
		$responseArray = $this->getHttpClient()->request($this->getRequestUrl(), json_encode($this->requestData, JSON_THROW_ON_ERROR));
		PPXLog::write([
			'request' => $this->requestData,
			'response' => $responseArray
		], false, 'ping_pong_query.log');

		if ( isset($responseArray['description'], $responseArray['status']) ) {
			return new PPXQueryResponse($responseArray);
		}

		throw new Exception($responseArray['description'] ?? '交易失败', $responseArray['code'] ?? '-1');
	}

	/**
	 * @return array
	 * @throws Exception
	 */
	private function buildParams(): array
	{
		$signBuilder = $this->getSign();
		$data = $signBuilder->getSignatureProvide()->filter();
		$sign = $signBuilder->get(Sign::SIGN_TO_UPPER);
		$data['sign'] = $sign;
		$this->requestData = $data;

		return $data;
	}

	/**
	 * @throws Exception
	 */
	private function getSign(): Sign
	{
		return (new Sign($this->signType, $this->requestData, $this->ppConfigs->salt));
	}

	/**
	 * @return array
	 */
	public function getRequestData(): array
	{
		return $this->requestData;
	}


}
