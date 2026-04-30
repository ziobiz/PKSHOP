<?php


namespace PingPong\src\Http;



abstract class AbstractHttpClient
{
    abstract public function request(string $url, string $param);

}
