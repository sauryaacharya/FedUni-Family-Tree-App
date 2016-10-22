<?php
class PersonController extends Controller {
    
    public function __construct(Registry $registry, Model $model) {
        parent::__construct($registry, $model);
        
    }
    
    public function index()
    {
        $auth = $this->registry->getObject("authentication");
        //$auth->checkForAuthentication();
        //echo $auth->getPasswordHash("helloworld");
        if(!$auth->isLoggedIn())
        {
            header("Location:http://localhost/familytree");
            exit;
        }
        else
        {
        $data["person_details"] = $this->_getPersonDetails();
        $data["username"] = $auth->getUsername();
        $data["title"] = "Family Tree Application | Person List";
        $this->view->render("templates/header", $data);
        $this->view->render("templates/main_page");
        $this->view->render("person/index", $data);
        $this->view->render("templates/footer");
        }
    }
    
    public function grandparents()
    {
        $auth = $this->registry->getObject("authentication");
        if(!$auth->isLoggedIn())
        {
            header("Location:http://localhost/familytree");
            exit;
        }
        else
        {
            $data["all_gp"] = $this->model->getGrandParents();
            $data["title"] = "All Grandparents of family tree application";
            $this->view->render("templates/header", $data);
            $this->view->render("templates/main_page");
            $this->view->render("person/grandparents", $data);
            $this->view->render("templates/footer");
        }
    }
    
    public function onlyoneparent()
    {
        $auth = $this->registry->getObject("authentication");
        if(!$auth->isLoggedIn())
        {
            header("Location:http://localhost/familytree");
            exit;
        }
        else
        {
            $data["sp_ch"] = $this->model->getChildWithOneParent();
            $data["title"] = "All Child with single parent";
            $this->view->render("templates/header", $data);
            $this->view->render("templates/main_page");
            $this->view->render("person/oneparent", $data);
            $this->view->render("templates/footer");
        }
    }
    
    public function view($slug = NULL)
    {
        $auth = $this->registry->getObject("authentication");
        if(!$auth->isLoggedIn())
        {
            header("Location:http://localhost/familytree");
            exit;
        }
        else
        {
        if($slug == NULL)
        {
            $controller = new ErrorController($this->registry, new ErrorModel());
            $controller->index();
            
        }
        else
        {
            $data["individual_detail"] = $this->_getPersonDetails($slug);
            $data["title"] = $data["individual_detail"][0]["child_name"];
            $this->view->render("templates/header", $data);
            $this->view->render("templates/main_page");
            $this->view->render("person/view", $data);
            $this->view->render("templates/footer");
        }
        }
    }
    
    public function create()
    {
            $auth = $this->registry->getObject("authentication");
            if(!$auth->isAdmin())
            {
                header("Location:http://localhost/familytree");
                exit;
            }
            else
            {
            $data["create_person_msg"] = "";
            $data["date_error"] = "";
            $data["name_error"] = "";
            $error = false;
            if(isset($_POST["create_person"]))
            {
                if(empty($_POST["person_name"]))
                {
                    $data["name_error"] = "Name field required.";
                    $error = true;
                }
                else
                {
                    if(!preg_match("/^[a-zA-Z ]*$/",  htmlspecialchars($_POST["person_name"])))
                    {
                        $data["name_error"] = "Only letters and white space allowed";
                        $error = true;
                    }
                    if(strlen(htmlspecialchars($_POST["person_name"])) > 100)
                    {
                        $data["name_error"] = "Name should be up to 100 characters";
                        $error = true;
                    }
                }
                
                if(empty($_POST["dob"]))
                {
                    $data["date_error"] = "Date field required.";
                    $error = true;
                }
                else
                {
                    if(strpos(htmlspecialchars($_POST["dob"]), "-") === false)
                    {
                        $data["date_error"] = "Invalid date format";
                        $error = true;
                    }
                    else
                    {
                    $date = explode("-", htmlspecialchars($_POST["dob"]));
                    if(intval($date[1]) && intval($date[2]) && intval($date[0]))
                    {
                    if(!checkdate($date[1], $date[2], $date[0]))
                    {
                        $data["date_error"] = "Invalid date format";
                        $error = true;
                    }
                    }
                    else
                    {
                        $data["date_error"] = "Invalid date format";
                        $error = true; 
                    }
                    }
                }
                if($error === false)
                {
                if($this->model->createPerson($_POST["person_name"], $_POST["dob"]))
                {
                    $data["create_person_msg"] = "<div style='font-family:Arial;color:#2d8659;font-size:13px;border:1px solid #eaeaea;padding:10px;background:#f2f2f2;'>Person successfully created.</div>";
                }
                }
                
            }
            $data["title"] = "Create Person";
            $this->view->render("templates/header", $data);
            $this->view->render("templates/main_page");
            $this->view->render("person/create", $data);
            $this->view->render("templates/footer");
            }
    }
    
    public function addrelation()
    {
           
            
            $auth = $this->registry->getObject("authentication");
            if(!$auth->isAdmin())
            {
                header("Location:http://localhost/familytree");
                exit;
            }
            else
            {
            $data["child_error"] = "";
            $data["parent_error"] = "";
            $data["insertion_msg"] = "";
            if(isset($_POST["add_rel"]))
            {
                if(empty($_POST["child"]))
                {
                    $data["child_error"] = "Child field required.";
                    //$error = true;
                }
                
                if(empty($_POST["parent"]))
                {
                    $data["parent_error"] = "Parent field required.";
                    //$error = true;
                }
                
                if(!empty($_POST["child"]) && !empty($_POST["parent"]))
                {
                    if($this->model->validateRelation($_POST["child"], $_POST["parent"]))
                    {
                        $this->model->insertRelation($_POST["child"], $_POST["parent"]);
                        $data["insertion_msg"] = "<div style='font-family:Arial;color:#2d8659;font-size:13px;border:1px solid #eaeaea;padding:10px;background:#f2f2f2;'>Relationship successfully added.</div>";
                    }
                    else
                    {
                        $data["insertion_msg"] = "<div style='font-family:Arial;color:#cc0000;font-size:13px;border:1px solid #eaeaea;padding:10px;background:#f2f2f2;'>Error! Relationship cannot be made. Please check your input.</div>";
                    }
                }
            }
            $data["person_details"] = $this->_getPersonDetails();
            $data["title"] = "Add a relationship";
            $this->view->render("templates/header", $data);
            $this->view->render("templates/main_page");
            $this->view->render("person/addrelation", $data);
            $this->view->render("templates/footer");
            }
    }
    
    public function _getPersonDetails($slug = NULL)
    {
        if($slug == NULL)
        {
            return $this->model->getPersonDetails();
        }
        else
        {
            return $this->model->getPersonDetails($slug);
        }
    }
}