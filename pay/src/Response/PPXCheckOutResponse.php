<?php

namespace PingPong\src\Response;

use EasySwoole\Spl\SplBean;

/**
 * checkout 参数返回
 * Class PPXCheckOutResponse
 * @package PingPong\src\Response
 */
class PPXCheckOutResponse extends SplBean
{
	protected $accId;
	protected $clientId;
	protected $code;
	protected $description;
	protected $innerJsUrl;
	protected $merchantTransactionId;
	protected $paymentUrl;
	protected $sign;
	protected $signType;
	protected $token;

	/**
	 * PPXCheckOutResponse constructor.
	 * @param $accId
	 * @param $clientId
	 * @param $code
	 * @param $description
	 * @param $innerJsUrl
	 * @param $merchantTransactionId
	 * @param $paymentUrl
	 * @param $sign
	 * @param $signType
	 * @param $token
	 */
	public function __construct($accId, $clientId, $code, $description, $innerJsUrl, $merchantTransactionId, $paymentUrl, $sign, $signType, $token)
	{
		parent::__construct(compact(
			'accId',
			'clientId',
			'code',
			'description',
			'innerJsUrl',
			'merchantTransactionId',
			'paymentUrl',
			'sign',
			'signType',
			'token',
        ));
	}

	public function toString()
	{
		return json_encode(get_object_vars($this));
	}

	public function __toString()
	{
		return $this->toString();
	}

	/**
	 * @return mixed
	 */
	public function getAccId()
	{
		return $this->accId;
	}

	/**
	 * @return mixed
	 */
	public function getClientId()
	{
		return $this->clientId;
	}

	/**
	 * @return mixed
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @return mixed
	 */
	public function getInnerJsUrl()
	{
		return $this->innerJsUrl;
	}

	/**
	 * @return mixed
	 */
	public function getMerchantTransactionId()
	{
		return $this->merchantTransactionId;
	}

	/**
	 * @return mixed
	 */
	public function getPaymentUrl()
	{
		return $this->paymentUrl;
	}

	/**
	 * @return mixed
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * @return string
	 */
	public function getModel(): string
	{
		if ( false !== stripos($this->getPaymentUrl(), "test") ) {
			$env = 'test';
		} elseif ( false !== stripos($this->getPaymentUrl(), "sandbox") ) {
			$env = 'sandbox';
		} else {
			$env = 'build';
		}

		return $env;
	}
}
