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

    public static function verificaToken($token)
    {
        $header = [
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'Authorization' => 'Bearer '.$token,
        ];
       return self::conection('get', 'http://172.17.0.1:9000/api/validatoken', $header)->getStatusCode();
    }

    public static function request($verb, $param = null, $body = null, $token)
    {
        $url = $param ? 'http://172.17.0.1:8001/api/wallet/'.$param  : 'http://172.17.0.1:8001/api/wallet';
        $header = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ];
        return json_decode(self::conection($verb, $url, $header, $body)->getBody()->getContents());
    }

    public static function requestAutorization($verb, $url)
    {
        $header = [
            'Content-Type'  => 'application/json'
        ];

        return self::conection($verb, $url, $header);
    }

    public static function notification($verb, $url)
    {
        $header = [
            'Content-Type'  => 'application/json'
        ];

        return json_decode(self::conection($verb, $url, $header)->getBody()->getContents());
    }

    public static function rollBackTransaction($verb, $url, $body, $token)
    {
        $header = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ];

        return json_decode(self::conection($verb, $url, $header, $body)->getBody()->getContents());
    }

}
