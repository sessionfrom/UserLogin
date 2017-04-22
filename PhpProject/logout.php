<?php
session_start();            //开启session
define('IN_TG', TRUE);                  //防止恶意调用
require dirname(__FILE__) . '/includes/commom.inc.php';     //转换成硬路径，速度更快
_unsetcookies();


?>