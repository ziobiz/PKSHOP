<?php

namespace PingPong\Lib\Beans;
use EasySwoole\Spl\SplBean;

class OrderChangeStateBean extends SplBean
{
	public $orderId;
	public $status;
	public $customerId;
	public $email;
	public $orderKey;
	public $paymentMethod;
	public $currency;

	/**
	 * @return string[]
	 */
	protected function setKeyMapping(): array
	{
		return [
			'order_id' => 'id',
			'customer_id' => 'customerId',
			'payment_method' => 'paymentMethod',
			'order_key' => 'orderKey'
		];
	}


}