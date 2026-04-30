<?php


namespace PingPong\src\Request\RequestPayload\CheckOut\ServerToServer;


use EasySwoole\Spl\SplBean;

class PayMethodInfoPayLoad extends SplBean
{
	/**
	 * @var CardPayLoad $card
	 */
	public $card;

	public function __construct(array $data = null, $autoCreateProperty = false)
	{
		if (is_object($data['card'])){
			$data['card'] = get_object_vars($data['card']);
		}
		$data['card'] = new CardPayLoad($data['card']);
		parent::__construct($data, $autoCreateProperty);
	}


}