<?php

namespace PingPong\src\OrderStatus\Status;

use Exception;
use PingPong\src\Core\PPConst;
use PingPong\src\Core\PPXStatus;
use PingPong\src\OrderStatus\AbstractOrderState;
use PingPong\src\Payment\OrderPayment;

class StateReview extends AbstractOrderState
{
	/**
	 * 能否改变状态
	 * @param string $currentPingPongStatus
	 * @return bool
	 */
    public function canChange(string $currentPingPongStatus): bool
    {
        //当前ping-pong状态能转变为ping-pong Review 的状态集合
        $allowed = [
            PPXStatus::STATUS_ORDER_PROCESSING,
            PPConst::STATUS_ORDER_PENDING,
        ];
        if (in_array($currentPingPongStatus, $allowed, true)) {
            return true;
        }

        return false;
    }


}
