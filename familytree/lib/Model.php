<?php
require_once("config/config.php");
class Model {
    private $db;
    
    public function __construct()
    {
        $this->db = new MysqlDatabase();
    }
    
    public function dbObject()
    {
        return $this->db;
    }
    
}