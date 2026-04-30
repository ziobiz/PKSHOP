<?php


namespace PingPong\src\Core;


class BaseUrl
{
	/**
	 * @return string
	 */
	public static function getBaseUrl(): string
	{
		var_dump($_SERVER);exit();
		$protocol = (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) === 'on' || $_SERVER['HTTPS'] === '1' || $_SERVER['HTTPS'] === true)) ? 'https://' : 'http://';
		$server = $_SERVER['HTTP_HOST'];
		$port = (($_SERVER['SERVER_PORT'] !== '80' && $_SERVER['SERVER_PORT'] !== '443') ? ':' . $_SERVER['SERVER_PORT'] : '');
		$server = rtrim($server,':'.$port);

		return $protocol . $server.$port;
	}


	public static function getNotificationUrl(string $path)
	{
		var_dump(self::getBaseUrl());exit();
		return self::getBaseUrl().$path;
	}


	public static function getShopperResultUrl(string $path,string $merchantTransactionId)
	{
		return self::getBaseUrl().$path;
	}


	/**
	 * @param string $gateway
	 * @return string
	 */
	public static function getEnv(string $gateway): string
	{
		if ( false !== stripos($gateway, "test") ) {
			$env = 'test';
		} else if ( false !== stripos($gateway, "sandbox") ) {
			$env = 'sandbox';
		} else {
			$env = 'build';
		}

		return $env;
	}

}