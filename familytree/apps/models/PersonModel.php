<?php
class PersonModel extends Model {
    
    public function __construct() {
        parent::__construct();     
    }
    
    public function getPersonDetails($slug = NULL)
    {
        if($slug == NULL)
        {
            $get_detail_query = "SELECT * FROM person";
            $this->dbObject()->executeQuery($get_detail_query);
            return $this->dbObject()->getRows();
        }
        else
        {
            $all_detail = array();
            $get_parent_query = "SELECT p2.name AS 'Parent', p2.date_of_birth AS 'dob_parent' FROM person AS p1, person AS p2, parent AS p "
                                . "WHERE p1.id = p.child_id AND p2.id = p.parent_id AND p1.id = {$slug}";
            $get_person_query = "SELECT name, date_of_birth FROM person WHERE id = {$slug}";
            //$get_grandparent_query = "SELECT name AS 'Grandparent', date_of_birth FROM parent, person WHERE child_id = (SELECT parent_id FROM parent WHERE child_id = {$slug}) AND person.id = parent.parent_id";
            $sql = "SELECT parent_id FROM parent WHERE child_id = {$slug}";
            $this->dbObject()->executeQuery($sql);
            $row = $this->dbObject()->getRows();
            $row_count = $this->dbObject()->getNumRows();
            $g_parent_arr = array();
            for($i = 0; $i < $row_count; $i++)
            {
                
                $get_gparent = "SELECT name AS 'Grandparent', date_of_birth FROM parent, person WHERE child_id = {$row[$i]["parent_id"]} AND person.id = parent.parent_id";
                $this->dbObject()->executeQuery($get_gparent);
                if($this->dbObject()->getNumRows())
                {
                $g_parent_arr = $this->dbObject()->getRows();
                }
            }
           
            $gp_count = count($g_parent_arr);
            
            $this->dbObject()->executeQuery($get_person_query);
            $person = $this->dbObject()->getRows();
            $person_count = $this->dbObject()->getNumRows();
            
            $this->dbObject()->executeQuery($get_parent_query);
            $parent = $this->dbObject()->getRows();
            $parent_count = $this->dbObject()->getNumRows();
            
            /*
            $this->dbObject()->executeQuery($get_grandparent_query);
            $grand_parent = $this->dbObject()->getRows();
            $gp_count = $this->dbObject()->getNumRows();
            */
            if($parent_count === 0)
            {
                $all_detail [] = array("child_name"=>$person[0]["name"], "child_dob"=>$person[0]["date_of_birth"],
                            "parent_name"=>"None", "gp_name"=>"None"
                           );
            }
            
            if($gp_count === 0 && $parent_count === 1)
            {
               $all_detail [] = array("child_name"=>$person[0]["name"], "child_dob"=>$person[0]["date_of_birth"],
                            "parent_name"=>$parent[0]["Parent"], "gp_name"=>"None"
                           ); 
            }
            
            if($person_count === 1 && $parent_count === 1 && $gp_count === 1)
            {
               $all_detail [] = array("child_name"=>$person[0]["name"], "child_dob"=>$person[0]["date_of_birth"],
                            "parent_name"=>$parent[0]["Parent"], "gp_name"=>$g_parent_arr[0]["Grandparent"]
                           );
            }
            
            if($parent_count === 1 && $gp_count === 2)
            {
                $all_detail [] = array("child_name"=>$person[0]["name"], "child_dob"=>$person[0]["date_of_birth"],
                            "parent_name"=>$parent[0]["Parent"], "gp_name"=>$g_parent_arr[0]["Grandparent"].", ".$g_parent_arr[1]["Grandparent"]
                           );
            }
            
            if($parent_count === 2 && $gp_count === 2)
            {
                $all_detail [] = array("child_name"=>$person[0]["name"], "child_dob"=>$person[0]["date_of_birth"],
                            "parent_name"=>$parent[0]["Parent"].", ".$parent[1]["Parent"], "gp_name"=>$g_parent_arr[0]["Grandparent"].", ".$g_parent_arr[1]["Grandparent"]
                           );
            }
            
            if($parent_count === 2 && $gp_count === 0)
            {
                $all_detail [] = array("child_name"=>$person[0]["name"], "child_dob"=>$person[0]["date_of_birth"],
                            "parent_name"=>$parent[0]["Parent"].", ".$parent[1]["Parent"], "gp_name"=>"None"
                           );
            }
            
            if($parent_count === 2 && $gp_count === 1)
            {
               $all_detail [] = array("child_name"=>$person[0]["name"], "child_dob"=>$person[0]["date_of_birth"],
                            "parent_name"=>$parent[0]["Parent"].", ".$parent[1]["Parent"], "gp_name"=>$g_parent_arr[0]["Grandparent"]
                           ); 
            }
            return $all_detail;
        }
        
    }
    
