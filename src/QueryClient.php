<?php

namespace HuanLe\DBQuery;

/**
 * Created by PhpStorm.
 * User: lc-timorchao
 * Date: 2019/6/21
 * Time: 10:54
 */

use HuanLe\DBQuery\Core\DbQueryException;
use HuanLe\DBQuery\Core\Helper;
use HuanLe\DBQuery\Http\Client;
use HuanLe\DBQuery\Result\QueryResponse;

/**
 * init
 * Class QueryClient
 * @package HuanLe\DBQuery
 */
class QueryClient
{
    //instance type
    const INSTANCE_BJ_MYSQL = 'BJ_MySQL';
    const INSTANCE_BJ_KUDU = 'BJ_KUDU';
    const INSTANCE_OFFICE_MYSQL = 'Office_MySQL';
    const INSTANCE_BJ_MONGO = 'BJ_Mongo';
    const INSTANCE_BJ_KAFKA = 'BJ_Kafka';

    //action type
    const ACTION_TYPE_QUERY_V2 = 'Query_v2';
    const ACTION_TYPE_QUERY = 'Query';

    static $ACTION_TYPE = [
        self::ACTION_TYPE_QUERY_V2,
        self::ACTION_TYPE_QUERY,
    ];

    static $INSTANCE_V2_TYPE = [
        self::INSTANCE_BJ_MYSQL,
        self::INSTANCE_BJ_KUDU,
        self::INSTANCE_OFFICE_MYSQL,
        self::INSTANCE_BJ_MONGO,
        self::INSTANCE_BJ_KAFKA,
    ];

    static $INSTANCE_V1_TYPE = [
        self::INSTANCE_BJ_MYSQL,
        self::INSTANCE_BJ_KUDU,
        self::INSTANCE_OFFICE_MYSQL,
    ];

    //default
    const DB_QUERY_HOST = 'https://digger.123u.com:8443/v1/query';
    const DB_QUERY_VERSION = 'Query_v2';
    const DB_QUERY_TIMEOUT = 60;
    const DB_QUERY_PARAM_CACHE = true;
    const DB_QUERY_PARAM_CACHE_TIMEOUT = 86400;
    const DB_QUERY_PARAM_ASYNC = false;
    const DB_QUERY_PARAM_TIMEOUT = 360;
    const DB_QUERY_PARAM_PAGESIZE = 20;
    const DB_QUERY_PARAM_CURRENTPAGE = 1;

    private $host;
    private $requestTimeOut;
    private $version;
    private $param = [];

    private $action;
    private $db;
    private $table;
    private $queryFunc;
    private $instance;
    private $query;
    private $async;
    private $timeOut;
    private $page;
    private $pageSize;
    private $currentPage;
    private $cache;
    private $cacheTimeOut;
    private $operator;
    private $isDataFormat;

    /**
     * @return mixed
     */
    public function getIsDataFormat()
    {
        return $this->isDataFormat;
    }

