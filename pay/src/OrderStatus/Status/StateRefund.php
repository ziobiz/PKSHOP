<?php

namespace PingPong\src\OrderStatus\Status;

use PingPong\src\Core\PPXStatus;
use PingPong\src\OrderStatus\AbstractOrderState;

class StateRefund extends AbstractOrderState
{
	/**
	 * 能否改变状态
	 * @param string $currentPingPongStatus
	 * @return bool
	 */
    public function canChange(string $currentPingPongStatus): bool
    {
        //当前交易号存在记录 则比较状态 在allowed中状态则允许修改
        //当前ping-pong状态能转变为ping-pong success 的状态集合
        $allowed = [
            PPXStatus::STATUS_ORDER_SUCCESS,
        ];

        if (in_array($currentPingPongStatus, $allowed, true)) {
            return true;
        }

        return false;
    }

}
