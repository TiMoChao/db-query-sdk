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
        $version  = $param['version'];
        $instance = $param['instance'];

        if (!in_array($version, QueryClient::$ACTION_TYPE)) {
            throw new DbQueryException("version need 'Query or Query_v2'");
        }

        $newParam = $param;
        unset($newParam['version']);

        if ($version == QueryClient::ACTION_TYPE_QUERY) {
            if (!in_array($instance, QueryClient::$INSTANCE_V1_TYPE)) {
                throw new DbQueryException("The instance has no matches for query'");
            }
            self::paramIsNecessary(Parameters::getGlobalParam()[QueryClient::ACTION_TYPE_QUERY], $newParam);
        } elseif ($version == QueryClient::ACTION_TYPE_QUERY_V2) {
            if (!in_array($instance, QueryClient::$INSTANCE_V2_TYPE)) {
                throw new DbQueryException("The instance has no matches for query_v2'");
            }
            self::paramIsNecessary(Parameters::getGlobalParam()[QueryClient::ACTION_TYPE_QUERY_V2][$instance],
                $newParam);
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
     * @return bool
     * @throws DbQueryException
     * @author timorchao
     */
    private static function paramIsNecessary($param, $needCheckParam)
    {
//        $flag = true;
        foreach ($param as $key => $value) {
            if ($value) {
                if (isset($needCheckParam[$key]) || array_key_exists($key, $needCheckParam)) {
                    continue;
                } else {
                    throw new DbQueryException("param {$key} is necessary,Please input it");
//                    $flag = false;
//                    break;
                }
            } else {
                continue;
            }
        }
//        return $flag;
    }
}