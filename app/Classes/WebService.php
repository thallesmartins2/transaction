<?php

namespace App\Classes;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Client;


class WebService
{
    public static function conection($verb, $url, $header, $body = null)
    {
        $client = new Client();
        $res = $client->request($verb, $url, [
            'headers' => $header,
            \GuzzleHttp\RequestOptions::JSON => $body
        ]);
        return $res;
    }

    public static function request($verb, $param = null, $body = null)
    {
        $url = $param ? 'http://172.17.0.1:8001/api/wallet/'.$param  : 'http://172.17.0.1:8001/api/wallet';
        $header = [
            'Content-Type'  => 'application/json'
            // 'Authorization' => 'Bearer '.$token,
        ];
        return json_decode(self::conection($verb, $url, $header, $body)->getBody()->getContents());
    }

    public static function requestAutorization($verb, $url)
    {
        $header = [
            'Content-Type'  => 'application/json'
            // 'Authorization' => 'Bearer '.$token,
        ];

        return self::conection($verb, $url, $header);
    }

    public static function notification($verb, $url)
    {
        $header = [
            'Content-Type'  => 'application/json'
            // 'Authorization' => 'Bearer '.$token,
        ];

        return json_decode(self::conection($verb, $url, $header)->getBody()->getContents());
    }

    public static function rollBackTransaction($verb, $url, $body)
    {
        $header = [
            'Content-Type'  => 'application/json'
            // 'Authorization' => 'Bearer '.$token,
        ];

        return json_decode(self::conection($verb, $url, $header, $body)->getBody()->getContents());
    }

}
