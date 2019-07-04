<?php

namespace HuanLe\DBQuery\Core;

/**
 * Created by PhpStorm.
 * User: lc-timorchao
 * Date: 2019/6/21
 * Time: 15:00
 */

class Parameters
{
    public static function getGlobalParam()
    {
        $baseParam = [
            'action'        => true,
            'instance'      => true,
            'query'         => true,
            'async'         => false,
            'timeout'       => false,
            'page'          => false,
            'PageSize'      => false,
            'CurrentPage'   => false,
            'cache'         => false,
            'cache_timeout' => false,
            'operator'      => false
        ];

        $mongo = array_merge(
            $baseParam,
            [
                'db'         => true,
                'table'      => true,
                'query_func' => true,
            ]
        );

        $kafka = [
            'action'        => true,
            'instance'      => true,
            'query'         => true,
            'cache'         => false,
            'cache_timeout' => false,
            'operator'      => false
        ];

        $asyncQuery = [
            'action' => true,
            'query'  => true,
        ];

        return [
            'Query'      => $baseParam,
            'Query_v2'   => [
                'BJ_Mongo'     => $mongo,
                'BJ_Kafka'     => $kafka,
                'BJ_MySQL'     => $baseParam,
                'Office_MySQL' => $baseParam,
                'BJ_KUDU'      => $baseParam
            ],
            'AsyncQuery' => $asyncQuery
        ];
    }
}