<?php

namespace PingPong\src\Core;

use Exception;
use Throwable;

define('PPX_LOG_DEFAULT',EASYSWOOLE_LOG. '/');
class PPXLog
{

	/**
	 * @param $msg Throwable|Exception|array|Object|string
	 * @param bool $die
	 * @param string $fileName
	 * @param string $path
	 * @param int $spilt
	 * @return mixed
	 */
	public static function write($msg, $die = false, string $fileName = 'PPXLog.log', string $path = '', int $spilt = 1)
	{
		$log = self::toString($msg);
		if ( empty($path) ) {
			if (defined('PPX_LOG')) {
				$path =  PPX_LOG. '/';
			}else{

			}
			$path =  PPX_LOG_DEFAULT;
		}

		if ( $spilt === 1 ) {
			$fileName = date('Ymd') . '_'.$fileName;
		}

		$stringData =
			PHP_EOL . date('Y-m-d H:i:s') . PHP_EOL .
			'---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------' . PHP_EOL
			. $log . PHP_EOL .
			'---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------' . PHP_EOL;
		file_put_contents($path . $fileName, $stringData, FILE_APPEND);
		if ( $die ) {
			exit();
		}
	}

	/**
	 * @param $message
	 * @return string
	 */
	public static function toString($message): string
	{
		if ( $message instanceof Throwable ) {
			return (new self())->getLogWithThrowable($message);
		}

		if ( $message instanceof Exception ) {
			return (new self())->getLogWithException($message);
		}

		if ( is_array($message) || is_object($message) ) {
			return json_encode($message);
		}

		return (string)$message;
	}

	/**
	 * @param Throwable $throwable
	 * @return string
	 */
	public function getLogWithThrowable(Throwable $throwable): string
	{
		return $this->format(
			$throwable->getCode(),
			$throwable->getMessage(),
			$throwable->getFile(),
			$throwable->getLine(),
			$throwable->getTraceAsString()
		);
	}

	/**
	 * @param Exception $exception
	 * @return string
	 */
	public function getLogWithException(Exception $exception): string
	{
		return $this->format(
			$exception->getCode(),
			$exception->getMessage(),
			$exception->getFile(),
			$exception->getLine(),
			$exception->getTraceAsString()
		);
	}

	/**
	 * @param int $code
	 * @param string $message
	 * @param string $file
	 * @param string $line
	 * @param $strace
	 * @return string
	 */
	public function format(int $code, string $message, string $file, string $line, $strace): string
	{
		return sprintf('code:%d \n message:%s \n file:%s line:%d \n strace:%s', $code, $message, $file, $line, $strace);
	}
}
