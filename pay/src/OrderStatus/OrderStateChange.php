<?php

namespace PingPong\src\OrderStatus;

use Exception;
use PingPong\src\Core\PPConfigs;
use PingPong\src\Core\PPXStatus;
use PingPong\src\OrderStatus\Status\StateFailed;
use PingPong\src\OrderStatus\Status\StateProcessing;
use PingPong\src\OrderStatus\Status\StateRefund;
use PingPong\src\OrderStatus\Status\StateReview;
use PingPong\src\OrderStatus\Status\StateSuccess;


class OrderStateChange
{
	protected $provides = [];

	protected $scopeConfig;

	/**
	 * OrderStateChange constructor.
	 * @param PPConfigs $configs
	 */
	public function __construct(PPConfigs $configs)
	{
		$this->provides = [
			PPXStatus::STATUS_ORDER_FAILED => StateFailed::class,
			PPXStatus::STATUS_ORDER_PROCESSING => StateProcessing::class,
			PPXStatus::STATUS_ORDER_REFUND => StateRefund::class,
			PPXStatus::STATUS_ORDER_REVIEW => StateReview::class,
			PPXStatus::STATUS_ORDER_SUCCESS => StateSuccess::class
		];

		$this->scopeConfig = $configs;

	}

	/**
	 * @param string $needChangePingPongState
	 * @return mixed
	 * @throws Exception
	 */
	public function getProvide(string $needChangePingPongState): AbstractOrderState
	{
		if ( !isset($this->provides[$needChangePingPongState]) ) {
			throw new Exception('状态映射错误');
		}
		$clazz = $this->provides[$needChangePingPongState];

		return new $clazz();
	}


	/**
	 * 能否改变状态：数据库状态->服务器获得状态
	 * @param string $currentChangePingPongState 当前将要改变的ping pong pay 状态 即notify或者query 从服务器获得状态
	 * @param string $lastPingPongStatus 上一次记录的状态 即 数据库状态
	 * @return bool
	 * @throws Exception
	 */
	public function canChange(string $currentChangePingPongState, string $lastPingPongStatus): bool
	{
		$orderState = $this->getProvide($currentChangePingPongState);

		return $orderState->canChange($lastPingPongStatus);
	}
}
