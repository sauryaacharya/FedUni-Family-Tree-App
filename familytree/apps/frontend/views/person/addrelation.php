<?php include_once "person_menu.php"; ?>
<div id="create_person_form">
    <br/>
    <h4 style="font-family:Arial;color:#5F5F5F;">Add a Relationship</h4><hr/>
    <form method="post" action="">
        <span style="font-family:Arial;font-size:15px;color:#404040;">Please fill up the</span> <span style="color:#cc0000;font-family:Arial;font-size:15px;">* Required Field.</span><br/><br/>
    
        <label for="child"><span style="color:#cc0000;font-family:Arial;font-size:17px;">*</span>Child: </label>
            <?php echo "<span style='font-family:Arial;font-size:13px;color:#ff0000;'>".htmlentities($child_error)."</span>"; ?>
        <select id="child" name="child">
            <option value="">Select Child</option>
            <?php
            foreach($person_details as $details):
            ?>
            <option value="<?php echo htmlentities($details["id"]); ?>" <?php if(isset($_POST["child"]) && $_POST["child"] == $details["id"]) {echo "selected";} ?>><?php echo htmlentities($details["name"]); ?></option>
            <?php endforeach; ?>
        </select>
        <label for="parent"><span style="color:#cc0000;font-family:Arial;font-size:17px;">*</span>Parent: </label>
            <?php echo "<span style='font-family:Arial;font-size:13px;color:#ff0000;'>".htmlentities($parent_error)."</span>"; ?>
        <select id="parent" name="parent">
            <option value="">Select Parent</option>
            <?php
            foreach($person_details as $details):
            ?>
            <option value="<?php echo htmlentities($details["id"]); ?>" <?php if(isset($_POST["parent"]) && $_POST["parent"] == $details["id"]) {echo "selected";} ?>><?php echo htmlentities($details["name"]); ?></option>
            <?php endforeach; ?>
        </select>
        
        <input type="submit" id="add_rel" name="add_rel" value="Add Relationship"/>
    </form>
    <?php echo $insertion_msg; ?>
</div>