<?php
session_start();            //开启session
define('IN_TG', TRUE);                  //防止恶意调用
define('SCRIPT', 'register');
require dirname(__FILE__) . '/includes/commom.inc.php';     //转换成硬路径，速度更快
////登录状态
_login_state();
//判断是否提交了数据
if (@$_POST['action'] == 'register') {
    _chack_code($_POST['yzm'], $_SESSION['code']);       //防止而已注册，跨站攻击
    include ROOT_PATH . '/includes/register.func.php';
    $_clean = array();
    //可以通过创建唯一标识符来防止恶意注册，伪造表单，跨站攻击等...
    //唯一标识符存放进数组中的另一个好处是cookie的登录验证
    $_clean['uniqid'] = _chack_uniqid($_POST['uniqid'], $_SESSION['uniqid']);
    //创建第二个唯一标识符，用来激活用户的
    $_clean['active'] = _sha1_uniqid();
    $_clean['username'] = _chack_usename($_POST['username'], 2, 20);
    $_clean['password'] = _chack_password($_POST['password'], $_POST['notpassword'], 6);
    $_clean['hint'] = _chack_hint($_POST['hint'], 3, 20);
    $_clean['sex'] = _chack_sex($_POST['sex']);
    $_clean['face'] = _chack_face($_POST['face']);
    $_clean['email'] = _chack_email($_POST['email'], 40);
    $_clean['qq'] = _chack_qq($_POST['qq'], 5, 10);
    $_clean['url'] = _chack_url($_POST['url'], 40);
    //在新增之前，要判断用户名是否重复
    $_sql = "SELECT tg_username FROM tg_user WHERE tg_username = '{$_clean['username']}' LIMIT 1";
    _is_repeat($_sql, '该用户名已存在，请重新注册！');
    //新增用户
    mysql_query(
                    "INSERT INTO tg_user("
                    . "tg_uniqid,"
                    . "tg_active,"
                    . "tg_username,"
                    . "tg_password,"
                    . "tg_hint,"
                    . "tg_sex,"
                    . "tg_face,"
                    . "tg_email,"
                    . "tg_qq,"
                    . "tg_url,"
                    . "tg_reg_time,"
                    . "tg_last_time,"
                    . "tg_last_ip"
                    . ")VALUE("
                    . "'{$_clean['uniqid']}',"
                    . "'{$_clean['active']}',"
                    . "'{$_clean['username']}',"
                    . "'{$_clean['password']}',"
                    . "'{$_clean['hint']}',"
                    . "'{$_clean['sex']}',"
                    . "'{$_clean['face']}',"
                    . "'{$_clean['email']}',"
                    . "'{$_clean['qq']}',"
                    . "'{$_clean['url']}',"
                    . "NOW(),"
                    . "NOW(),"
                    . "'{$_SERVER["REMOTE_ADDR"]}'"
                    . ")"
            ) or die('错误：' . mysql_error());
    //关闭数据库
    if (_affected_rows() != -1) {
        mysql_close();
        //跳转
        _location('恭喜你，注册成功！', 'active.php?active=' . $_clean['active']);
    } else {
        mysql_close();
        //跳转
        _location('很遗憾，注册失败！', 'register.php');
    }
} else {
    $_SESSION['uniqid'] = $_uniqid = _sha1_uniqid();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>My Project-注册会员</title>       
        <?php
        require ROOT_PATH . '/includes/tital.inc.php';
        ?>       
        <script type="text/javascript" src="JS/register.js"></script>
        <script type="text/javascript" src="JS/code.js"></script>
    </head>
    <body>
        <?php
        require ROOT_PATH . 'includes/header.inc.php';
        ?>
        <div id="register">
            <h2>会员注册</h2>
            <form method="post" name="register" action="register.php"/><!--表单是form不是from-->
            <input type="hidden" name="action" value="register"/>
            <input type="hidden" name="uniqid" value="<?php echo $_uniqid; ?>"/>
            <dl>
                <dt>请认真填写以下内容</dt>
                <dd>用 户 名 <input type="text" name="username" class="text username"/> (*必填，至少两位)</dd>
                <dd>设置密码 <input type="password"name="password"class="text" /> (*必填，至少6位)</dd>
                <dd>确认密码 <input type="password"name="notpassword"class="text"/> (*必填，同上)</dd>
                <dd>密码提示 <input type="text"name="hint"class="text"/> (*必填，至少两位)</dd>
<!--                <dd>密码回答：<input type="text"name="passda"class="text"/> (*必填，至少两位)</dd>-->
                <dd>性　别  <input type="radio"name="sex"value="男"checked="checked">男</input> <input type="radio"name="sex"value="女">女</input></dd>
                <dd class="face">
                    <input type="hidden" name="face" value="face/m01.gif" id="interesting"/>
                    <img src="face/m01.gif" alt="头像选择" title="face.php" id="faceimg"/>
                </dd> 
                <dd>电子邮箱 <input type="text"name="email"class="text"/> (*必填)</dd>
                <dd>Q　Q  <input type="text"name="qq"class="text qq"/></dd>
                <dd>主页地址 <input type="text"name="url"class="text"value="http://"/></dd>
                <dd>验证码 <input type="text"name="yzm"class="text yzm"/><img src="code.php" id="code" /></dd>
                <dd><input type="submit" class="submit" value="注册"></input></dd>
            </dl>
        </div>
        <?php
        require ROOT_PATH . 'includes/footer.inc.php';
        ?>
    </body>
</html>
