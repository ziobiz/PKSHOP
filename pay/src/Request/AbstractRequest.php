<?php

namespace PingPong\src\Request;

use PingPong\src\Core\HttpClient;
use PingPong\src\Http\AbstractHttpClient;
use PingPong\src\Http\Curl;

abstract class AbstractRequest
{
	protected $gateway;
	protected $httpClientDriver = Curl::class;
	protected $httpClient;

	protected static $SUCCESS_CODE_LIST =
		[
			'000000',
			'001000',
			'002000',
		];

	/**
	 * AbstractRequest constructor.
	 * @param $gateway
	 */
	public function __construct($gateway)
	{
		$gateway = rtrim($gateway, '/');
		$this->gateway = $gateway . '/';
	}

	abstract public function getRequestUrl(): string;

	abstract public function request(?callable $success = null, ?callable $fail = null);

	/**
	 * @param mixed $httpClientDriver
	 */
	public function setHttpClientDriver(string $httpClientDriver): void
	{
		$this->httpClientDriver = $httpClientDriver;
	}

	/**
	 * @return mixed
	 */
	public function getHttpClient(): HttpClient
	{
		if ( $this->httpClient === null ) {
			$this->setHttpClient();
		}
		return $this->httpClient;
	}

	/***
	 * @throws \Exception
	 */
	public function setHttpClient(): void
	{
		$this->httpClient = new HttpClient($this->httpClientDriver);
	}


}
