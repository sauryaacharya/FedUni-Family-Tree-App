<?php
class LogoutController extends Controller {
    
    public function __construct(Registry $registry, Model $model) {
        parent::__construct($registry, $model);
        
    }
    
    public function index()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $auth = $this->registry->getObject("authentication");
            $auth->logout();
            header("Location:http://localhost/familytree");
            
        }
        else
        {
            header("Location:http://localhost/familytree/person");
        }
    }
}