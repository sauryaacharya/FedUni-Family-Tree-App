<?php
$auth = Registry::getObject("authentication");
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>
            <?php echo htmlentities($title); ?>
        </title>
        <link rel="stylesheet" type="text/css" href="http://<?php echo ROOT_URL; ?>apps/frontend/public/css/style.css"/>
        <link href="http://<?php echo ROOT_URL; ?>apps/frontend/public/engine1/style.css" rel="stylesheet" type="text/css" />
         </head>
    <body>
        <div id="body_wrapper">
        <div id="header">
            <div id="header_content">
                <?php if($auth->isLoggedIn()):?>
                <div style="float:right;">
                    <form method="post" action="http://localhost/familytree/logout">
                    <input type="submit" value="Logout" id="logout_btn" name="logout_btn"/>
                </form>
                </div>
                <?php endif; ?>
                <div>
                    <a href="http://localhost/familytree" style="font-family:Arial;color:#fff;text-decoration:none;"><h2 style="font-family:Arial;color:#fff;">Family Tree</h2></a>
                </div>
                <div style="clear:both;"></div>
            </div>
            <!--end header_content-->
        </div>
            <!--end header-->
            
            