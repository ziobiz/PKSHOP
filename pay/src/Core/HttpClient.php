<?php

namespace PingPong\src\Core;

use Exception;
use PingPong\src\Http\AbstractHttpClient;
use PingPong\src\Http\Curl;

/**
 * ping-pong服务请求类
 * Class HttpClient
 * @package PingPong\src\Core
 */
class HttpClient
{
	public $client;

	/**
	 * HttpClient constructor.
	 * @param $clientType
	 * @throws Exception
	 */
	public function __construct($driver = Curl::class)
	{
		if ( !is_subclass_of($driver, AbstractHttpClient::class) ) {
			throw new Exception('请求实现类错误');
		}
		$this->client = $this->getClient($driver);
	}

	/**
	 * @param $driver
	 * @return mixed
	 * @throws Exception
	 */
	public function getClient($driver): AbstractHttpClient
	{
		if ( !class_exists($driver) ) {
			throw new Exception('client not found');
		}

		return (new $driver());
	}

	/**
	 * @param string $url
	 * @param string $param
	 * @return mixed
	 */
	public function request(string $url, string $param)
	{
		return $this->client->request($url, $param);
	}
}
