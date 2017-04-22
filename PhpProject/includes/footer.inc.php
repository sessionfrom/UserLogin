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
define('END_TIME', runtime());

mysql_close();
?>
<div id="footer">
    <p>本网页加载时间为<?php echo round((END_TIME-START_TIME),3);?>秒</p>
    <strong>版权所有，翻版必究</strong><br> 
    <b>本网页是个人所做，源代码不希望别人使用，本人联系方式qq:<span>1789349828</span></b>
</div>