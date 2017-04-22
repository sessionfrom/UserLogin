<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//防止恶意调用
if(!defined('IN_TG')){
    exit('Access Defined');
}
header("Content-type: text/html; charset=utf-8");   //设置编码

//转化为硬路径
define('ROOT_PATH',substr(dirname(__FILE__),0,-8));

//定义判断字符串是否要转义
define('GBC', get_magic_quotes_gpc());

//拒绝低版本
if(PHP_VERSION<'4.1.0'){
    exit('The version is too low!');
}

//引入函数库
require ROOT_PATH.'includes/global.func.php';
require ROOT_PATH.'includes/mysql.func.php';

//获取页面开始加载的时刻的时间
define('START_TIME', runtime());

//数据库连接
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PWD','echolove');
define('DB_NAME','testguest');

_connect();
_select_db();
_set_name();


?>