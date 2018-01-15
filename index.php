<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);
// 定义应用目录

define('APP_PATH','./Application/');

define('BIND_MODULE', 'Wanyu');
// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';
//echo date('Y-m-d H:i:s',strtotime('+23 hours 3500 seconds ',strtotime(date('Y-m-d',time())))); // 当天的2017-05-25 11:58:20，这个时刻就备份
//echo  strtotime('+23 hours 3500 seconds  ',strtotime(date('Y-m-d',time()))) - time();
//echo  C('DB_NAME');

// 亲^_^ 后面不需要任何代码了 就是如此简单
// \Org\Util\MysqlDump ::dbDump('localhost', 'root', '6689310', 'wywlsales', null, time().'wywl_sales.sql');

/*
 *
 * 这里是备份sql的代码
 *
 *
 *
 * */
// echo __ROOT__.'/sql/MySQL_time.php';
// _sock( 'http://localhost/wywlsale/sql/MySQL_time.php');//备份sql的代码