<?php
/**
 * Created by PhpStorm.
 * User: lc-timorchao
 * Date: 2019/6/24
 * Time: 16:07
 */

namespace HuanLe\DBQuery\Core;


use HuanLe\DBQuery\QueryClient;

require_once 'parameters.php';

class Helper
{
    /**
     * @explain check extension
     * @throws DbQueryException
     * @author timorchao
     */
    public static function checkEnv()
    {
        if (function_exists('get_loaded_extensions')) {
            //check curl extension
            $enabled_extension = ["curl"];
            $extensions        = get_loaded_extensions();
            if ($extensions) {
                foreach ($enabled_extension as $item) {
                    if (!in_array($item, $extensions)) {
                        throw new DbQueryException("Extension {" . $item . "} is not installed or not enabled, please check your php env.");
                    }
                }
            } else {
                throw new DbQueryException("function get_loaded_extensions not found.");
            }
        } else {
            throw new DbQueryException('Function get_loaded_extensions has been disabled, please check php config.');
        }
    }


    /**
     * @explain
     *
     * @param $param
     *
     * @throws DbQueryException
     * @author timorchao
     */
    public static function checkParam($param)
    {
        $action = $param['action'];

        if (!in_array($action, QueryClient::$ACTION_TYPE)) {
            throw new DbQueryException("version need 'Query or Query_v2, AsyncQuery");
        }

        if ($action == QueryClient::ACTION_TYPE_QUERY) {
            $param['instance'];
            if (!in_array($instance, QueryClient::$INSTANCE_V1_TYPE)) {
                throw new DbQueryException("The instance has no matches for query'");
            }
            self::paramIsNecessary(Parameters::getGlobalParam()[QueryClient::ACTION_TYPE_QUERY], $param);
        } elseif ($action == QueryClient::ACTION_TYPE_QUERY_V2) {
            $param['instance'];
            if (!in_array($instance, QueryClient::$INSTANCE_V2_TYPE)) {
                throw new DbQueryException("The instance has no matches for query_v2'");
            }
            self::paramIsNecessary(Parameters::getGlobalParam()[QueryClient::ACTION_TYPE_QUERY_V2][$instance],
                $param);
        } elseif ($action == QueryClient::ACTION_TYPE_ASYNCQUERY) {
            self::paramIsNecessary(Parameters::getGlobalParam()[QueryClient::ACTION_TYPE_ASYNCQUERY],
                $param);
        } else {
            // TODO Next version
        }
    }

    /**
     * @explain
     *
     * @param $param
     * @param $needCheckParam
     *
     * @throws DbQueryException
     * @author timorchao
     */
    private static function paramIsNecessary($param, $needCheckParam)
    {
        foreach ($param as $key => $value) {
            if ($value) {
                if (isset($needCheckParam[$key]) || array_key_exists($key, $needCheckParam)) {
                    continue;
                } else {
                    throw new DbQueryException("param {$key} is necessary,Please input it");
                }
            } else {
                continue;
            }
        }

        //check pagination
        if (isset($needCheckParam['page']) || array_key_exists('page', $needCheckParam)) {
            if (!(isset($needCheckParam['PageSize']) || array_key_exists('PageSize',
                        $needCheckParam)) || !(isset($needCheckParam['CurrentPage']) || array_key_exists('CurrentPage',
                        $needCheckParam))) {
                throw new DbQueryException("param pagination is necessary,Please input it");
            }
        }
    }
}