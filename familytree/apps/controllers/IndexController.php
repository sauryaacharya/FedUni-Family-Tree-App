<?php
class IndexController extends Controller {
    
    public function __construct(Registry $registry, Model $model) {
        parent::__construct($registry, $model);
        
    }
    
    public function index()
    {
        $auth = $this->registry->getObject("authentication");
        if($auth->isLoggedIn())
        {
            header("Location:http://localhost/familytree/person");
            exit;
        }
        $data["login_error"] = "";
        if(isset($_POST["login_btn"]))
        {
            if($auth->isLoggedIn())
            {
                header("Location:http://localhost/familytree/person");
            }
            else
            {
                $data["login_error"] = "<div style='font-family:Arial;color:#cc0000;font-size:13px;border:1px solid #eaeaea;padding:10px;background:#f2f2f2;'>Error! Invalid username & password.</div>";
            }
        }
        $data["title"] = "Welcome To The Family Tree Application | Login";
        $this->view->render("templates/header", $data);
        $this->view->render("templates/main_page");
        $this->view->render("index/index", $data);
        $this->view->render("templates/footer");
    }
}