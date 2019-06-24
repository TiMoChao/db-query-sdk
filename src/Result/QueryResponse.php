<?php
/**
 * Created by PhpStorm.
 * User: lc-timorchao
 * Date: 2019/6/24
 * Time: 20:02
 */

namespace HuanLe\DBQuery\Result;


class QueryResponse
{
    /**
     * @var
     */
    private $requestParam;

    /**
     * @var
     */
    private $responseData;

    /**
     * QueryResponse constructor.
     *
     * @param $requestParam
     * @param $responseData
     */
    public function __construct($requestParam, $responseData)
    {
        $this->requestParam = $requestParam;
        $this->responseData = $responseData;
    }

    public  function response(){

    }
}