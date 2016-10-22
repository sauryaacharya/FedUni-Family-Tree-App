<input type="button" value="All Person" id="all_person" name="all_person" onclick="location.href='http://localhost/familytree/person'"/>
<?php
$auth = Registry::getObject("authentication");
if($auth->isLoggedIn() && $auth->isAdmin()):
?>
    <input type="button" id="create_person_btn" name="create_person_btn" value="Create Person" onclick="location.href='http://localhost/familytree/person/create'"/>
    <input type="button" id="add_reln_btn" name="add_reln_btn" value="Add a Relationship" onclick="location.href='http://localhost/familytree/person/addrelation'"/>
<?php
endif;
?>
<input type="button" value="View All Grandparents" id="view_gp_btn" name="view_gp_btn" onclick="location.href='http://localhost/familytree/person/grandparents'"/>
<input type="button" value="Single Parent Child" id="view_sp_ch" name="view_sp_ch" onclick="location.href='http://localhost/familytree/person/onlyoneparent'"/>