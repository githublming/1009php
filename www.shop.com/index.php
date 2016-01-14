<?php
header('content-type: text/html;charset=utf-8');
//书写入口文件
//判断php的版本是否大于5.2

version_compare(PHP_VERSION,'5.3','>') or exit('PHP版本低于5.3');
//定义项目文件的根目录
define('ROOT_PATH',dirname($_SERVER['SCRIPT_FILENAME']).'/');
//定义ThinkPhp的根目录
//获取整个文件的路径  home/www/shop  dirname的主要作用是获取路径的上一级
define('THINK_PATH',dirname(ROOT_PATH).'/ThinkPHP/');
//定义应用开发的目录
define('APP_PATH',ROOT_PATH.'Application/');
//定义临时文件RunTime的文件路径
define('RUNTIME_PATH',ROOT_PATH.'Runtime/');
//开启代码的调试模式
define('APP_DEBUG',true);
//使用绑定帮助我们生成  生成之后注释掉
//define('BIND_MODULE','Index');
//定义Upload文件的路径常量
define('UPLOAD_PATH',ROOT_PATH.'Uploads/');
//引入ThinkPhp.php文件
require THINK_PATH."ThinkPHP.php";
