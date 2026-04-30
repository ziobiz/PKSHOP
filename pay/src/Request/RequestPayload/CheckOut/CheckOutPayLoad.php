<?php


namespace PingPong\src\Request\RequestPayload\CheckOut;


use EasySwoole\Spl\SplBean;
use Exception;
use PingPong\src\Core\PPSignType;
use PingPong\src\Request\RequestPayload\HttpPayLoad;
use PingPong\src\Signature\Sign;

class CheckOutPayLoad extends HttpPayLoad
{
	public $clientId;
	public $accId;
	public $amount;
	public $currency;
	public $merchantSource = '';
	public $merchantTransactionId;
	public $merchantUserId;
	public $notificationUrl;
	public $paymentBrand = 'VISA';
	public $paymentType;
	public $remark;
	public $shopperResultUrl;
	public $riskInfo;
	public $sign = '';
	public $signType = PPSignType::SIGN_TYPE_MD5;
	public $threeDSecure = 'N';


	/**
	 * @return string
	 */
	public function __toString(): string
	{
		$result = json_encode(get_object_vars($this));

		return (string)$result;
	}


	/**
	 * @param string $salt
	 * @param array $data
	 * @return Sign
	 * @throws Exception
	 */
	public function setSign(string $salt, array $data = []): Sign
	{
		$sign = (new Sign($this->signType, [
			'accId' => $this->accId,
			'amount' => $this->amount,
			'clientId' => $this->clientId,
			'currency' => $this->currency,
			'merchantTransactionId' => $this->merchantTransactionId,
			'notificationUrl' => $this->notificationUrl,
			'shopperResultUrl' => $this->shopperResultUrl,
			'signType' => $this->signType
		], $salt));

		$this->sign = $sign->get(Sign::SIGN_TO_UPPER);

		return $sign;
	}


}
