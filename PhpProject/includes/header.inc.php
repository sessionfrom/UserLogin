<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//防止恶意调用
if(!defined('IN_TG')){
    exit('Access Defined');
}
?>
    <div id="header">
        <h1><a href="index.php">多用户留言系统-首页</a></h1>
        <ul>
            <li><a href="index.php">首页</a></li>
            <?php
            if(isset($_COOKIE['username'])) {
                echo '<li><a href="member.php">'.$_COOKIE['username'].'•个人中心</li>';
//                echo "\n";
//                echo "\t\t";
            } else {
                echo '<li><a href="register.php">注册</a></li>';
                echo "\n";
                echo '<li><a href="login.php">登录</a></li>';
                echo "\n";
            }
            ?>
            
            <li><a href="blog.php">博友</a></li>
            <?php
                echo '<li><a href="logout.php">风格</a></li>';
            ?>
            <?php
                echo '<li><a href="logout.php">管理</a></li>';
            ?>
            <!--<li>风格</li>-->
            <!--<li>管理</li>-->
            <?php
                echo '<li><a href="logout.php">退出</a></li>';
            ?>
            
        </ul>
    </div>
