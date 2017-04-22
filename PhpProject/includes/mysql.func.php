<?php
//防止恶意调用
if(!defined('IN_TG')){
    exit('Access Defined');
}

/**
 * _connect函数是连接数据库的
 * @access public
 * @return void
 */
function _connect() {
    if(!@mysql_connect(DB_HOST, DB_USER, DB_PWD)) {
        exit('数据库连接错误！');
    } 
}

function _affected_rows(){
    mysql_affected_rows();
}

/**
 * _select_db函数是选择数据库的 
 * @access public
 * @return void
 */
function _select_db() {
    //选择一款数据库
    if(!mysql_select_db(DB_NAME)){
        exit('数据库选择错误！');
    }
}

/**
 * _set_name函数是设置字符集的
 * @access public
 * @return void
 */
function _set_name() {
    //设置字符集
    if(!mysql_query('SET NAMES UTF8')){
        exit('字符集错误！');
    }
}

function _num_rows($result) {
    return mysql_num_rows($result);
}


/**
 * 
 * @param type $_sql
 * @return type
 * 以下三个函数是用来验证用户名是否已经存在
 */
function _query($_sql) {
    if(!mysql_query($_sql)){
        exit('SQL语句有错误'. mysql_error());
    } else {
        return mysql_query($_sql);
    }
}
/**
 * _fetch_array()只能获取一个数据组
 * @param type $_sql
 * @return int
 */
function _fetch_array($_sql) {
    if(mysql_fetch_array(_query($_sql),MYSQLI_ASSOC)){
        return mysql_fetch_array(_query($_sql));
    }
}

/**
 * _fetch_array_list()可以获取指定结果集的所有数据
 * @param type $_result
 * @return type
 */
function _fetch_array_list($_result) {
        return mysql_fetch_array($_result,MYSQL_ASSOC);
}
/**
 * 
 * @param type $_sql
 * @param type $_info
 */
function _is_repeat($_sql,$_info){
    if(_fetch_array($_sql)){
        _alert_back($_info);
    }
}