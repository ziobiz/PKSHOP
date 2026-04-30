<?php

namespace PingPong\src\Signature;

use Exception;
use PingPong\src\Core\PPSignType;
use PingPong\src\Enum\SignParamsType;

class Sign
{
	protected $signatureProvide;

	public const SIGN_TO_NOTHING = 0;
	public const SIGN_TO_LOWER = 1;
	public const SIGN_TO_UPPER = 2;

	protected $drivers = [
		PPSignType::SIGN_TYPE_MD5 => MD5::class,
	];


	/**
	 * Sign constructor.
	 * @param string $signType
	 * @param array $params
	 * @param string $salt
	 * @param string $paramsType
	 * @throws Exception
	 */
	public function __construct(string $signType, array $params, string $salt, string $paramsType = SignParamsType::REQUEST)
	{
		$params = $this->signatureScope($params, $paramsType);

		$this->signatureProvide = $this->getDriver($signType, $params, $salt);
	}

	/**
	 * @param int $isLower 0 nothing to do 1 toLower 2 toUpper
	 * @return string
	 */
	public function get(int $isLower = 0): string
	{
		return $this->signatureProvide->getSign($isLower);
	}

	/**
	 * @param string $sign
	 * @return bool
	 */
	public function isPingPongPay(string $sign): bool
	{
		$signNeed = $this->get();
		return strtoupper($signNeed) === strtoupper($sign);
	}

	/**
	 * @param string $signType
	 * @param array $params
	 * @param string $salt
	 * @return AbstractSignature
	 * @throws Exception
	 */
	protected function getDriver(string $signType, array $params, string $salt): AbstractSignature
	{
		if ( !isset($this->drivers[strtoupper($signType)]) ) {
			throw new Exception('sign type error');
		}
		$clazz = $this->drivers[strtoupper($signType)];

		return new $clazz($params, $salt);
	}

	/**
	 * @return AbstractSignature
	 */
	public function getSignatureProvide(): AbstractSignature
	{
		return $this->signatureProvide;
	}


	/**
	 * 返回签名参数范围
	 * @param array $params
	 * @return string[]
	 */
	public static function getRequestSignatureScopeWhenRequest(array $params): array
	{
		$scope = [
			'clientId',
			'accId',
			'transactionId',
			'merchantTransactionId',
			'amount',
			'currency',
			'notificationUrl',
			'shopperResultUrl',
			'signType',
		];

		$inScope = [];
		foreach ( $params as $key => $param ) {
			if ( in_array($key, $scope, true) ) {
				$inScope[$key] = $param;
			}
		}

		return $inScope;
	}


	public static function getRequestSignatureScopeWhenResponse(array $params): array
	{
		$inScope = [];
		foreach ( $params as $key => $param ) {
			if ( is_null($param) ) {
				continue;
			}
			$param = trim($param);
			if ( $param === '' ) {
				continue;
			}
			$inScope[$key] = $param;
		}

		return $inScope;
	}


	/**
	 * 清除不在签名范围内的参数
	 * @param array $params
	 * @param string $paramsType
	 * @return array
	 * @throws
	 */
	public function signatureScope(array $params, string $paramsType): array
	{
		$callable = [ $this, 'getRequestSignatureScopeWhen' . $paramsType ];
		if ( method_exists($callable[0], $callable[1]) ) {
			return $callable($params);
		}

		throw new  Exception('$paramsType err');
	}


}
