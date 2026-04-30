<?php


namespace PingPong\src\Request\RequestPayload\CheckOut\RiskInfo;


use EasySwoole\Spl\SplBean;

class ECommercePayLoad extends SplBean
{
	public $freeShipping = 'N';
	public $shippingMethod = 'air';

	/**
	 * ECommerce constructor.
	 * @param string $freeShipping
	 * @param string $shippingMethod
	 */
	public function __construct(string $freeShipping = 'N', string $shippingMethod = 'air', $autoCreateProperty = false)
	{
		parent::__construct([
			'freeShipping' => $freeShipping,
			'shippingMethod' => $shippingMethod
		], $autoCreateProperty);
	}


	/**
	 * @param array $data
	 * @return ECommercePayLoad
	 */
	public static function getIns(array $data)
	{
		return new self(
			$data['freeShipping'],
			$data['shippingMethod'],
		);
	}


	public function __toString(): string
	{
		return (string)json_encode(get_object_vars($this));
	}
}
