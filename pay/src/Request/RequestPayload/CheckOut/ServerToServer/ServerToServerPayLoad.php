<?php


namespace PingPong\src\Request\RequestPayload\CheckOut\ServerToServer;


use EasySwoole\Spl\SplBean;
use PingPong\src\Core\PPSignType;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfoPayLoad;
use PingPong\src\Request\RequestPayload\HttpPayLoad;

class ServerToServerPayLoad extends HttpPayLoad
{
	public $accId;
	public $signType = PPSignType::SIGN_TYPE_MD5;
	public $sign = '';
	public $amount;
	public $currency;
	public $merchantTransactionId;
	public $paymentType;
	public $shopperResultUrl;
	public $paymentBrand = 'VISA';
	public $token;
	/**
	 * @var PayMethodInfoPayLoad $payMethodInfo
	 */
	public $payMethodInfo;
	public $threeDSecure = 'N';
	/**
	 * @var RiskInfoPayLoad $riskInfo
	 */
	public $riskInfo;
	public $notificationUrl;
	public $merchantUserId;
	public $createToken;
	public $defaulted;
	public $primaryMerchantTransactionId;
	public $periodsNum;
}