<?php include_once "person_menu.php"; ?>
<div id="person_list">
        <h4 style="font-family:Arial;color:#5F5F5F;">All GrandParents List</h4>
        <table id="list_table">
            <tr><th>Name</th><th>Date Of Birth</th></tr>
        <?php foreach($all_gp as $gp): ?>
            <tr>
                <td><a href="http://localhost/familytree/person/view/<?php echo htmlentities($gp['id']); ?>"><?php echo htmlentities($gp["name"]); ?></a></td>
                <td><?php echo htmlentities($gp["date_of_birth"]); ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>