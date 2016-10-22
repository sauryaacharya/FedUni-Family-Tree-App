<div id="main_page">
    <div id="main_page_content">
        <?php
$auth = Registry::getObject("authentication");
if($auth->isLoggedIn()):
?>
<h2 style="font-family:Arial;color:#333333;text-shadow: 1px 1px 2px #ccc;">Welcome <?php echo $auth->getUsername(); ?></h2>
<hr/>
<?php endif; ?>