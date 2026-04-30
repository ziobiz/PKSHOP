<?php


namespace PingPong\src\Request\RequestPayload\CheckOut\RiskInfo;


use EasySwoole\Spl\SplBean;

class GoodPayLoad extends SplBean
{
	public $averageUnitPrice;
	public $description;
	public $name;
	public $number;
	public $sku;
	public $virtualProduct;

	/**
	 * Good constructor.
	 * @param $averageUnitPrice
	 * @param $description
	 * @param $name
	 * @param $number
	 * @param $sku
	 * @param $virtualProduct
	 */
	public function __construct($averageUnitPrice,
	                            $description,
	                            $name,
	                            $number,
	                            $sku,
	                            $virtualProduct,
	                            $autoCreateProperty = false
	)
	{
		parent::__construct([
			'averageUnitPrice' => $averageUnitPrice,
			'description' => $description,
			'name' => $name,
			'number' => $number,
			'sku' => $sku,
			'virtualProduct' => $virtualProduct,
		], $autoCreateProperty);
	}


	/**
	 * @param array $data
	 * @return $this
	 */
	public static function getIns(array $data): self
	{
		return new self(
			$data['averageUnitPrice'],
			$data['description'],
			$data['name'],
			$data['number'],
			$data['sku'],
			$data['virtualProduct']
		);
	}


	public function __toString(): string
	{
		return (string)json_encode(get_object_vars($this));
	}


}
