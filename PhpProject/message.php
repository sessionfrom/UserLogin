<?php
session_start();            //开启session
define('IN_TG', TRUE);                  //防止恶意调用
define('SCRIPT', 'message');
require dirname(__FILE__) . '/includes/commom.inc.php';     //转换成硬路径，速度更快
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>My Project-写短信</title>       
        <?php
        require ROOT_PATH . '/includes/tital.inc.php';
        ?>      
    </head>
    <body>
        <div id="message">
            <h3>写短信</h3>
            <dl>
                <dd><input type="text" class="text"/></dd>
                <dd><textarea name="content"></textarea></dd>
                <dd>验证码 <input type="text"name="yzm"class="text yzm"/><img src="code.php" id="code" /><input type="submit" class="submit" value="发送短信"></input></dd>
            </dl>
        </div>
        
    </body>
</html>