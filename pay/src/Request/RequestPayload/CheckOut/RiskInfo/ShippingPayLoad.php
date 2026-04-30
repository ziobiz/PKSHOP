<?php


namespace PingPong\src\Request\RequestPayload\CheckOut\RiskInfo;


use EasySwoole\Spl\SplBean;

class ShippingPayLoad extends SplBean
{
	public $firstName;
	public $lastName;
	public $phone;
	public $email;
	public $street;
	public $postcode;
	public $city;
	public $state;
	public $country;
	public $lastModifierStreetTime;
	public $lastModifierPhoneTime;

	/**
	 * Shipping constructor.
	 * @param $firstName
	 * @param $lastName
	 * @param $phone
	 * @param $email
	 * @param $street
	 * @param $postcode
	 * @param $city
	 * @param $state
	 * @param $country
	 * @param $lastModifierStreetTime
	 * @param $lastModifierPhoneTime
	 */
	public function __construct($firstName,
	                            $lastName,
	                            $phone,
	                            $email,
	                            $street,
	                            $postcode,
	                            $city,
	                            $state,
	                            $country,
	                            $lastModifierStreetTime = '',
	                            $lastModifierPhoneTime = '',
	                            $autoCreateProperty = false
	)
	{
		parent::__construct([
			'firstName' => $firstName,
			'lastName' => $lastName,
			'phone' => $phone,
			'email' => $email,
			'street' => $street,
			'postcode' => $postcode,
			'city' => $city,
			'state' => $state,
			'country' => $country,
			'lastModifierStreetTime' => $lastModifierStreetTime,
			'lastModifierPhoneTime' => $lastModifierPhoneTime,
		], $autoCreateProperty
		);
	}


	/**
	 * @param array $data
	 * @return ShippingPayLoad
	 */
	public static function getIns(array $data)
	{
		return new self(
			$data['firstName'],
			$data['lastName'],
			$data['phone'],
			$data['email'],
			$data['street'],
			$data['postcode'],
			$data['city'],
			$data['state'],
			$data['country'],
			$data['lastModifierStreetTime'],
			$data['lastModifierPhoneTime']
		);
	}


	public function __toString(): string
	{
		return (string)json_encode(get_object_vars($this));
	}


}
