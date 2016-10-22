<?php

class BootStrap {

    private $registry;
    private static $url = [];
    private static $method;
    private static $argument = [];

    public function __construct() {

        $this->storeCoreObject();
        $this->checkUserLoggedInSession();
        $this->parseUrl();
        $this->getArgument();
        $this->initController();    
    }

    public function storeCoreObject() {
        $this->registry = Registry::getInstance();
        $this->registry->storeObject("loader", "Loader");
        $this->registry->storeObject("db", "MysqlDatabase");
        $this->registry->storeObject("authentication", "Authentication");
    }

    public function parseUrl() {
        self::$url = isset($_GET["url"]) ? $_GET["url"] : "index";
        self::$url = rtrim(self::$url, "/");
        self::$url = explode("/", self::$url);
    }

    public function getUrl() {
        return self::$url;
    }
    
    public function checkUserLoggedInSession()
    {
        $auth = $this->registry->getObject("authentication");
        $auth->checkForAuthentication();
    }

    public static function getMethod() {
        //self::$method = "";
        if (isset(self::$url[1])) {
            return self::$method = self::$url[1];
        }
        //return self::$method;
    }

    public static function getArgument() {
        //self::$argument = [];
        if (isset(self::$url[2])) {
            $temp = self::$url;
            unset($temp[0], $temp[1]);
            self::$argument = array_merge($temp);
        }
        //return self::$argument;
    }

    public function getController() {
        return ucfirst(self::$url[0]) . "Controller";
    }

    public function getModel() {
        return ucfirst(self::$url[0]) . "Model";
    }

    public function getView() {
        return ucfirst(self::$url[0]) . "View";
    }

    public function initController() {
        $ctrl_class = $this->getController();
        $model_class = $this->getModel();
        //$view_class = $this->getView();
        $this->loadController($ctrl_class, $model_class);
    }

    public function loadController($ctrl_class, $model_class) {
        if (!file_exists(BASE_PATH . DS . "apps" . DS . "controllers" . DS . $ctrl_class . ".php")) {
            $this->error404();
        } else {
            $controller = new $ctrl_class($this->registry, new $model_class());
            if(isset(self::$url[1]) || isset(self::$url[2]))
            {
                if(strpos(self::$url[1], "_") !== false)
                {
                    $this->error404();
                }
            }
            if (isset(self::$url[2])) {
                $this->runActionWithArg($controller);
            } else if (isset(self::$url[1])) {
                $this->runAction($controller);
            } else {
                $this->runDefaultAction($controller);
            }
        }
    }

    public static function getCurrentUrl() {
        $arr_length = count(self::$url);
        $last_index = $arr_length - 1;
        $cur_url = self::$url[$last_index];
        return $cur_url;
    }

    public function error404() {
        $controller = new ErrorController($this->registry, new ErrorModel());
        $controller->index();
        return false;
    }

    public function runDefaultAction(Controller $controller) {
        if (method_exists($controller, "index")) {
            $controller->index();
        }
    }

    public function runAction(Controller $controller) {
        //if (isset(self::$url[1])) {
        if (method_exists($controller, self::$url[1])) {
            $controller->{self::$url[1]}();
        } else {
            $this->error404();
        }
    }

    public function runActionWithArg(Controller $controller) {
        if (method_exists($controller, self::$url[1])) {
            call_user_func_array(array($controller, self::$url[1]), self::$argument);
        } else {
            $this->error404();
        }
    }

}
