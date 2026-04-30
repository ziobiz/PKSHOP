<?php


namespace PingPong\src\Request\RequestPayload\CheckOut;


use EasySwoole\Spl\SplBean;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\BillingPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\CustomerPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\ECommercePayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\GoodPayLoad;
use PingPong\src\Request\RequestPayload\CheckOut\RiskInfo\ShippingPayLoad;

class RiskInfoPayLoad extends SplBean
{
	public $customer;
	public $goods;
	public $shipping;
	public $billing;
	public $eCommerce;

	/**
	 * RiskInfoPayLoad constructor.
	 * @param array|null $data
	 * @param false $autoCreateProperty
	 */
	public function __construct(array $data = null, $autoCreateProperty = false)
	{
		if ( is_array($data['customer']) ) {
			$data['customer'] = new CustomerPayLoad($data['customer']);
		}
		if ( is_array($data['goods']) ) {
			foreach ( $data['goods'] as &$good ) {
				if (is_object($good)){
					$good = get_object_vars($good);
				}
				$good = GoodPayLoad::getIns($good);
			}
		}

		if ( is_array($data['shipping']) ) {
			$data['shipping'] = ShippingPayLoad::getIns($data['shipping']);
		}

		if ( is_array($data['billing']) ) {
			$data['billing'] = BillingPayLoad::getIns($data['billing']);
		}

		if ( is_array($data['eCommerce']) ) {
			$data['eCommerce'] = ECommercePayLoad::getIns($data['eCommerce']);
		}

		parent::__construct($data, $autoCreateProperty);
	}


}