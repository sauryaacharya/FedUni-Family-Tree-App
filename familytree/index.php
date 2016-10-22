<?php
session_start();
$root_url = $_SERVER["HTTP_HOST"] . "/familytree/";
define("ROOT_URL", $root_url);
define("DS", DIRECTORY_SEPARATOR);
define("BASE_PATH", __DIR__);
require_once(BASE_PATH . DS . "lib" . DS . "Loader.php");
$load = new Loader();
$load->loadClass();
$ecommapp = new BootStrap();