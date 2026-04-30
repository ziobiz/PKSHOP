<?php


namespace PingPong\src\Response;


use EasySwoole\Spl\SplBean;

class HttpResponse extends SplBean
{
	/**
	 * @return string
	 * @throws
	 */
	public function __toString(): string
	{
		$str = json_encode(get_object_vars($this), JSON_THROW_ON_ERROR);
		if ( is_string($str) ) {
			return $str;
		}

		return '';
	}

}