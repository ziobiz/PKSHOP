<?php

namespace PingPong\src\Request\RequestPayload;

use EasySwoole\Spl\SplBean;
use Exception;
use PingPong\src\Core\PPSignType;
use PingPong\src\Signature\Sign;

abstract class HttpPayLoad extends SplBean
{
	public $signType = PPSignType::SIGN_TYPE_MD5;
	public $sign;


	/**
	 * @param string $salt
	 * @param array $data
	 * @return Sign
	 * @throws Exception
	 */
	public function setSign(string $salt, array $data): Sign
	{
		$sign = (new Sign($this->signType, $data, $salt));

		$this->sign = $sign->get(Sign::SIGN_TO_UPPER);

		return $sign;
	}
}