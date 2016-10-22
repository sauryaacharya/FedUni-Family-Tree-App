<?php include_once "person_menu.php";?>
<div id="person_list">
        <h4 style="font-family:Arial;color:#5F5F5F;"><?php echo htmlentities($individual_detail[0]["child_name"]); ?></h4>
        <table id="list_table">
            <tr><th>Name</th><th>Date Of Birth</th><th>Parent</th><th>GrandParent</th></tr>
        <?php foreach($individual_detail as $details): ?>
            <tr>
                <td><?php echo htmlentities($details["child_name"]); ?></td>
                <td><?php echo htmlentities($details["child_dob"]); ?></td>
                <td><?php echo htmlentities($details["parent_name"]); ?></td>
                <td><?php echo htmlentities($details["gp_name"]); ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>