<?php


namespace PingPong\Lib\Helper;


class ServerHelper
{
	public static function getLang()
	{
		$final = "en";
		if ( $_SERVER["HTTP_ACCEPT_LANGUAGE"] && strpos($_SERVER["HTTP_ACCEPT_LANGUAGE"], ",") !== false ) {
			$exploded = explode(',', $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
			if ( $exploded ) {
				$wanted = $exploded[0];
			} else {
				return $final;
			}

			if ( $wanted ) {
				//Check separator
				if ( strpos(trim($wanted), "-") !== false ) {
					$lang_country = explode('-', trim($wanted));
				} else if ( strpos(trim($wanted), " ") !== false ) {
					$lang_country = explode(" ", trim($wanted));
				} else {
					$lang_country = "";
				}
				if ( $lang_country ) {
					$final = strtolower($lang_country[0]);
				}
			}
		}
		return $final;
	}
}