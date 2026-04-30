<?php


namespace PingPong\Lib\Beans;


use EasySwoole\Spl\SplBean;

class PingPongPaymentBean extends SplBean
{
	public $id;
	public $orderId;
	public $transactionId;
	public $ppStatus;
	public $description;
	public $queryResponse;
	public $notifyResponse;

	/**
	 * @return string[]
	 */
	protected function setKeyMapping(): array
	{
		return [
			'order_id' => 'orderId',
			'transaction_id' => 'transactionId',
			'pp_status' => 'ppStatus',
			'query_response' => 'queryResponse',
			'notify_response' => 'notifyResponse',
		];
	}


}