<?php
/**
 * Created by PhpStorm.
 * User: lc-timorchao
 * Date: 2019/6/24
 * Time: 17:50
 */

namespace HuanLe\DBQuery\Http;

use HuanLe\DBQuery\Core\DbQueryException;

/**
 * Class Client
 * @package HuanLe\DBQuery\Http
 */
class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    public $httpClient;

    /**
     * @var
     */
    public $param;

    /**
     * Client constructor.
     *
     * @param $url
     * @param $resquestTimeOut
     * @param $param
     */
    public function __construct($url, $resquestTimeOut, $param)
    {
        $this->httpClient = new \GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => $url,
            // You can set any number of default request options.
            'timeout'  => $resquestTimeOut,
        ]);
        $this->param      = $param;
    }

    /**
     * @explain
     * @return array
     * @throws DbQueryException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author timorchao
     */
    public function getData(): array
    {
        $response = $this->httpClient->request('POST',
            '',
            [
                'json' => $this->param,
            ]
        );

        if ($response->getStatusCode() < 200 && $response->getStatusCode() >= 300) {
            throw new DbQueryException($response);
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}