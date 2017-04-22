<?php
define('IN_TG', TRUE);
define('SCRIPT', 'face');
require dirname(__FILE__) . '/includes/commom.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>头像选择</title>
        <?php require ROOT_PATH . '/includes/tital.inc.php'; ?>
        <script type="text/javascript" src="JS/opener.js"></script>
    </head>
    <body>
        <div id="face">
            <h3>头像选择</h3>
            <dl>
                <?php foreach (range(1, 9) as $value) {?>
                <dd><img title="头像<?php echo $value;?>" alt="face/m0<?php echo $value;?>.gif" src="face/m0<?php echo $value;?>.gif"/></dd>
                <?php }?>
                
            </dl>
            <dl>
                <?php foreach (range(10, 64) as $value) {?>
                <dd><img title="头像<?php echo $value;?>" alt="face/m<?php echo $value;?>.gif" src="face/m<?php echo $value;?>.gif"/></dd>
                <?php }?>
                
            </dl>
        </div>
    </body>
</html>

