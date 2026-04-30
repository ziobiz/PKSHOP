<?php

namespace PingPong\src\Http;

use Exception;

class Curl extends AbstractHttpClient
{
	/**
	 * @param string $url
	 * @param string $param
	 * @return array
	 * @throws Exception
	 */
	public function request(string $url, string $param): array
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);//send values
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 50); //timeout in seconds
		//curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		// Set HTTP Header for POST request
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Content-Length: ' . strlen($param) ]);
		$responseStr = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ( $httpCode >= 299 || $httpCode < 200 ) {
			throw new Exception("request filed httpCode {$httpCode}");
		}

		if ( empty($responseStr) ) {
			throw new Exception('empty response');
		}

		$responseArr = json_decode($responseStr, true);
		if ( empty($responseArr) ) {
			throw new Exception('response is not json');
		}

		return $responseArr;
	}
}
