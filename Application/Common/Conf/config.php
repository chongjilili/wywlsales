<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_FILE_DEPR'=>'_' ,
    
    //强制区分大小写
    'URL_CASE_INSENSITIVE' => false,

    'MODULE_ALLOW_LIST'     => array('Common', 'Wanyu'),
    'DEFAULT_MODULE'       => 'Wanyu', //默认分组

    //加载其他配置文件
    'LOAD_EXT_CONFIG'      => 'db', //加载扩展配置文件
    //显示页面调试信息
//    'SHOW_PAGE_TRACE'      => true,
     'SHOW_ERROR_MSG'      => true,
    //加载用户函数
    'LOAD_EXT_FILE'        => 'other',
    
     
);