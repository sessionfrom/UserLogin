<?php
session_start();            //开启session
define('IN_TG', TRUE);                  //防止恶意调用
define('SCRIPT', 'member');
require dirname(__FILE__) . '/includes/commom.inc.php';     //转换成硬路径，速度更快
if(isset($_COOKIE['username'])) {
    $_row = _fetch_array("SELECT tg_username,tg_sex,tg_face,tg_reg_time,tg_email,tg_qq,tg_url,tg_level FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
    if($_row) {
        $html = array();
        $html['username'] = $_row['tg_username'];
        $html['sex'] = $_row['tg_sex'];
        $html['face'] = $_row['tg_face'];
        $html['reg_time'] = $_row['tg_reg_time'];
        $html['email'] = $_row['tg_email'];
        $html['qq'] = $_row['tg_qq'];
        $html['url'] = $_row['tg_url'];
        $html['level'] = $_row['tg_level'];
        switch ($html['level']) {
            case 0:
                $html['level'] = '普通会员';
                break;
            case 1:
                $html['level'] = '管理员';
                break;
            default: _alert_back("出错");
        }
        $html = _html($html);
    } else {
        _alert_back('该用户不存在！');
    }
} else {
    _alert_back('非法登录！');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>My Project-博友</title>       
        <?php
        require ROOT_PATH . '/includes/tital.inc.php';
        ?>      
    </head>
    <body>
        <?php
        require ROOT_PATH . 'includes/header.inc.php';
        ?>  
        <div id="member">
            <?php
                    require ROOT_PATH.'/includes/member.inc.php';
            ?>
            <div id="member_main">
                <h2>会员管理中心</h2>
                <dl>
                    <dd>用 户 名：<?php echo $html['username']?></dd>
                    <dd>性　　别：<?php echo $html['sex']?></dd>
                    <dd>头　　像：<?php echo $html['face']?></dd>
                    <dd>电子邮件：<?php echo $html['email']?></dd>
                    <dd>个人主页：<?php echo $html['url']?></dd>
                    <dd>Q　　  Q：<?php echo $html['qq']?></dd>
                    <dd>注册时间：<?php echo $html['reg_time']?></dd>
                    <dd>身　　份：<?php echo $html['level']?></dd>
                </dl>
            </div> 
        </div>
        
         <?php
        require ROOT_PATH . 'includes/footer.inc.php';
        ?>
    </body>
</html>