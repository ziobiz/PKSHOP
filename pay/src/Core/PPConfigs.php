<?php


namespace PingPong\src\Core;


use EasySwoole\Spl\SplBean;

abstract class PPConfigs extends SplBean
{
	public $salt;
	public $clientId;
	public $accId;
	public $gateway;
	public $stateFailed = 'failed';
	public $stateSuccess = 'processing';
	public $stateRefunded = 'refunded';
	public $stateProcessing = 'pending';
	public $stateReview = 'on-hold';

}
