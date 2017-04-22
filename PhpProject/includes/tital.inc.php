<?php
//防止恶意调用
if (!defined('IN_TG')) {
    exit('Access Defined');
}
//防止非html页面的调用
if (!defined('SCRIPT')){
    exit('Script Error!');
}
?> 
<link rel="stylesheet"type="text/css"href="style/part1/demo.css"/>
<link rel="stylesheet"type="text/css"href="style/part1/<?php echo SCRIPT; ?>.css"/>
