<?php
class View {

    public function __construct() {
        
    }

    public function render($name, $data = FALSE) {
        if ($data != FALSE) {
            if (!is_array($data)) {
                $this->arrayDataTypeException();
                return false;
            }
             extract($data);
        }
        require(BASE_PATH .DS. "apps" .DS. "frontend" .DS. "views" .DS. $name . ".php");
    }

    public function arrayDataTypeException() {
        try {
            throw new Exception("<b>Notice: </b> Error! Data type must be an array");
        } catch (Exception $e) {
            echo $e->getMessage() . " in <b>" . $e->getFile() . "</b> on line " . $e->getLine();
        }
    }

}