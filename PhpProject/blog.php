<?php
session_start();            //开启session
define('IN_TG', TRUE);                  //防止恶意调用
define('SCRIPT', 'blog');
require dirname(__FILE__) . '/includes/commom.inc.php';     //转换成硬路径，速度更快
//页码设置
//参数一是用来查询数据库中的所有元素，参数而是每一页显示的数据条数
_peag("SELECT tg_id FROM tg_user", 10);

//从数据库中取出结果集
$_result = _query("SELECT  tg_id,tg_username,tg_face,tg_sex FROM tg_user ORDER BY tg_reg_time DESC LIMIT $_peag_size,$_peag_num");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>My Project-博友</title>   
        <script type="text/javascript" src="JS/blog.js"></script>
        <?php
        require ROOT_PATH . '/includes/tital.inc.php';
        ?>      
    </head>
    <body>
        <?php
        require ROOT_PATH . 'includes/header.inc.php';
        ?>        
        <div id="blog">
            <h2>博友列表</h2>
            <?php while ($_row = _fetch_array_list($_result)) { 
                $_row = _html($_row);                
                ?>
                <dl>
                    <dd class="user"><?php echo $_row['tg_username'] ?>(<?php echo $_row['tg_sex'] ?>)</dd>
                    <dt><img src="<?php echo $_row['tg_face'] ?>" alt="光头强" /></dt>
                    <dd class="message"><a href="###" name="message" title="<?php echo $_row['tg_id'];?>">发消息 </a></dd>
                    <dd class="friend">加为好友</dd>
                    <dd class="guest">写留言</dd>
                    <dd class="flower">给他送花</dd>
                </dl>
            <?php } 
            _peaging(2);
            ?>
            
            
        </div>
        
        <?php
        require ROOT_PATH . 'includes/footer.inc.php';
        ?>
    </body>
</html>
