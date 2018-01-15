<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => __ROOT__. ltrim(APP_PATH,'.'). MODULE_NAME . '/View/public', //home下的public
        '__P__' => __ROOT__. '/Public', // 根目录下的Public
    ),

  
    'ADMIN_AUTH_KEY'  => 'wy_adm_superadmin',	//超级管理员识别
    'USER_AUTH_ON'    => true,			//开启验证
    'USER_AUTH_TYPE'  => 2,				//验证类型(1:登录验证,2:实时验证[每步操作都去读数据库])
    'USER_AUTH_KEY'   => 'wy_adm_uid',			//用户认证识别号
    'NOT_AUTH_MODULE' => 'Login,Public',			//无需认证的模块(控制器)




    'NOT_AUTH_ACTION' => 'login,logout',		//无需认证的动作方法
    'RBAC_ROLE_TABLE' => C('DB_PREFIX').'role',		//数据库角色表名称
    'RBAC_USER_TABLE' => C('DB_PREFIX').'role_admin',//角色与用户的中间表名,不是用户表名
    'RBAC_ACCESS_TABLE' => C('DB_PREFIX').'access',	//权限表名
    'RBAC_NODE_TABLE'	=> C('DB_PREFIX').'node',	//节点表名称

    //'VAR_SESSION_ID' => 'PHPSESSID',//post方式 提交 session_id//Public uploadFile
    'TMPL_TEMPLATE_SUFFIX' => '.html',//模板后缀

    //去掉伪静态后缀
    'URL_HTML_SUFFIX' => '',

    'URL_MODEL'            => 3, //URL模式
    //禁止路由
    'URL_ROUTER_ON' => false,
    //禁止静态缓存
    'HTML_CACHE_ON' => false,




/*

    //邮件配置
    'THINK_EMAIL' => array(
        'SMTP_HOST'   => 'smtp.qq.com', //SMTP服务器
        'SMTP_PORT'   => '465', //SMTP服务器端口
        'SMTP_USER'   => '2738805199', //SMTP服务器用户名
        'SMTP_PASS'   => 'yrtrcswhzdcrdebb', //SMTP服务器密码
        'FROM_EMAIL'  => '2738805199@qq.com', //发件人EMAIL
        'FROM_NAME'   => 'lili在线', //发件人名称
        //'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
        //'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
    ),*/



    

);