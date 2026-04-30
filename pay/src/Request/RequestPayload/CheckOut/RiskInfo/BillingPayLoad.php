<?php


namespace PingPong\src\Request\RequestPayload\CheckOut\RiskInfo;


use EasySwoole\Spl\SplBean;

class BillingPayLoad extends SplBean
{
	public $city;
	public $country;
	public $email;
	public $firstName;
	public $lastName;
	public $phone;
	public $postcode;
	public $state;
	public $street;

	/**
	 * BillingPayLoad constructor.
	 * @param $city
	 * @param $country
	 * @param $email
	 * @param $firstName
	 * @param $lastName
	 * @param $phone
	 * @param $postcode
	 * @param $state
	 * @param $street
	 */
	public function __construct($city, $country, $email, $firstName, $lastName, $phone, $postcode, $state, $street, $autoCreateProperty = false)
	{
		parent::__construct([
			'city' => $city,
			'country' => $country,
			'email' => $email,
			'firstName' => $firstName,
			'lastName' => $lastName,
			'phone' => $phone,
			'postcode' => $postcode,
			'state' => $state,
			'street' => $street,
		],
			$autoCreateProperty
		);
	}


	/**
	 * @param array $data
	 * @return BillingPayLoad
	 */
	public static function getIns(array $data)
	{
		return new self(
			$data['city'],
			$data['country'],
			$data['email'],
			$data['firstName'],
			$data['lastName'],
			$data['phone'],
			$data['postcode'],
			$data['state'],
			$data['street'],
		);
	}


	public function __toString(): string
	{
		return (string)json_encode(get_object_vars($this));
	}


}
