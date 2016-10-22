<?php
class Authentication {
    
    private $logged_in = FALSE;
    private $user_id;
    private $username;
    private $just_processed = FALSE;
    private $admin = FALSE;
    
    
    public function __construct()
    {
   
    }
    
    public function isLoggedIn()
    {
        return $this->logged_in;
    }
    
    public function checkForAuthentication()
    {
        
        if(isset($_SESSION["authentication"]) && intval($_SESSION["authentication"]) > 0)
        {
            $user_id = Registry::getObject("db")->sanitizeInput($_SESSION["authentication"]);
            $this->sessionAuthenticate(intval($user_id));
        }
         
        else if(isset($_POST["username"]) && isset($_POST["password"]))
        {
            $username = Registry::getObject("db")->sanitizeInput($_POST["username"]);
            $password = Registry::getObject("db")->sanitizeInput($_POST["password"]);
            $this->postAuthenticate($username, $password);
        }
    }
    
    public function sessionAuthenticate($user_id)
    {
        $session_check_sql = "SELECT * FROM users WHERE user_id = {$user_id}";
        Registry::getObject("db")->executeQuery($session_check_sql);
        if(Registry::getObject("db")->getNumRows() === 1)
        {
            $user_data = Registry::getObject("db")->getRows();
            $this->logged_in = TRUE;
            $this->user_id = $user_data[0]["user_id"];
            $this->username = $user_data[0]["username"];
            $this->admin = ($user_data[0]["is_admin"] == 1) ? TRUE : FALSE;
        }
        else
        {
            $this->logged_in = FALSE;
            if($this->logged_in === FALSE)
            {
                $this->logout();
            }
        }
    }
     
    
    public function postAuthenticate($username, $password)
    {
        
        $this->just_processed = TRUE;
        $check_user_sql = "SELECT * FROM users WHERE  username= '{$username}'";
        Registry::getObject("db")->executeQuery($check_user_sql);
        if(Registry::getObject("db")->getNumRows() == 1)
        {
            $user_data = Registry::getObject("db")->getRows();
            $user_password = $user_data[0]["password"];
            $hash_given = crypt($password, $user_password);
            if($user_password === $hash_given)
            {
                $this->logged_in = TRUE;
                $this->user_id = $user_data[0]["user_id"];
                $this->username = $user_data[0]["username"];
                $this->admin = ($user_data[0]["is_admin"] == 1) ? TRUE : FALSE;
                $_SESSION["authentication"] = $user_data[0]["user_id"];
            }
        }
        else
        {
            $this->logged_in = FALSE;  
        }
    }
    
    public function getPasswordHash($password)
    {
        $bytes = substr(base64_encode(openssl_random_pseudo_bytes(32)), 0, 22);
        $salt = "$2y$12$" . $bytes;
        return crypt($password, $salt);
    }
    
    public function getUserId()
    {
        return $this->user_id;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function isAdmin()
    {
        return $this->admin;
    }
    
    function logout()
    {
        unset($_SESSION["authentication"]);
    }
    
    
}