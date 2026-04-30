<?php

namespace PingPong\src\Notify;

use Exception;
use PingPong\src\Core\PPConfigs;
use PingPong\src\Core\PPSignType;
use PingPong\src\Core\PPXLog;
use PingPong\src\Enum\SignParamsType;
use PingPong\src\Response\PPXNotifyResponse;
use PingPong\src\Signature\Sign;

class Notify
{
	/**
	 * 验证是否来自于PingPongX的请求
	 * @param PPConfigs $configs
	 * @param string $notifyStr
	 * @return PPXNotifyResponse
	 * @throws Exception
	 */
	public static function isPingPongPay(PPConfigs $configs, string $notifyStr): PPXNotifyResponse
	{
		PPXLog::write($notifyStr, false,'notify.log');
		$notifyArray = self::parseNotifyString($notifyStr);
		$signProvide = new Sign(PPSignType::SIGN_TYPE_MD5, $notifyArray, $configs->salt, SignParamsType::Response);
		$isPingPongPay = $signProvide->isPingPongPay($notifyArray['sign']);
		if ( $isPingPongPay !== true ) {
			PPXLog::write([
				'exception' => 'Failed to verify signature',
				'notifyStr' => $notifyStr,
				'formatNotify' => $notifyArray,
				'sign' => $signProvide->get(Sign::SIGN_TO_UPPER)
			], false, 'notify_exception.log');
			throw new Exception('Failed to verify signature');
		}
		//返回ping-pong 异步通知数据对象
		return new PPXNotifyResponse($notifyArray, true);
	}


	/**
	 * @param string $notifyStr
	 * @return mixed
	 */
	public static function parseNotifyString(string $notifyStr)
	{
		parse_str($notifyStr, $notifyArray);

		return $notifyArray;
	}



}