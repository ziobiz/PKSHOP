<?php

namespace PingPong\src\Request\RequestPayload\Payment;


use PingPong\src\Core\PPSignType;
use PingPong\src\Request\RequestPayload\HttpPayLoad;

class PaymentPayLoad extends HttpPayLoad
{
	public $accId;
	public $merchantTransactionId;
	/**
	 * 交易类型:REFUND-退款 CAPTURE-预授权确认 VOID-预授权取消 APPROVE-审核通过 REJECT-审核拒绝
	 * @var $paymentType
	 */
	public $paymentType;
	/**
	 * 交易金额，小数点后保留两位，如 10.12，部分交 易币种如 JPY、KRW 其最小单位为元，也要求上送两位小数，如 29.00
	 * @var $amount
	 */
	public $amount;
	public $currency;
	public $signType = PPSignType::SIGN_TYPE_MD5;
	public $sign;
	public $notificationUrl;
	public $reviewSystem = '';
	public $reviewer = '';
	public $reviewComment = '';

	public function __construct(array $data = null, $autoCreateProperty = false)
	{
		$data['amount'] = bcdiv((string)$data['amount'], '1', 2);

		parent::__construct($data, $autoCreateProperty);
	}


}