    public function createPerson($name, $dob)
    {
        $person_name = $this->dbObject()->sanitizeInput($name);
        $person_dob = $this->dbObject()->sanitizeInput($dob);
        $create_person_query = "INSERT INTO person (name, date_of_birth) VALUES ('{$person_name}', '{$person_dob}')";
        if($this->dbObject()->executeQuery($create_person_query))
        {
            return true;
        }
    }
    
    public function validateRelation($child, $parent)
    {
        $valid = true;
        $child_id = intval($this->dbObject()->sanitizeInput($child));
        $parent_id = intval($this->dbObject()->sanitizeInput($parent));
        if($child_id == $parent_id)
        {
            return false;
        }
        
        /*
         * checks the parent child relationship exists or not and 
         * avoid the reverse relationship between existed relationship
         */
        $parent_child = "SELECT child_id FROM parent WHERE parent_id = $child_id";
        $this->dbObject()->executeQuery($parent_child);
        $parent_child_row = $this->dbObject()->getRows();
        $parent_child_count = $this->dbObject()->getNumRows();
        if($parent_child_count > 0)
        {
            foreach($parent_child_row as $row)
            {
                if(in_array($parent_id, $row))
                {
                   return false;
                }
            }
        }
        
        /*
         * check the parent-child relationship exists or not
         * avoid inserting the relationship if already exists.
         */
        $child_parent_exists = "SELECT * FROM parent WHERE parent_id = $parent_id AND child_id = $child_id";
        $this->dbObject()->executeQuery($child_parent_exists);
        if($this->dbObject()->getNumRows() > 0)
        {
            return false;
        }
        
        /*
         * avoids to make relationship between grandparent and grandchild in a reverse way.
         */
        $gp_gchild = "SELECT parent_id FROM parent WHERE child_id = (SELECT parent_id FROM parent WHERE child_id = {$child_id})";
        $this->dbObject()->executeQuery($gp_gchild);
        $gp_gchild_row = $this->dbObject()->getRows();
        $gp_gchild_count = $this->dbObject()->getNumRows();
        if($gp_gchild_count > 0)
        {
            foreach($gp_gchild_row as $gp)
            {
                if($parent_id == $gp["parent_id"])
                {
                    return false;
                }
            }
        }
        
        
        $gc_gp = "SELECT child_id FROM parent WHERE parent_id = (SELECT child_id FROM parent WHERE parent_id = {$child_id})";
        $this->dbObject()->executeQuery($gc_gp);
        $gc_gp_row = $this->dbObject()->getRows();
        $gc_gp_count = $this->dbObject()->getNumRows();
        if($gc_gp_count > 0)
        {
            foreach($gc_gp_row as $gc)
            {
                if($parent_id == $gc["child_id"])
                {
                    return false;
                }
            }
        }
        
        
        
        
        /*
         * allow only to insert up to 2 parents for a child
         */
        $child_exists = "SELECT * FROM parent WHERE child_id = $child_id";
        $this->dbObject()->executeQuery($child_exists);
        if($this->dbObject()->getNumRows() == 2)
        {
            return false;
        }
        return $valid;
    }
    
    public function insertRelation($child, $parent)
    {
        $child_id = $this->dbObject()->sanitizeInput($child);
        $parent_id = $this->dbObject()->sanitizeInput($parent);
        $rel_insert_query = "INSERT INTO parent (parent_id, child_id) VALUES({$parent_id}, {$child_id})";
        $this->dbObject()->executeQuery($rel_insert_query);
    }
    
    public function getGrandParents()
    {
        $get_gp_query = "SELECT p.id, p.name, p.date_of_birth FROM person AS p, parent AS p1, parent AS p2 WHERE p1.parent_id = p2.child_id AND p2.parent_id = p.id ORDER BY p.date_of_birth";
        $this->dbObject()->executeQuery($get_gp_query);
        return $this->dbObject()->getRows();
    }
    
    public function getChildWithOneParent()
    {
        $get_child_query = "SELECT p.id, p.name, p.date_of_birth, pa.child_id FROM person AS p, parent AS pa  WHERE p.id = pa.child_id GROUP BY pa.child_id HAVING COUNT(pa.child_id) = 1 ORDER BY date_of_birth DESC";
        $this->dbObject()->executeQuery($get_child_query);
        return $this->dbObject()->getRows();
    }
    
}