<?php
class Controller {
    
    protected $registry;
    protected $model;
    protected $view;
    
    public function __construct(Registry $registry, Model $model) {
        $this->view = new View();
        $this->registry = $registry;
        $this->model = $model;
        
    } 
}