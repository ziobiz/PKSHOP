<?php


namespace PingPong\src\Http;

use EasySwoole\HttpClient\HttpClient;
use \Exception;

class CoHttpClient extends AbstractHttpClient
{
	/**
	 * @var HttpClient
	 */
	protected $httpClient;

	public function __construct()
	{
		$this->httpClient = new HttpClient();
	}


	/**
	 * @param string $url
	 * @param string $param
	 * @throws
	 */
	public function request(string $url, string $param)
	{
		$this->httpClient->setUrl($url);
		$this->httpClient->setConnectTimeout(20);
		$this->httpClient->setTimeout(1000);
		$this->httpClient->setHeaders([
			'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17',
			'Content-Type' => 'application/json',
			'Content-Length' => strlen($param)
		]);

		$response = $this->httpClient->post($param);
		$httpCode = $response->getStatusCode();
        if ($httpCode<0){
            throw new Exception("请求失败或者超时");
        }
		if ( $httpCode >= 299 || $httpCode < 200 ) {
            var_dump($response);
			throw new Exception("request filed httpCode {$httpCode}");
		}

		if ( $response->getErrMsg() ) {
			throw new Exception($response->getErrMsg());
		}

		$responseArr = json_decode($response->getBody(), true);

		if ( empty($responseArr) ) {
		    var_dump($response->getBody());
			throw new Exception('response is not json');
		}

		return $responseArr;
	}

}