<?php
declare(strict_types = 1);

namespace PingPong\src\Response;

class PPXNotifyResponse extends AbstractPPXResponse
{
	public $notificationUrl;
	public $amount;
	public $clientId;
	public $code;
	public $threeDSecure;
	public $sign;
	public $description;
	public $transactionTime;
	public $transactionId;
	public $checkoutType;
	public $paymentType;
	public $token;
	public $outFlowId;
	public $relateOutFlowId;
	public $merchantTransactionId;
	public $accId;
	public $signType;
	public $currency;
	public $status;
	public $curOutFlowId;
	public $curMerchantTransactionId;


	/**
	 * @return string
	 */
	public function __toString(): string
	{
		$str = $this->toString();
		if ( !is_string($str) ) {
			return '';
		}

		return $str;
	}

	/**
	 * @return false|string
	 */
	public function toString()
	{
		return json_encode(get_object_vars($this));
	}

	/**
	 * @return mixed
	 */
	public function getNotificationUrl()
	{
		return $this->notificationUrl;
	}

	/**
	 * @return mixed
	 */
	public function getAmount()
	{
		return $this->amount;
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
	public function getThreeDSecure()
	{
		return $this->threeDSecure;
	}

	/**
	 * @return mixed
	 */
	public function getSign()
	{
		return $this->sign;
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
	public function getTransactionTime()
	{
		return $this->transactionTime;
	}

	/**
	 * @return mixed
	 */
	public function getTransactionId()
	{
		return $this->transactionId;
	}

	/**
	 * @return mixed
	 */
	public function getCheckoutType()
	{
		return $this->checkoutType;
	}

	/**
	 * @return mixed
	 */
	public function getPaymentType()
	{
		return $this->paymentType;
	}

	/**
	 * @return mixed
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * @return mixed
	 */
	public function getOutFlowId()
	{
		return $this->outFlowId;
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
	public function getAccId()
	{
		return $this->accId;
	}

	/**
	 * @return mixed
	 */
	public function getSignType()
	{
		return $this->signType;
	}

	/**
	 * @return mixed
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

	/**
	 * @return mixed
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * @return mixed
	 */
	public function getRelateOutFlowId()
	{
		return $this->relateOutFlowId;
	}

	/**
	 * @return mixed
	 */
	public function getCurOutFlowId()
	{
		return $this->curOutFlowId;
	}

	/**
	 * @return mixed
	 */
	public function getCurMerchantTransactionId()
	{
		return $this->curMerchantTransactionId;
	}




}
