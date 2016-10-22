<?php
class ErrorController extends Controller {
    
    public function __construct(Registry $registry, Model $model) {
        parent::__construct($registry, $model);
        
    }
    
    public function index()
    {
        $data["title"] = "Error! Page not found";
        $this->view->render("templates/header", $data);
        $this->view->render("templates/main_page");
        $this->view->render("error/index", $data);
        $this->view->render("templates/footer");
    }
}