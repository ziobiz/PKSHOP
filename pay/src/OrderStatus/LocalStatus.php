<?php

namespace PingPong\src\OrderStatus;

use Exception;
use PingPong\src\Core\PPConfigs;
use PingPong\src\Core\PPXStatus;

class LocalStatus extends PPConfigs
{
	protected $map;

	public function __construct(array $data)
	{
		parent::__construct($data);

		$this->initMap();
	}

	/**
	 * 初始化状态映射 ping pong status -> local status
	 */
	private function initMap(): void
	{
		$this->map = [
			PPXStatus::STATUS_ORDER_FAILED => $this->stateFailed,
			PPXStatus::STATUS_ORDER_REVIEW => $this->stateReview,
			PPXStatus::STATUS_ORDER_SUCCESS => $this->stateSuccess,
			PPXStatus::STATUS_ORDER_PROCESSING => $this->stateProcessing,
			PPXStatus::STATUS_ORDER_REFUND => $this->stateRefunded,
		];
	}

	/**
	 * @param string $pingPongStatus
	 * @return string
	 * @throws Exception
	 */
	public function getLocalStatusFromPPStatus(string $pingPongStatus): string
	{
		if ( !isset($this->map[$pingPongStatus]) ) {
			throw new Exception('status error');
		}

		return $this->map[$pingPongStatus];
	}


	/**
	 * @param string $m2Status
	 * @return string
	 * @throws Exception
	 */
	public function getPPStatusFromLocalStatus(string $m2Status): string
	{
		$map = array_flip($this->map);
		if ( !isset($map[$m2Status]) ) {
			throw new Exception('status error');
		}
		return $map[$m2Status];
	}

}
