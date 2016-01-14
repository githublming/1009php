<?php
//>>判断地址可能来自于其他服务器
defined('WEB_URL') or define('WEB_URL','http://admin.shop.com/');
return array(
	//'配置项'=>'配置值'
    'DB_TYPE'                => 'mysql', // 数据库类型
    'DB_HOST'                => '127.0.0.1', // 服务器地址
    'DB_NAME'                => 'shop1009', // 数据库名
    'DB_USER'                => 'root', // 用户名
    'DB_PWD'                 => '123456', // 密码
    'DB_PORT'                => '', // 端口
    'DB_PREFIX'              => '', // 数据库表前缀
    'DB_PARAMS'              => array(), // 数据库连接参数
    'DB_DEBUG'               => true,
    //css样式   image图片   js效果的   地址常量
    'TMPL_PARSE_STRING'      =>array(
        '__CSS__'            =>WEB_URL.'Public/Admin/css',
        '__IMG__'            =>WEB_URL.'Public/Admin/image',
        '__JS__'             =>WEB_URL.'Public/Admin/js',
        '__LAYER__'          =>WEB_URL.'Public/Admin/layer/layer.js',
        '__UPLOADIFY__'      =>WEB_URL.'Public/Admin/uploadify',
    ),
);