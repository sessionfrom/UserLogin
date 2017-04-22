<?php

/*
 * function runtime()用来获取页面加载耗时
 * @access public 表示函数对外公开
 * @return float 表示函数返回值是浮点型的
 *  */

function runtime() {
    $mtime = explode(' ', microtime());
    return($mtime[1] + $mtime[0]);
}

/**
 * _location 页面跳转
 * @access public
 * @param string $info
 * @param string $url
 * @return void
 */
function _location($info, $url) {
    echo "<script type='text/javascript'>alert('$info');location.href='$url';</script>";
    exit();
}

/**
 * _sha1_uniqid()函数是用来返回一个唯一标识符的
 * @access public
 * @return string 
 */
function _sha1_uniqid() {
    return _mysql_string(sha1(uniqid(rand(), TRUE)));
}

/*
 * _alert_back()表示JS弹窗 
 * @access public
 * @param $_info
 * @renturn void 弹窗
 *  */

function _alert_back($info) {
    echo "<script type='text/javascript'>alert('" . $info . "');history.back();</script>";
    exit();
}

/**
 * 函数_mysql_string()判断是否要转义字符串，并处理
 * @access public
 * @param string $_string
 * @return string
 */
function _mysql_string($_string) {
    if (!GBC) {    //如果get_magic_quotes_gpc()关闭则转移字符串
        return mysql_escape_string($_string);
    } else {
        return $_string;            //如果get_magic_quotes_gpc()开启则不转移字符串
    }
}

/**
 * _chack_code函数是为了防止恶意注册和跨站攻击而设定的验证码和对函数
 * @access public
 * @param string $_first_code   $_POST接收到的验证码
 * @param string $_end_code     sission中的验证码
 * @return void
 */
function _chack_code($_first_code, $_end_code) {
    if ($_first_code != $_end_code) {
        _alert_back('验证码不正确！');
        exit();
    }
}

/* _code()函数是验证码函数
 * @assess public
 * @param int $_width 表示验证码的长度
 * @param int $_height 表示验证码的宽度
 * @return void这个函数执行后产生一个验证码
 *  */

function _code($_width = 75, $_height = 25) {
    //创建一个随机码
    for ($i = 0; $i < 4; $i++) {
        $_nmsg .= dechex(mt_rand(0, 15));
        ob_clean();
    }
//将验证码保存到session里
    $_SESSION['code'] = $_nmsg;
//创建图片
    $_img = imagecreatetruecolor($_width, $_height);
//创建一个白色
    $_white = imagecolorallocate($_img, 255, 255, 255);
//填充背景
    imagefill($_img, 0, 0, $_white);
//创建一个黑色的边框
    $_black = imagecolorallocate($_img, 100, 100, 100);
    imagerectangle($_img, 0, 0, $_width - 1, $_height - 1, $_black);
//随机划线条
    for ($i = 0; $i < 6; $i++) {
        $_rnd_color = imagecolorallocate($_img, mt_rand(0, 255), mt_rand(0, 255)
                , mt_rand(0, 255));
        imageline($_img, mt_rand(0, 75), mt_rand(0, 75), mt_rand(0, 75), mt_rand(0, 75)
                , $_rnd_color);
    }
//随机打雪花
    for ($i = 1; $i < 100; $i++) {
        imagestring($_img, 1, mt_rand(1, $_width), mt_rand(1, $_height), "*", imagecolorallocate($_img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255)));
    }
//输出验证码
    for ($i = 0; $i < strlen($_SESSION['code']); $i++) {
        imagestring($_img, mt_rand(3, 5), $i * $_width / 4 + mt_rand(1, 10), mt_rand(1, $_height / 2), $_SESSION['code'][$i], imagecolorallocate($_img, mt_rand(0, 100), mt_rand(0, 150), mt_rand(0, 200)));
    }
//输出销毁
    header("Content-Type: image/png");
    imagepng($_img);
    imagedestroy($_img);
}

/**
 * _session_destroy()清空session
 */
function _session_destroy() {
    session_destroy();
}

/**
 * _unsetcookies()清楚COOKIE
 */
