<?php
session_start();            //开启session
define('IN_TG', TRUE);                  //防止恶意调用
define('SCRIPT', 'member_modify');
require dirname(__FILE__) . '/includes/commom.inc.php';     //转换成硬路径，速度更快
//修改资料
if (@$_POST['action'] == 'modify') {
    _chack_code($_POST['yzm'], $_SESSION['code']);       //防止而已注册，跨站攻击
    if(!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")){
        if($_rows['tg_uniqid'] != $_COOKIE['uniqid']) {
            _alert_back('唯一标识符出错');
        }
        include ROOT_PATH . '/includes/register.func.php';
        $_clean = array();
        $_clean['password'] = _chack_modify_password($_POST['password'], 6);
        $_clean['sex'] = _chack_sex($_POST['sex']);
        $_clean['face'] = _chack_face($_POST['face']);
        $_clean['email'] = _chack_email($_POST['email'], 40);
        $_clean['qq'] = _chack_qq($_POST['qq'], 5, 10);
        $_clean['url'] = _chack_url($_POST['url'], 40);
        if(!empty($_clean['password'])) {
            _query("UPDATE tg_user SET "
                                        . "tg_sex='{$_clean['sex']}',"
                                        . "tg_face='{$_clean['face']}',"
                                        . "tg_email='{$_clean['email']}',"
                                        . "tg_qq='{$_clean['qq']}',"
                                        . "tg_url='{$_clean['url']}'"
                                    . " WHERE "
                                        . "tg_username='{$_COOKIE['username']}';"
                    );
        } else {
            _query("UPDATE tg_user SET "
                                        . "tg_password='{$_clean['password']}',"
                                        . "tg_sex='{$_clean['sex']}',"
                                        . "tg_face='{$_clean['face']}',"
                                        . "tg_email='{$_clean['email']}',"
                                        . "tg_qq='{$_clean['qq']}',"
                                        . "tg_url='{$_clean['url']}'"
                                    . " WHERE "
                                        . "tg_username='{$_COOKIE['username']}';"
                    );
        }
        //关闭数据库
        if (_affected_rows() != -1) {
            mysql_close();
            //跳转
            _location('恭喜你，修改成功！','member.php');
        } else {
            mysql_close();
            //跳转
            _location('很遗憾，修改失败！', 'member_modify.php');
        }  
}
}   
if(isset($_COOKIE['username'])) {
    $_row = _fetch_array("SELECT tg_username,tg_sex,tg_face,tg_email,tg_qq,tg_url FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
    if($_row) {
        $html = array();
        $html['username'] = $_row['tg_username'];
        $html['sex'] = $_row['tg_sex'];
        $html['face'] = $_row['tg_face'];
        $html['email'] = $_row['tg_email'];
        $html['qq'] = $_row['tg_qq'];
        $html['url'] = $_row['tg_url'];
        $html = _html($html);
        //性别选择
        if($html['sex'] == '男') {
            $html['sex_html'] = '<input type="radio" name ="sex" value="男" checked=checked/>男 <input type="radio" name ="sex" value="女"/>女';
        } elseif($html['sex'] == '女') {
            $html['sex_html'] = '<input type="radio" name ="sex" value="女"/>女 <input type="radio" name ="sex" value="男" checked=checked/>男';
        }
        
        //头像选择
        $html['face_html'] = '<select name="face">';
        foreach (range(1, 9) as $value) {
            $html['face_html'] .= '<option value="face/m0'.$value.'.gif">face/m0'.$value .'.gif</option>';
        }
        foreach (range(10, 64) as $value) {
            $html['face_html'] .= '<option value="face/m'.$value.'.gif">face/m'.$value .'.gif</option>';
        }
        $html['face_html'] .= '</select>'; 
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
        <script type="text/javascript" src="JS/code.js"></script>  
        <script type="text/javascript" src="JS/member_modify.js"></script> 
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
                <form method="post" name="modify" action="member_modify.php"/><!--表单是form不是from-->
                <input type="hidden" name="action" value="modify"/>     
                <dl>
                    <dd>用 户 名：<?php echo $html['username']?></dd>
                    <dd>密　　码：<input type="password" class="text" name="password"/> (留空则不修改)</dd>
                    <dd>性　　别：<?php echo $html['sex_html']?></dd>
                    <dd>头　　像：<?php echo $html['face_html']?></dd>
                    <dd>电子邮件：<input class="text" type="text" name="email" value="<?php echo $html['email']?>"/></dd>
                    <dd>个人主页：<input class="text" type="text" name="url" value="<?php echo $html['url']?>"/></dd>
                    <dd>Q　　  Q：<input class="text" type="text" name="qq" value="<?php echo $html['qq']?>"/></dd>
                    <dd>验 证 码：<input type="text" name="yzm" class="text yzm"/><img src="code.php" id="code" /></dd>
                    <dd><input type="submit" class="submit" value="修改资料"></input></dd>
                </dl>
                </form>
            </div> 
        </div>
        
         <?php
        require ROOT_PATH . 'includes/footer.inc.php';
        ?>
    </body>
</html>