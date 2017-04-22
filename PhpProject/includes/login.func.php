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
function _chack_password($_password ,$_min_num){
//    判断密码的长度是否符合要求
    if(strlen($_password) < $_min_num){
        _alert_back('密码不得小于'.$_min_num.'位!');
    }    
//    返回加密获得密码
    return _mysql_string(sha1($_password));
}

/**
 * _chack_condition函数是用来返回登陆状态的
 * @param string $_string
 * @return string
 */
function _chack_condition($_string){
    return _mysql_string($_string);
}

/**
 * _setcookie生成cookie
 * @param type $_username
 * @param type $_uniqid
 */
function _setcookie($_username,$_uniqid) {
    setcookie('username',$_username);
    setcookie('uniqid',$_uniqid);
}