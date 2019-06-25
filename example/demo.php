<?php
/**
 * Created by PhpStorm.
 * User: lc-timorchao
 * Date: 2019/6/21
 * Time: 15:00
 */

require(dirname(__DIR__) . '/vendor/autoload.php');

$url            = 'https://digger.123u.com:8443/v1/query';
$requestTimeOut = 60;
$version        = 'Query_v2';
$instance       = 'Office_MySQL';
$action         = 'Query_v2';
$sql            = "SELECT stat_day, app_plat,week,dau,dau_except_registers,session_increase,not_session_increase,all_increase,avg_online,avg_online_except_register from 
(select stat_day,app_plat,week,dau,dau_except_registers,session_increase,not_session_increase,all_increase,avg_online,avg_online_except_register 
from data_center_hero_stat.user_basic_info where app_plat=1 ORDER BY stat_day DESC limit 15) as t ORDER BY stat_day ASC";


$queryObj = new HuanLe\DBQuery\QueryClient($url, $requestTimeOut, $version);

$queryObj->setInstance($instance);

//action coverage version
$queryObj->setAction($action);
$queryObj->setQuery($sql);
$queryObj->setIsDataFormat(true);

print_r($queryObj->getQueryResult());