<?php

namespace PingPong\src\Signature;

abstract class AbstractSignature
{
	protected $params = [];
	protected $salt = '';
	protected $signStr = '';

	/**
	 * Sign constructor.
	 * @param array $params
	 * @param string $salt
	 */
	public function __construct(array $params, string $salt)
	{
		$this->params = $params;
		$this->salt = $salt;
	}

	/**
	 * @param int $isLower 0 nothing to do 1 toLower 2 toUpper
	 * @return string
	 */
	abstract public function getSign(int $isLower = 0): string;

	/**
	 * @return mixed
	 */
	public function filter()
	{
		foreach ( $this->params as $key => $param ) {
			if ( strtolower($key) === 'sign' || is_null($param) ) {
				continue;
			}

			$signData[$key] = $param;
		}

		ksort($signData);

		return $signData;
	}

	/**
	 * @return array
	 */
	public function getParams(): array
	{
		return $this->params;
	}

	/**
	 * @return string
	 */
	public function getSalt(): string
	{
		return $this->salt;
	}

	/**
	 * @return string
	 */
	public function getSignStr(): string
	{
		return $this->signStr;
	}



}
