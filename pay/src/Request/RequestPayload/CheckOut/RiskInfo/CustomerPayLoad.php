<?php


namespace PingPong\src\Request\RequestPayload\CheckOut\RiskInfo;


use EasySwoole\Spl\SplBean;

class CustomerPayLoad extends SplBean
{
	public $customerId;
	public $firstname;
	public $lastname;
	public $email;
	public $domain;
	public $phone;
	public $mobile;
	public $workPhone;
	public $identificationType='';
	public $identificationId='';
	public $registerTime = '';
	public $registerIp = '';
	public $registerTerminal = '';
	public $registerCountry = '';
	public $registerRange = '';
	public $orderTime = '';
	public $orderIp = '';
	public $orderCountry = '';
	public $payIp = '';
	public $payCountry = '';
	public $loginTime = '';
	public $loginIp = '';
	public $lastPayTime = '';
	public $acquisitionChannel = '';
	public $firstOrder = '';
	public $nonMemberOrder = '';
	public $preferentialOrder = '';
	public $birthdate = '';
	public $customerStatus = '';

	/**
	 * @return mixed
	 */
	public function getCustomerId()
	{
		return $this->customerId;
	}

	/**
	 * @param mixed $customerId
	 * @return CustomerPayLoad
	 */
	public function setCustomerId($customerId): CustomerPayLoad
	{
		$this->customerId = $customerId;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFirstname()
	{
		return $this->firstname;
	}

	/**
	 * @param mixed $firstname
	 * @return CustomerPayLoad
	 */
	public function setFirstname($firstname): CustomerPayLoad
	{
		$this->firstname = $firstname;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLastname()
	{
		return $this->lastname;
	}

	/**
	 * @param mixed $lastname
	 * @return CustomerPayLoad
	 */
	public function setLastname($lastname): CustomerPayLoad
	{
		$this->lastname = $lastname;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param mixed $email
	 * @return CustomerPayLoad
	 */
	public function setEmail($email): CustomerPayLoad
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDomain()
	{
		return $this->domain;
	}

	/**
	 * @param mixed $domain
	 * @return CustomerPayLoad
	 */
	public function setDomain($domain): CustomerPayLoad
	{
		$this->domain = $domain;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * @param mixed $phone
	 * @return CustomerPayLoad
	 */
	public function setPhone($phone): CustomerPayLoad
	{
		$this->phone = $phone;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getMobile()
	{
		return $this->mobile;
	}

	/**
	 * @param mixed $mobile
	 * @return CustomerPayLoad
	 */
	public function setMobile($mobile): CustomerPayLoad
	{
		$this->mobile = $mobile;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getWorkPhone()
	{
		return $this->workPhone;
	}

	/**
	 * @param mixed $workPhone
	 * @return CustomerPayLoad
	 */
	public function setWorkPhone($workPhone): CustomerPayLoad
	{
		$this->workPhone = $workPhone;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIdentificationType()
	{
		return $this->identificationType;
	}

	/**
	 * @param mixed $identificationType
	 * @return CustomerPayLoad
	 */
	public function setIdentificationType($identificationType): CustomerPayLoad
	{
		$this->identificationType = $identificationType;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIdentificationId()
	{
		return $this->identificationId;
	}

	/**
	 * @param mixed $identificationId
	 * @return CustomerPayLoad
	 */
	public function setIdentificationId($identificationId): CustomerPayLoad
	{
		$this->identificationId = $identificationId;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getRegisterTime()
	{
		return $this->registerTime;
	}

	/**
	 * @param mixed $registerTime
	 * @return CustomerPayLoad
	 */
	public function setRegisterTime($registerTime)
	{
		$this->registerTime = $registerTime;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getRegisterIp()
	{
		return $this->registerIp;
	}

	/**
	 * @param mixed $registerIp
	 * @return CustomerPayLoad
	 */
	public function setRegisterIp($registerIp): CustomerPayLoad
	{
		$this->registerIp = $registerIp;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getRegisterTerminal()
	{
		return $this->registerTerminal;
	}

	/**
	 * @param mixed $registerTerminal
	 * @return CustomerPayLoad
	 */
	public function setRegisterTerminal($registerTerminal): CustomerPayLoad
	{
		$this->registerTerminal = $registerTerminal;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getRegisterCountry()
	{
		return $this->registerCountry;
	}

	/**
	 * @param mixed $registerCountry
	 * @return CustomerPayLoad
	 */
	public function setRegisterCountry($registerCountry): CustomerPayLoad
	{
		$this->registerCountry = $registerCountry;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getRegisterRange()
	{
		return $this->registerRange;
	}

	/**
	 * @param mixed $registerRange
	 * @return CustomerPayLoad
	 */
	public function setRegisterRange($registerRange): CustomerPayLoad
	{
		$this->registerRange = $registerRange;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getOrderTime()
	{
		return $this->orderTime;
	}

	/**
	 * @param mixed $orderTime
	 * @return CustomerPayLoad
	 */
	public function setOrderTime($orderTime): CustomerPayLoad
	{
		$this->orderTime = $orderTime;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getOrderIp()
	{
		return $this->orderIp;
	}

	/**
	 * @param mixed $orderIp
	 * @return CustomerPayLoad
	 */
	public function setOrderIp($orderIp): CustomerPayLoad
	{
		$this->orderIp = $orderIp;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getOrderCountry()
	{
		return $this->orderCountry;
	}

	/**
	 * @param mixed $orderCountry
	 * @return CustomerPayLoad
	 */
	public function setOrderCountry($orderCountry): CustomerPayLoad
	{
		$this->orderCountry = $orderCountry;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPayIp()
	{
		return $this->payIp;
	}

	/**
	 * @param mixed $payIp
	 * @return CustomerPayLoad
	 */
	public function setPayIp($payIp): CustomerPayLoad
	{
		$this->payIp = $payIp;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPayCountry()
	{
		return $this->payCountry;
	}

	/**
	 * @param mixed $payCountry
	 * @return CustomerPayLoad
	 */
	public function setPayCountry($payCountry)
	{
		$this->payCountry = $payCountry;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLoginTime()
	{
		return $this->loginTime;
	}

	/**
	 * @param mixed $loginTime
	 * @return CustomerPayLoad
	 */
	public function setLoginTime($loginTime): CustomerPayLoad
	{
		$this->loginTime = $loginTime;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLoginIp()
	{
		return $this->loginIp;
	}

	/**
	 * @param mixed $loginIp
	 * @return CustomerPayLoad
	 */
	public function setLoginIp($loginIp): CustomerPayLoad
	{
		$this->loginIp = $loginIp;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLastPayTime()
	{
		return $this->lastPayTime;
	}

	/**
	 * @param mixed $lastPayTime
	 * @return CustomerPayLoad
	 */
	public function setLastPayTime($lastPayTime): CustomerPayLoad
	{
		$this->lastPayTime = $lastPayTime;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAcquisitionChannel()
	{
		return $this->acquisitionChannel;
	}

	/**
	 * @param mixed $acquisitionChannel
	 * @return CustomerPayLoad
	 */
	public function setAcquisitionChannel($acquisitionChannel): CustomerPayLoad
	{
		$this->acquisitionChannel = $acquisitionChannel;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFirstOrder()
	{
		return $this->firstOrder;
	}

	/**
	 * @param mixed $firstOrder
	 * @return CustomerPayLoad
	 */
	public function setFirstOrder($firstOrder): CustomerPayLoad
	{
		$this->firstOrder = $firstOrder;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getNonMemberOrder()
	{
		return $this->nonMemberOrder;
	}

	/**
	 * @param mixed $nonMemberOrder
	 * @return CustomerPayLoad
	 */
	public function setNonMemberOrder($nonMemberOrder): CustomerPayLoad
	{
		$this->nonMemberOrder = $nonMemberOrder;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPreferentialOrder()
	{
		return $this->preferentialOrder;
	}

	/**
	 * @param mixed $preferentialOrder
	 * @return CustomerPayLoad
	 */
	public function setPreferentialOrder($preferentialOrder): CustomerPayLoad
	{
		$this->preferentialOrder = $preferentialOrder;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getBirthdate()
	{
		return $this->birthdate;
	}

	/**
	 * @param mixed $birthdate
	 * @return CustomerPayLoad
	 */
	public function setBirthdate($birthdate): CustomerPayLoad
	{
		$this->birthdate = $birthdate;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCustomerStatus()
	{
		return $this->customerStatus;
	}

	/**
	 * @param mixed $customerStatus
	 * @return CustomerPayLoad
	 */
	public function setCustomerStatus($customerStatus): CustomerPayLoad
	{
		$this->customerStatus = $customerStatus;
		return $this;
	}

	public function __toString(): string
	{
		return (string)json_encode(get_object_vars($this));
	}


}
