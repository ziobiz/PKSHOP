<?php

namespace PingPong\Lib\Service;

use Exception;
use PingPong\src\Core\BaseUrl;
use PingPong\src\Core\PPConfigs;
use PingPong\src\Core\PPSignType;
use PingPong\src\Request\RequestPayload\CheckOut\CheckOutPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\BillingPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\CustomerPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\ECommercePayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\GoodPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\ShippingPayLoad;

/**
 * CheckoutPayload 参数填充示例 LIb文件夹下的类只可用做参考 请根据真实业务场景编写
 * Class CheckoutPayloadBuilder
 * @package PingPong\Lib\Service
 */
class CheckoutPayloadBuilder
{
	private $configs;

	private $billingPayLoad;

	private $customerPayLoad;

	private $goods;

	private $shipping;

	public function __construct(PPConfigs $configs)
	{
		$this->configs = $configs;
	}


	/***
	 * @param string $amount
	 * @param string $currency
	 * @param string $merchantTransactionId
	 * @param string $merchantUserId
	 * @param string $notificationUrlPath
	 * @param array $remark
	 * @param string $shopperResultUrlPath
	 * @return CheckOutPayLoad
	 * @throws Exception
	 */
	public function build(string $amount, string $currency, string $merchantTransactionId,
	                      string $merchantUserId, string $notificationUrlPath, array $remark,
	                      string $shopperResultUrlPath, string $threeDSecure
	): CheckOutPayLoad
	{

		$checkOutPayLoad = new CheckOutPayLoad([
			'clientId' => $this->configs->clientId,
			'accId' => $this->configs->accId,
			'amount' => bcdiv((string)$amount, '1', 2),
			'currency' => $currency,
			'merchantTransactionId' => $merchantTransactionId,
			'merchantUserId' => $merchantUserId,
			'notificationUrl' => $notificationUrlPath,
			'paymentBrand' => 'VISA',
			'paymentType' => '',
			'remark' => json_encode($remark),
			'shopperResultUrl' => $shopperResultUrlPath, $merchantTransactionId,
			'riskInfo' => $this->buildRiskInfo(),
			'signType' => PPSignType::SIGN_TYPE_MD5,
			'threeDSecure' => $threeDSecure
		]);

		$checkOutPayLoad->setSign($this->configs->salt);

		return $checkOutPayLoad;
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
	public function buildBilling($city, $country, $email, $firstName, $lastName, $phone, $postcode, $state, $street): CheckoutPayloadBuilder
	{
		$this->billingPayLoad = new BillingPayLoad($city, $country, $email,
			$firstName, $lastName, $phone, $postcode, $state, $street);

		return $this;
	}


	/**
	 * @param array $customer ["customerId"]
	 * @return $this
	 */
	public function buildCustomer(array $customer): CheckoutPayloadBuilder
	{
		$this->customerPayLoad = new CustomerPayLoad($customer);

		return $this;
	}


	/**
	 * @param GoodPayLoad $goodPayLoad
	 * @return $this
	 */
	public function buildGoods(GoodPayLoad $goodPayLoad): CheckoutPayloadBuilder
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
	                              $lastModifierStreetTime = '', $lastModifierPhoneTime = ''): CheckoutPayloadBuilder
	{
		$this->shipping = new ShippingPayLoad(
			$firstName, $lastName, $phone,
			$email, $street, $postcode, $city, $state,
			$country, $lastModifierStreetTime, $lastModifierPhoneTime
		);

		return $this;
	}


	/**
	 * @return array
	 */
	private function buildRiskInfo(): array
	{
		return [
			'billing' => $this->billingPayLoad,
			'customer' => $this->customerPayLoad,
			'eCommerce' => new ECommercePayLoad(),
			'goods' => $this->goods,
			'shipping' => $this->shipping
		];
	}

}