function _unsetcookies() {
    if (isset($_COOKIE['username']) && isset($_COOKIE['uniqid'])) {
        setcookie('username', '', time() - 1);
        setcookie('nuiqid', '', time() - 1);
        _session_destroy();
        _location('退出成功', 'index.php');
    } else {
        _alert_back('请您先登录！');
    }
}

function _login_state() {
    if (isset($_COOKIE['username'])) {
        _alert_back('登录状态无法进行本操作');
    }
}

/**
 * _html()函数用来过滤html
 * 如果传入的参数是数组，结果返回被过滤之后的数组
 * 如果传入的参数是字符串，结果返回被过滤之后的字符串
 * @param type $_string
 * @return type $_string
 */
function _html($_string) {
    if(is_array($_string)) {
        foreach ($_string as $key => $value) {
            $_string[$key] = _html($value);
        }
        
    } else {
        $_string = htmlspecialchars($_string);
    }
    return $_string;
}


/**
 * _mysql_close()数据库关闭
 */
function _mysql_close() {
    mysql_close();
}

/**
 * _peag函数，用来计算分页所需要的值
 * @global int $_peag
 * @global int $_peag_num
 * @global int $peagabsolute
 * @global int $_peag_size
 * @global int $num
 * @param string $sql
 * @param int $Pnum     该数字用来决定每一页显示的数据数目
 */
function _peag( $sql,$Pnum) {
    global $_peag,$_peag_num,$peagabsolute,$_peag_size,$num;
    if (isset($_GET['peag'])) {
        $_peag = $_GET['peag'];
        if (empty($_peag) || $_peag < 0 || !is_numeric($_peag)) {
            $_peag = 1;
        } else {
            $_peag = intval($_peag);
        }
    } else {
        $_peag = 1;
    }
    $_peag_num = $Pnum;
//获取所有数据的总条数
    $num = mysql_num_rows(_query($sql));
    if ($num == 0) {
        $_peag = 1;
    } else {
        $peagabsolute = ceil($num / $_peag_num);
    }
    if ($_peag >= $peagabsolute) {
        $_peag = $peagabsolute;
    }
    $_peag_size = ($_peag - 1) * $_peag_num;
}

/**
 * _peaging()函数是用来执行分页选项的 type=1时候为数字分页，type=2时候为文字分页
 * @global int $peagabsolute
 * @global int $_peag
 * @global int $num
 * @param int $type
 */
function _peaging($type) {
    global $peagabsolute,$_peag,$num;
    if($type == 1) {
    echo '<div id="peag_num">';
            echo '<ul>';
                for ($i = 0; $i < $peagabsolute; $i++) {
                    if ($_peag == ($i+1)) {
                        echo '<li><a href="blog.php?peag='.($i + 1).'" class="select">'.($i + 1).'<a></li>';
                    } else {
                        echo '<li><a href="blog.php?peag='.($i + 1).'">'.($i + 1).'<a></li>';
                    }
                }
            echo '</ul>';
        echo '</div>';
    } elseif ($type == 2) {
    echo '<div id="peag_text">';
                echo '<ul>';
                    echo '<li>'.$_peag.'/ '.$peagabsolute.' 页 | </li>';
                    echo '<li>共有<strong> '.$num.' </strong>个会员 | </li>';
                    if($_peag == 1) {
                        echo '<li>首页 | </li>';
                        echo '<li>上一页 | </li>';
                    } else {
                        echo '<li><a href="'.SCRIPT.'.php?peag=1">首页</a> | </li>';
                        echo '<li><a href="'.SCRIPT.'.php?peag='.($_peag-1).'">上一页</a> | </li>';
                    }
                    if($_peag == $peagabsolute) {
                        echo '<li>下一页 | </li>';
                        echo '<li>尾页 | </li>';
                    } else {
                        echo '<li><a href="'.SCRIPT.'.php?peag='.($_peag+1).'">下一页</a> | </li>';
                        echo '<li><a href="'.SCRIPT.'.php?peag='.$peagabsolute.'">尾页</a> | </li>';
                    }
                echo '</ul>';
            echo '</div>';
    }
}