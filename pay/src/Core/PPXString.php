<?php


namespace PingPong\src\Core;


class PPXString
{
    /**
     * @param $string1
     * @param $string2
     * @return bool
     */
    public static function isEqualToString($string1, $string2): bool
    {
        return strcasecmp(trim($string1), trim($string2)) === 0;
    }
}
