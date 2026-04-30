<?php


namespace PingPong\src\Response;

/**
 * Class PPXS2SPayResponse
 * @package PingPong\src\Response
 */
class PPXS2SPayResponse extends HttpResponse
{
	public $clientId = '';
	public $accId = '';
	public $transactionId = '';
	public $merchantTransactionId = '';
	public $code = '';
	public $description = '';
	public $paymentType = '';
	public $currency = '';
	public $amount = '';
	public $transactionTime = '';
	public $completeTime = '';
	public $status = '';
	public $signType = '';
	public $sign = '';
	public $remark;
	public $threeDSecure = '';
	public $acsUrl = '';
	public $paReq;
	public $termUrl = '';
	public $requestMethod = '';
	public $md = '';
	public $connector = '';
	public $threedDHighLevelParams = '';


}