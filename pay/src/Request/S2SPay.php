<?php
error_reporting( E_ALL );
ini_set( "display_errors", 1 );

include_once("/pay/vendor/autoload.php");

namespace PingPong\src\Request;


use PingPong\src\Core\HttpClient;
use PingPong\src\Core\PPConfigs;
use PingPong\src\Core\PPXLog;
use PingPong\src\Request\RequestPayload\CheckOut\ServerToServer\ServerToServerPayLoad;
use PingPong\src\Response\PPXS2SPayResponse;
use Exception;

class S2SPay extends AbstractRequest
{
	public const PATH = 'v2/payment';

	protected $serverToServerPayLoad;

	/**
	 * S2SPay constructor.
	 * @param PPConfigs $ppConfigs
	 * @param ServerToServerPayLoad $serverToServerPayLoad
	 */
	public function __construct(PPConfigs $ppConfigs, ServerToServerPayLoad $serverToServerPayLoad)
	{
		parent::__construct($ppConfigs->gateway);

		$this->ppConfigs = $ppConfigs;
		$serverToServerPayLoad->setSign($ppConfigs->salt, $serverToServerPayLoad->toArray());
		$this->serverToServerPayLoad = $serverToServerPayLoad;

	}

	/**
	 * @param callable|null $success
	 * @param callable|null $fail
	 * @return PPXS2SPayResponse
	 */
	public function request(?callable $success = null, ?callable $fail = null): PPXS2SPayResponse
	{
		$responseArray = $this->getHttpClient()->request($this->getRequestUrl(), $this->serverToServerPayLoad);
		PPXLog::write([
			'request' => $this->serverToServerPayLoad,
			'response' => $responseArray
		], false, 'ping_pong_s2s.log');

		if ( isset($responseArray['description'], $responseArray['status'], $responseArray['code']) ) {
			return new PPXS2SPayResponse($responseArray);
		}

		throw new Exception($responseArray['description'] ?? '请求失败', $responseArray['code'] ?? '-1');
	}

	/**
	 * @return string
	 */
	public function getRequestUrl(): string
	{
		return $this->gateway . self::PATH;
	}

	/**
	 * @return ServerToServerPayLoad
	 */
	public function getServerToServerPayLoad(): ServerToServerPayLoad
	{
		return $this->serverToServerPayLoad;
	}


}