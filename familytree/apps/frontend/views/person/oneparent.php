<?php include_once "person_menu.php"; ?>
<div id="person_list">
        <h4 style="font-family:Arial;color:#5F5F5F;">List Of Child With Single Parent</h4>
        <table id="list_table">
            <tr><th>Name</th><th>Date Of Birth</th></tr>
        <?php foreach($sp_ch as $ch): ?>
            <tr>
                <td><a href="http://localhost/familytree/person/view/<?php echo htmlentities($ch['id']); ?>"><?php echo htmlentities($ch["name"]); ?></a></td>
                <td><?php echo htmlentities($ch["date_of_birth"]); ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>