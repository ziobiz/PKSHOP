<?php
declare(strict_types = 1);

namespace PingPong\Lib\Service;


use PingPong\src\Core\PPConfigs;
use PingPong\src\Core\PPSignType;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\BillingPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\CustomerPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\ECommercePayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\GoodPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\ShippingPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfoPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\ServerToServer\CardPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\ServerToServer\PayMethodInfoPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\ServerToServer\ServerToServerPayLoad;

class S2SPayLoadBuilder
{
	private $configs;
	private $payMethodInfo;

	/**
	 * 电商必传的风控参数 实际需要传更多的参数 应当结合业务
	 */
	private $billingPayLoad;
	private $customerPayLoad;
	private $goods;
	private $shipping;

	/**
	 * S2SPayLoadBuilder constructor.
	 * @param PPConfigs $configs
	 * @return $this
	 */
	public function __construct(PPConfigs $configs)
	{
		$this->configs = $configs;

		return $this;
	}

	public function build(
		string $accId,
		/**
		 * amount 应当使用bcmath 处理成字符串
		 */
		string $amount,
		string $currency,
		string $merchantTransactionId,
		string $paymentType,
		string $shopperResultUrl,
		string $paymentBrand,
		string $token,
		string $threeDSecure,
		string $notificationUrl,
		string $merchantUserId,
		string $createToken = 'Y',
		string $defaulted = 'Y',
		string $primaryMerchantTransactionId = '',
		string $periodsNum = '',
		string $signType = PPSignType::SIGN_TYPE_MD5
	)
	{
		$s2sPayLoad = new ServerToServerPayLoad([
			'accId' => $accId,
			'signType' => $signType,
			'amount' => bcdiv($amount, '1', 2),
			'currency' => $currency,
			'merchantTransactionId' => $merchantTransactionId,
			'paymentType' => $paymentType,
			'shopperResultUrl' => $shopperResultUrl,
			'paymentBrand' => $paymentBrand,
			'token' => $token,
			'payMethodInfo' => $this->payMethodInfo,
			'threeDSecure' => $threeDSecure,
			'riskInfo' => $this->buildRiskInfo(),
			'notificationUrl' => $notificationUrl,
			'merchantUserId' => $merchantUserId,
			'createToken' => $createToken,
			'defaulted' => $defaulted,
			'primaryMerchantTransactionId' => $primaryMerchantTransactionId,
			'periodsNum' => $periodsNum,
		]);

		return $s2sPayLoad;
	}

	/**
	 * @param string $number
	 * @param string $expireMonth
	 * @param string $expireYear
	 * @param string $cvv
	 * @param string $firstName
	 * @param string $lastName
	 * @return $this
	 */
	public function buildPayMethodInfo(
		string $number,
		string $expireMonth,
		string $expireYear,
		string $cvv,
		string $firstName,
		string $lastName
)
	{
		$card = new CardPayLoad([
			'number' => $number,
			'expireMonth' => $expireMonth,
			'expireYear' => $expireYear,
			'cvv' => $cvv,
			'firstName' => $firstName,
			'lastName' => $lastName,
		]);

		$this->payMethodInfo = new PayMethodInfoPayLoad([
			'card' => $card
		]);

		return $this;
	}


	/**
	 * @param $city
	 * @param $country
	 * @param $email
	 * @param $firstName
	 * @param $lastName
	 * @param $phone
	 * @param $postcode
	 * @param $state
	 * @param $street
	 * @return $this
	 */
	public function buildBilling($city, $country, $email, $firstName, $lastName, $phone, $postcode, $state, $street)
	{
		$this->billingPayLoad = new BillingPayLoad($city, $country, $email,
			$firstName, $lastName, $phone, $postcode, $state, $street);

		return $this;
	}


	/**
	 * @param array $customer ["customerId"]
	 * @return $this
	 */
	public function buildCustomer(array $customer)
	{
		$this->customerPayLoad = new CustomerPayLoad($customer);

		return $this;
	}


	/**
	 * @param GoodPayLoad $goodPayLoad
	 * @return $this
	 */
	public function buildGoods(GoodPayLoad $goodPayLoad)
	{
		$this->goods[] = $goodPayLoad;

		return $this;
	}


	/**
	 * @param $firstName
	 * @param $lastName
	 * @param $phone
	 * @param $email
	 * @param $street
	 * @param $postcode
	 * @param $city
	 * @param $state
	 * @param $country
	 * @param string $lastModifierStreetTime
	 * @param string $lastModifierPhoneTime
	 * @return $this
	 */
	public function buildShipping($firstName, $lastName, $phone, $email, $street, $postcode, $city, $state, $country,
	                              $lastModifierStreetTime = '', $lastModifierPhoneTime = '')
	{
		$this->shipping = new ShippingPayLoad(
			$firstName, $lastName, $phone,
			$email, $street, $postcode, $city, $state,
			$country, $lastModifierStreetTime, $lastModifierPhoneTime
		);

		return $this;
	}


	/**
	 * @return RiskInfoPayLoad
	 */
	private function buildRiskInfo(): RiskInfoPayLoad
	{
		$riskInfo = [
			'billing' => $this->billingPayLoad,
			'customer' => $this->customerPayLoad,
			'eCommerce' => new ECommercePayLoad(),
			'goods' => $this->goods,
			'shipping' => $this->shipping
		];

		return new RiskInfoPayLoad($riskInfo);
	}
}