    /**
     * @param mixed $isDataFormat
     */
    public function setIsDataFormat($isDataFormat)
    {
        $this->isDataFormat = $isDataFormat;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getRequestTimeOut()
    {
        return $this->requestTimeOut;
    }

    /**
     * @param mixed $requestTimeOut
     */
    public function setRequestTimeOut($requestTimeOut)
    {
        $this->requestTimeOut = $requestTimeOut;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->param['version'] = $version;
        $this->version          = $version;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @explain
     *
     * @param $action
     *
     * @throws DbQueryException
     * @author timorchao
     */
    public function setAction($action)
    {
        if (!in_array($action, QueryClient::$ACTION_TYPE)) {
            throw new DbQueryException("action need 'Query or Query_v2'");
        }
        $this->setVersion($action);
        $this->param['action'] = $action;
        $this->action          = $action;
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param mixed $db
     */
    public function setDb($db)
    {
        $this->param['db'] = $db;
        $this->db          = $db;
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table)
    {
        $this->param['table'] = $table;
        $this->table          = $table;
    }

    /**
     * @return mixed
     */
    public function getQueryFunc()
    {
        return $this->queryFunc;
    }

    /**
     * @param mixed $queryFunc
     */
    public function setQueryFunc($queryFunc)
    {
        $this->param['query_func'] = $queryFunc;
        $this->queryFunc           = $queryFunc;
    }

    /**
     * @return mixed
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * @param mixed $instance
     */
    public function setInstance($instance)
    {
        $this->param['instance'] = $instance;
        $this->instance          = $instance;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query)
    {
        $this->param['query'] = $query;
        $this->query          = $query;
    }

    /**
     * @return mixed
     */
    public function getAsync()
    {
        return $this->async;
    }

    /**
     * @param mixed $async
     */
    public function setAsync($async)
    {
        $this->param['async'] = $async;
        $this->async          = $async;
    }

    /**
     * @return mixed
     */
    public function getTimeOut()
    {
        return $this->timeOut;
    }

    /**
     * @param mixed $timeOut
     */
    public function setTimeOut($timeOut)
    {
        $this->param['timeout'] = $timeOut;
        $this->timeOut          = $timeOut;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->param['page'] = $page;
        $this->page          = $page;
    }

    /**
     * @return mixed
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @param mixed $pageSize
     */
    public function setPageSize($pageSize)
    {
        $this->param['PageSize'] = $pageSize;
        $this->pageSize          = $pageSize;
    }

    /**
     * @return mixed
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @param mixed $currentPage
     */
    public function setCurrentPage($currentPage)
    {
        $this->param['CurrentPage'] = $currentPage;
        $this->currentPage          = $currentPage;
    }

    /**
     * @return mixed
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param mixed $cache
     */
    public function setCache($cache)
    {
        $this->param['cache'] = $cache;
        $this->cache          = $cache;
    }

    /**
     * @return mixed
     */
    public function getCacheTimeOut()
    {
        return $this->cacheTimeOut;
    }

    /**
     * @param mixed $cacheTimeOut
     */
    public function setCacheTimeOut($cacheTimeOut)
    {
        $this->param['cache_timeout'] = $cacheTimeOut;
        $this->cacheTimeOut           = $cacheTimeOut;
    }

    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param mixed $operator
     */
    public function setOperator($operator)
    {
        $this->param['operator'] = $operator;
        $this->operator          = $operator;
    }

    /**
     * QueryClient constructor.
     *
     * @param $host
     * @param $requestTimeOut
     * @param $version
     *
     * @throws DbQueryException
     */
    public function __construct($host, $requestTimeOut, $version)
    {
        $host           = trim($host);
        $requestTimeOut = trim($requestTimeOut);
        $version        = trim($version);

        if (empty($host)) {
            throw new DbQueryException("host is empty");
        }
        if (empty($requestTimeOut)) {
            throw new DbQueryException("request timeout is empty");
        }
        if (empty($version)) {
            throw new DbQueryException("sdk version is empty");
        }

        $this->setHost($host);
        $this->setRequestTimeOut($requestTimeOut);
        $this->setVersion($version);

        //default param
        $this->param['cache']         = self::DB_QUERY_PARAM_CACHE;
        $this->param['cache_timeout'] = self::DB_QUERY_PARAM_CACHE_TIMEOUT;
        $this->param['async']         = self::DB_QUERY_PARAM_ASYNC;
        $this->param['timeout']       = self::DB_QUERY_PARAM_TIMEOUT;
        $this->param['PageSize']      = self::DB_QUERY_PARAM_PAGESIZE;
        $this->param['CurrentPage']   = self::DB_QUERY_PARAM_CURRENTPAGE;

        Helper::checkEnv();
    }

    /**
     * @explain
     * @return array
     * @throws DbQueryException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author timorchao
     */
    public function getQueryResult(): array
    {
        //check param
        Helper::checkParam($this->param);

        //start request
        $Client = new Client($this->getHost(), $this->getRequestTimeOut(), $this->param);

        $result = $Client->getData();

        if ($this->getIsDataFormat()) {
            //result of handling
            $obj = new QueryResponse($this->param, $result);
            return $obj->response();
        }
        return $result;
    }
}