<?php

namespace PingPong\src\OrderStatus;

/**
 * 订单状态修改抽象类
 * Class AbstractOrderState
 * @package PingPong\src\OrderStatus
 */
abstract class AbstractOrderState
{

	abstract public function canChange(string $currentPingPongStatus): bool;

//	abstract public function change(): bool;

//	/**
//	 * 修改订单状态
//	 * @param string $pingPongStatus
//	 * @param string $comment
//	 * @param bool $isCustomerNotified
//	 * @throws Exception
//	 */
//	public function setStatus(string $pingPongStatus, $comment = '', $isCustomerNotified = false): void
//	{
//		//ping-pong状态转化为本地状态
//		$localTargetStatus = (new LocalStatus($this->scopeConfig))->getLocalStatusFromPPStatus($pingPongStatus);
//		//获取指定订单当前m2状态
//		$localCurrentStatus = $this->order->getStatus();
//		if ( strcasecmp($localCurrentStatus, $localTargetStatus) === 0 ) {
//			return;
//		}
//
//		$this->order->addStatusToHistory($localTargetStatus, $comment, $isCustomerNotified)->save();
//	}
//
//	/**
//	 * @return mixed|null
//	 */
//	public function getLastPingPongStatus()
//	{
//		return $this->pingPongPayment->getData('pp_status');
//	}
//
//	/**
//	 * 记录ping-pong返回的支付信息
//	 * @return PaymentLogModel
//	 */
//	public function addPayment()
//	{
//		$queryResponse = '{}';
//		$notifyResponse = '';
//
//		if ( $this->response instanceof PPXQueryResponse ) {
//			$queryResponse = $this->response->toString();
//		}
//
//		if ( $this->response instanceof PPXNotifyResponse ) {
//			$notifyResponse = $this->response;
//		}
//
//		//新增记录
//		if () {
//			return OrderPayment::addOne(
//				$this->order->getEntityId(),
//				$this->response->getTransactionId(),
//				$this->response->getStatus(),
//				$queryResponse,
//				$notifyResponse
//			);
//		}
//
//		//更新记录
//		$data = [
//			'id' => $this->pingPongPayment->getId(),
//			'order_id' => $this->order->getEntityId(),
//			'order_increment_id' => $this->order->getIncrementId(),
//			'transaction_id' => $this->response->getTransactionId(),
//			'pp_status' => $this->response->getStatus(),
//		];
//
//		if ( !empty($queryResponse) ) {
//			$data['query_response'] = $queryResponse;
//		}
//
//		if ( !empty($queryResponse) ) {
//			$data['notify_response'] = $notifyResponse;
//		}
//
//		$this->pingPongPayment->setData($data);
//
//		return OrderPayment::updateWithObject($this->pingPongPayment);
//	}
}
