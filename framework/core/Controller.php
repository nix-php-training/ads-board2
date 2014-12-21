<?php

class Controller
{

    public $model;
    public $view;
    public $acl;

    function __construct()
    {
        $this->acl = new Acl();
        $this->view = new View();
        $this->model = new Model();
    }
    public function redirect($host)
    {
        header('Location:' . $host);
    }


}