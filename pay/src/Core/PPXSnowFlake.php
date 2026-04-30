<?php


namespace PingPong\src\Core;

use Godruoyi\Snowflake\Snowflake;

class PPXSnowFlake
{
	/**
	 * @param string $prefix
	 * @param int $datacenterId
	 * @param null $workerId
	 * @return string
	 */
	public static function make(string $prefix='WC',$datacenterId = 1, $workerId = null):string
	{
		if ( is_null($workerId) ) {
			$workerId = posix_getpid();
			$workerId = (int)($workerId % 31);
		}
		$snowflake = new Snowflake($datacenterId, $workerId);

		return $prefix.$snowflake->id();
	}
}