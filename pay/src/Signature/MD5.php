<?php

namespace PingPong\src\Signature;

use Exception;

class MD5 extends AbstractSignature
{
	/**
	 * @param int $isLower
	 * @return string
	 * @throws Exception
	 */
	public function getSign(int $isLower = 0): string
	{
		$data = $this->filter();
		$signStr = $this->salt;
		foreach ( $data as $key => $value ) {
			$signStr .= "{$key}=$value&";
		}

		$signStr = rtrim($signStr, '&');
		$this->signStr = $signStr;
		$sign = md5($signStr);
		if ( $isLower === 0 ) {
			return $sign;
		}

		if ( $isLower === 1 ) {
			return strtolower($sign);
		}

		if ( $isLower === 2 ) {
			return strtoupper($sign);
		}

		throw new Exception('param isLower error');
	}
}
