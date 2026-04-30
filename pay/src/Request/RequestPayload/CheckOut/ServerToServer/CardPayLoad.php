<?php


namespace PingPong\src\Request\RequestPayload\CheckOut\ServerToServer;


use EasySwoole\Spl\SplBean;

class CardPayLoad extends SplBean
{
	public $number;
	public $expireMonth;
	public $expireYear;
	public $cvv;
	public $firstName;
	public $lastName;
}