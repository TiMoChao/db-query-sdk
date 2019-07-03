db-query, PHP client
=======================

db-query-sdk 能让你快速接入数据平台的dbquery服务.

```php
require(dirname(__DIR__) . '/vendor/autoload.php');

$url            = 'https://digger.123u.com:8443/v1/query';
$requestTimeOut = 60;
$instance       = 'Office_MySQL';
$action         = 'Query_v2';
$sql            = "SELECT stat_day, app_plat,week,dau,dau_except_registers,session_increase,not_session_increase,all_increase,avg_online,avg_online_except_register from 
(select stat_day,app_plat,week,dau,dau_except_registers,session_increase,not_session_increase,all_increase,avg_online,avg_online_except_register 
from data_center_hero_stat.user_basic_info where app_plat=1 ORDER BY stat_day DESC limit 15) as t ORDER BY stat_day ASC";


$queryObj = new HuanLe\DBQuery\QueryClient($url, $requestTimeOut);

$queryObj->setInstance($instance);

//action coverage version
$queryObj->setPage(true);
$queryObj->setPageSize(20);
$queryObj->setCurrentPage(1);
$queryObj->setQuery($sql);
//true 返回结果是否需要格式化为配置平台输出格式，false则是返回query服务原数据，不做任何处理
$queryObj->setIsDataFormat(true);

print_r($queryObj->getQueryResult());
```

## Help and docs

- [Documentation](https://lexiangla.com/teams/k100002/docs/53c573e85c0711e995bd525400a20cd4?company_from=60347ef2a2e011e8a01e5254002f1020)


## Installing db-query-sdk

The recommended way to install Guzzle is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of db-query-sdk:

```bash
php composer.phar require 123u/db-query-sdk
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

You can then later update db-query-sdk using composer:

 ```bash
php composer.phar update
 ```

## Version Guidance

| Version | Status     | Packagist           | Namespace    | PHP Version |
|---------|------------|---------------------|--------------|-------------|
| 1.0.0    | EOL        | `123u/db-query-sdk`     | `HuanLe\DBQuery`  | >= 7.0.10    |