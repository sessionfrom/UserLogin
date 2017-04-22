<?php
session_start();            //开启session
define('IN_TG', TRUE);                  //防止恶意调用
define('SCRIPT', 'login');
require dirname(__FILE__) . '/includes/commom.inc.php';     //转换成硬路径，速度更快
//登录状态
_login_state();
//开始进行登陆验证
if (isset($_POST['action']) == 'login') {      
    _chack_code($_POST['yzm'],$_SESSION['code']);       //防止恶意注册，跨站攻击
    include ROOT_PATH . '/includes/login.func.php';     //引入验证文件
    $_clean = array();  //接收数据
    $_clean['username'] = _chack_usename($_POST['username'],2,20);
    $_clean['password'] = _chack_password($_POST['password'],6);
    $_clean['condition'] = _chack_condition($_POST['condition']);
    //数据库验证
    if(!!$_row = _fetch_array("SELECT tg_username,tg_uniqid FROM tg_user WHERE tg_username='{$_clean['username']}' AND tg_password='{$_clean['password']}' AND tg_active='' LIMIT 1")){              
        _setcookie($_row['tg_username'], $_row['tg_uniqid']);
        _location('登录成功', 'index.php');
        //登录成功后，记录登录次数
        _query("UPDATE tg_user SET "
                            . "tg_last_time=NOW(),"
                            . "tg_login_times=tg_login_times+1 "
                        . "WHERE "
                            . "tg_username='{$_rows['tg_username']}' "
                            );
        _mysql_close();
        _session_destroy();
    }else {
        _mysql_close();
        _session_destroy();
        _location('用户不存在，或者密码错误！','login.php');
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>My Project-会员登录</title>       
        <?php
        require ROOT_PATH . '/includes/tital.inc.php';
        ?>      
        <script type="text/javascript" src="JS/login.js"></script>
        <script type="text/javascript" src="JS/code.js"></script>
    </head>
    <body>
        <?php
        require ROOT_PATH . 'includes/header.inc.php';
        ?>        
        <div id="login">
            <h2>登录</h2>
            <form method="post" name="login" action="login.php"/><!--表单是form不是from-->
            <input type="hidden" name="action" value="login"/>
            <!--<input type="hidden" name="uniqid" value="<?php // echo $_uniqid;?>"/>-->
            <dl>
                <dt> </dt>
                <dd>户　　名 ： <input type="text" name="username" class="text username"/></dd>
                <dd>密　　码 ： <input type="password"name="password"class="text password" /></dd>
                <dd>登录状态 ： <input type="radio" name="condition" value="1" checked="checked">在线</input> <input type="radio" name="condition" value="2">隐身</input></dd>
                <dd>验 证 码 &nbsp;： <input type="text"name="yzm"class="text yzm"/><img src="code.php" id="code" /></dd>
                <dd><input type="submit" class="submit" value="登录"/><input type="submit" class="location" value="注册"/></dd>
            </dl>
        </div>
        
        
        
        <?php
        require ROOT_PATH . 'includes/footer.inc.php';
        ?>
    </body>
</html>
