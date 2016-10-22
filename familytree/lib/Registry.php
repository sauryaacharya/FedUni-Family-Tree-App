<?php
class Registry {
    
    private static $instance;
    
    private static $objects = array();
    
    private function __construct() {
        
    }
    
    public function storeObject($key, $object)
    {
       self::$objects[$key] = new $object(self::$instance); 
    }
    
    public static function getObject($key)
    {
        
        return self::$objects[$key];
        
    }
    
    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            $object = __CLASS__;
            self::$instance = new $object();
        }
        return self::$instance;
    }
    
     public function __clone() 
    { 
        trigger_error('Clone is not allowed.', E_USER_ERROR); 
    } 
}

