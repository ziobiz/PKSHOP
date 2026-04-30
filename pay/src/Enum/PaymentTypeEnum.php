<?php

namespace PingPong\src\Enum;


use EasySwoole\Spl\SplEnum ;

class PaymentTypeEnum extends SplEnum
{
	public const TYPE_REFUND = 'REFUND';
	public const TYPE_CAPTURE = 'CAPTURE';
	public const TYPE_VOID = 'VOID';
	public const TYPE_APPROVE = 'APPROVE';
	public const TYPE_REJECT = 'REJECT';
}