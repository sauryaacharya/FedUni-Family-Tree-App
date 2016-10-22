
<div id="form_panel">
    <h3 style="font-family:Arial;color:#333333;text-shadow: 1px 1px 2px #ccc;">Member Login</h3>
<hr/>
    <form method="post" action="">
        <span style="font-family:Arial;font-size:15px;color:#404040;">Login at Family Tree Application.</span> <span style="color:#cc0000;font-family:Arial;font-size:15px;">* Required Field.</span><br/><br/>
    
        <label for="username"><span style="color:#cc0000;font-family:Arial;font-size:17px;">*</span>Username: </label><input type="text" id="username" name="username" placeholder="Username" value="<?php if(isset($_POST["username"])) {echo htmlentities($_POST["username"]);} ?>"/>
        <label for="password"><span style="color:#cc0000;font-family:Arial;font-size:17px;">*</span>Password: </label><input type="password" id="password" name="password" placeholder="Password" value="<?php if(isset($_POST["password"])) {echo htmlentities($_POST["password"]);} ?>"/>
        <input type="submit" id="login_btn" name="login_btn" value="Login"/>
        <?php echo $login_error; ?>
    </form>
</div>