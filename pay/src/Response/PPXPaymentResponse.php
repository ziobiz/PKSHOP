<?php


namespace PingPong\src\Response;

/**
 * Class PPXPaymentResponse
 * @package PingPong\src\Response
 */
class PPXPaymentResponse extends HttpResponse
{
	public $clientId;
	public $accId;
	public $transactionId;
	public $relateTransactionId;
	public $merchantTransactionId;
	public $code;
	public $description;
	public $paymentType;
	public $currency;
	public $amount;
	public $transactionTime;
	public $completeTime;
	public $status;
	public $signType;
	public $sign;
	public $remark;

	protected function setKeyMapping(): array
	{
		return [
			'relate_transaction_id'=>'relateTransactionId',
			'transaction_id'=>'transactionId',
			'merchant_transaction_id'=>'merchantTransactionId',
			'merchantTransaction_id'=>'merchantTransactionId',
			'merchantTransaction_Id'=>'merchantTransactionId',
			'payment_type'=>'paymentType',
			'transaction_time'=>'transactionTime',
			'sign_type'=>'signType',
		];
	}


	/**
	 * @return string
	 * @throws
	 */
	public function __toString(): string
	{
		return parent::__toString();
	}


}