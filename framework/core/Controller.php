<?php

class Controller
{
    protected $_view;
    protected $_model;
    protected $_name;

    public function __construct($name)
    {
        $this->_name = $name;
        $this->_view = new View();
    }

    public function view($tpl, $data = [], $layout = '/application/views/layout/layout.phtml')
    {
        $this->_view->assign($tpl, $data, $layout);
        $this->_view->render();
    }
}