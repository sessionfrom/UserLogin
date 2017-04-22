<?php
if(!defined('IN_TG')){
    exit('Access Defined');
}

if(!function_exists('_alert_back')){
    exit('_alert_back()函数不存在，请检查');
}

if(!function_exists('_mysql_string')){
    exit('_mysql_string()函数不存在，请检查');
}


/**
 * 函数_chack_uniqid()是验证唯一标识符是否正常
 * @access public
 * @param string $_first_uniqid
 * @param string $_end_uniqid
 * @return string Description
 */
function _chack_uniqid($_first_uniqid,$_end_uniqid){
    if((strlen($_first_uniqid) != 40) || $_first_uniqid != $_end_uniqid){
        _alert_back('唯一标识符出现异常！');
        exit();
    } else {
        return _mysql_string($_first_uniqid);
    }
}

/**
 * 函数_chack_usename验证用户名
 * @access public  
 * @param string $_string   污染数据
 * @param int $_min_num 最小值
 * @param int $_max_num 最大值
 * @return string 用户名的过滤
 */ 
function _chack_usename($_string,$_min_num,$_max_num){
    //去掉两边的空格
    $_string1 = trim($_string);  
    //长度不能小于两位或者大于20位
    if(mb_strlen($_string1,'utf-8') < $_min_num||mb_strlen($_string1,'utf-8')>$_max_num){
        _alert_back('用户名长度不能小于'.$_min_num.'位或者大于'.$_max_num.'位');
    }
//    限制敏感字符
    $_char_pattern = '/[<>\'\"\ \　]/';
    if(preg_match($_char_pattern, $_string1)){
        _alert_back('用户名不得包含敏感字符');
        exit();
    }
    //限制敏感用户名
    $_mg[0] = '胡锦涛';
    $_mg[1] = '江泽民';
    $_mg[2] = '习近平';
    //告诉用户那些不能注册
    foreach ($_mg as $value) {
        $_mg_string = '';
        $_mg_string .= '['.$value.']'.'\n';
    }
    
    if(in_array($_string1, $_mg)){
        _alert_back($_mg_string.'以上敏感用户名不得注册');
        exit();
    }
    //调用mysql_string
    return _mysql_string($_string);
}

/**
 * 函数_chack_password验证密码
 * @access public 
 * @param string $_password
 * @param string $_notpassword
 * @param int $_min_num
 * @return string $_password 返回密码
 */
function _chack_password($_password , $_notpassword , $_min_num){
//    判断密码的长度是否符合要求
    if(strlen($_password) < $_min_num){
        _alert_back('密码不得小于'.$_min_num.'位!');
    }    
//    密码确认的判断，检查密码确认和密码是不相等
    if($_password != $_notpassword){
        _alert_back('确认密码与密码不相同！');
    }
//    返回加密获得密码
    return _mysql_string(sha1($_password));
}


/**
 * 
 * @param type $_string
 * @param type $_min_num
 * @return type
 */
function _chack_modify_password($_string,$_min_num) {
    if(!empty($_string)) {
        //    判断密码的长度是否符合要求
        if(strlen($_string) < $_min_num){
            _alert_back('密码不得小于'.$_min_num.'位!');
        } else {
            return NULL;
        }
        return _mysql_string(sha1($_string));
    }
}


/**
 * 函数_chack_hint验证密码提示
 * @access public
 * @param string $_string
 * @param string $_min_num
 * @param int $_max_num
 * @return string 返回一个转义后的字符
 */
function _chack_hint($_string,$_min_num,$_max_num){
    //长度不能小于两位或者大于20位
    if(mb_strlen($_string,'utf-8') < $_min_num||mb_strlen($_string,'utf-8')>$_max_num){
        _alert_back('密码提示不能小于'.$_min_num.'位或者大于'.$_max_num.'位');
    }
     //安全起见，对用户名进行转义
    return _mysql_string($_string);
//    return mysql_escape_string($_string);
}

/**
 * _chack_sex性别
 * @access public
 * @param string $_string
 * @return string
 */
function _chack_sex($_string){
    return _mysql_string($_string);
}

/**
 * _chack_face头像
 * @access public
 * @param string $_string
 * @return string
 */
function _chack_face($_string){
    return _mysql_string($_string);
}

/**
 * 函数_chack_email验证email,同时确定用户是否填写了email
 * @access public
 * @param string $_string
 * @param int $_max_num
 * @return string $_String
 */
function _chack_email($_string,$_max_num) {
        if(!preg_match('/^[\w\.\-]+@[\w\.\-]+(\.\w+)+$/', $_string)){
            _alert_back('邮箱地址不符合要求');
        }
        if(strlen($_string) > $_max_num){
            _alert_back('邮箱地址过长！');
        }       
    return _mysql_string($_string);
}

/**
 * 函数_chack_qq验证qq,同时确定用户是否填写了qq
 * @access public
 * @param int $_string
 * @param int $_min_num
 * @param int $_max_num
 * @return int $_String
 */
function _chack_qq($_string,$_min_num,$_max_num) {
    if(empty($_string)) {
        return NULL;
    }else {
        if(!preg_match('/^[1-9]{1}[0-9]{4,9}$/', $_string)){
            _alert_back('qq不符合要求！');
        }
        if(strlen($_string) < $_min_num || strlen($_string) > $_max_num){
            _alert_back('QQ长度不合法！');
        }
    }        
    return _mysql_string($_string);
}

/**
 * 函数_chack_url验证主页地址,同时确定用户是否填写了主页地址
 * @access public
 * @param string $_string
 * @return string $_String
 */
function _chack_url($_string,$_max_num) {
    if(empty($_string)||($_string == 'http://')) {
        return NULL;
    }else {
        if(!preg_match('/^https?:\/\/(\w+\.)?[\w\.\-]+(\.\w+)+$/', $_string)){
            _alert_back('网址不符合要求');
        }
        if(strlen($_string) > $_max_num){
            _alert_back('网站地址过长！');
        }
    }        
    return _mysql_string($_string);
}