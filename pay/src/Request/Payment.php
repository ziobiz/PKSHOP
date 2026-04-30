<?php


namespace PingPong\src\Request;


use Exception;
use PingPong\src\Core\PPConfigs;
use PingPong\src\Core\PPXLog;
use PingPong\src\Request\RequestPayload\Payment\PaymentPayLoad;
use PingPong\src\Response\PPXPaymentResponse;

class Payment extends AbstractRequest
{
	//v2/payment/{transactionId}
	public const PATH = 'v2/payment/%s';

	protected $ppConfigs;

	protected $paymentPayload;

	protected $transactionId;


	/**
	 * Payment constructor.
	 * @param PPConfigs $ppConfigs
	 * @param string $transactionId
	 * @param PaymentPayLoad $paymentPayload
	 * @throws Exception
	 */
	public function __construct(PPConfigs $ppConfigs, string $transactionId, PaymentPayLoad $paymentPayload)
	{
		parent::__construct($ppConfigs->gateway);

		$this->ppConfigs = $ppConfigs;
		$paymentPayload->addProperty('transactionId', $transactionId);
		$paymentPayload->setSign($ppConfigs->salt, $paymentPayload->toArray());
		$this->paymentPayload = $paymentPayload;
		$this->transactionId = $transactionId;

	}


	/**
	 * @param callable|null $success
	 * @param callable|null $fail
	 * @return PPXPaymentResponse
	 * @throws Exception
	 */
	public function request(?callable $success = null, ?callable $fail = null):PPXPaymentResponse
	{
		$responseArray = $this->getHttpClient()->request($this->getRequestUrl(), $this->paymentPayload);

		PPXLog::write([
			'request' => $this->paymentPayload,
			'response' => $responseArray
		], false, 'ping_pong_refund.log');

		if ( isset($responseArray['description'], $responseArray['status'], $responseArray['code']) ) {
			return new PPXPaymentResponse($responseArray);
		}

		throw new Exception($responseArray['description'] ?? '退款失败', $responseArray['code'] ?? '-1');
	}

	/**
	 * @return string
	 */
	public function getRequestUrl(): string
	{
		$path = sprintf(self::PATH, $this->transactionId);

		return $this->gateway . $path;
	}


	/**
	 * @return mixed
	 */
	public function getPaymentPayload()
	{
		return $this->paymentPayload;
	}

	/**
	 * @return mixed
	 */
	public function getResponse()
	{
		return $this->response;
	}


}