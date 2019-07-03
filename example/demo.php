<?php
/**
 * Created by PhpStorm.
 * User: lc-timorchao
 * Date: 2019/6/21
 * Time: 15:00
 */

require(dirname(__DIR__) . '/vendor/autoload.php');

/**
 * use Office_MySQL and BJ_KUDU and BJ_MySQL
 */
$url            = 'https://digger.123u.com:8443/v1/query';
$requestTimeOut = 60;
$instance       = 'Office_MySQL';
$action         = 'Query_v2';
$sql            = "SELECT stat_day, app_plat,week,dau,dau_except_registers,session_increase,not_session_increase,all_increase,avg_online,avg_online_except_register from 
(select stat_day,app_plat,week,dau,dau_except_registers,session_increase,not_session_increase,all_increase,avg_online,avg_online_except_register 
from data_center_hero_stat.user_basic_info where app_plat=1 ORDER BY stat_day DESC limit 15) as t ORDER BY stat_day ASC";


$queryObj = new HuanLe\DBQuery\QueryClient($url, $requestTimeOut);
$queryObj->setInstance($instance);
$queryObj->setAction($action);

//action coverage version
$queryObj->setPage(true);
$queryObj->setPageSize(20);
$queryObj->setCurrentPage(1);
$queryObj->setQuery($sql);
$queryObj->setIsDataFormat(true);

//print_r($queryObj->getQueryResult());

/**
 * use BJ_Mongo
 */
$queryObj->setAction('Query_v2');
$queryObj->setInstance('BJ_Mongo');
$queryObj->setQuery(new \stdClass());
$queryObj->setAsync(false);
$queryObj->setDb('yxs');
$queryObj->setTable('preserve_test_warren');
$queryObj->setPage(true);
$queryObj->setPageSize(5);
$queryObj->setCurrentPage(1);
$queryObj->setCache(false);
$queryObj->setOperator('timorchao');
$queryObj->setQueryFunc('find');
$queryObj->setIsDataFormat(false);
//print_r($queryObj->getQueryResult());
//
///**
// * use BJ_Kafka
// */
$queryObj->setAction('Query_v2');
$queryObj->setInstance('BJ_Kafka');
$queryObj->setQuery('select _ACCOUNTID,_APP,_DISTINCTID,_EVENTNAME,_TIME from yxs_event limit 2');
$queryObj->setAsync(false);
$queryObj->setCache(false);
$queryObj->setOperator('timorchao');
$queryObj->setIsDataFormat(true);
print_r($queryObj->getQueryResult());