<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => __ROOT__. ltrim(APP_PATH,'.'). MODULE_NAME . '/View/public', //home下的public
        '__P__' => __ROOT__. '/Public', // 根目录下的Public
    ),
);