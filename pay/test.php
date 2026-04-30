<?
    include_once("./vendor/autoload.php");
    abstract class PPConfigs extends SplBean
{
	public $salt;//md5秘钥
	public $clientId;
	public $accId;//用户accId
	public $gateway;//网关地址
  //以下是pingpong支付状态和商户订单状态的映射关系
	public $stateFailed = 'failed';//pingpong返回Failed时候对应的商户订单状态
	public $stateSuccess = 'processing';//pingpong返回Success状态时候对应的商户订单状态
	public $stateRefunded = 'refunded';//pingpong返回Refunded状态时候对应的商户订单状态
	public $stateProcessing = 'pending';//pingpong返回Processing时候对应的商户订单状态
	public $stateReview = 'on-hold';//pingpong返回Review时候对应的商户订单状态

}
?>