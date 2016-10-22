<?php include_once "person_menu.php"; ?>
<div id="create_person_form">
    <br/>
    <h4 style="font-family:Arial;color:#5F5F5F;">Create Person</h4><hr/>
    <form method="post" action="">
        <span style="font-family:Arial;font-size:15px;color:#404040;">Please fill up the</span> <span style="color:#cc0000;font-family:Arial;font-size:15px;">* Required Field.</span><br/><br/>
    
        <label for="person_name"><span style="color:#cc0000;font-family:Arial;font-size:17px;">*</span>Name: </label><?php echo "<span style='font-family:Arial;font-size:13px;color:#ff0000;'>".htmlentities($name_error)."</span>"; ?><input type="text" id="person_name" name="person_name" placeholder="Name" value="<?php if(isset($_POST["person_name"])) {echo htmlentities($_POST["person_name"]);} ?>"/>
        <label for="dob"><span style="color:#cc0000;font-family:Arial;font-size:17px;">*</span>Date Of Birth: </label><?php echo "<span style='font-family:Arial;font-size:13px;color:#ff0000;'>".htmlentities($date_error)."</span>"; ?><input type="text" id="dob" name="dob" placeholder="YYYY-MM-DD" value="<?php if(isset($_POST["dob"])) {echo htmlentities($_POST["dob"]);} ?>"/>
        <input type="submit" id="create_person" name="create_person" value="Create Person"/>
    </form>
    <?php echo htmlentities($create_person_msg); ?>
</div>