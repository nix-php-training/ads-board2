<?php

class Controller
{
    protected $_view;
    protected $_model;
    protected $_name;

    public function __construct($name, $model)
    {
        $this->acl = new Acl();
        $this->_view = new View();
        $this->_name = $name;
        if (class_exists($model)) {
            $this->_model = new $model;
        }
    }

    public function view($tpl, $data = [], $layout = 'layout.phtml')
    {
        $layout = '/application/views/layout/' . strtolower(Tools::normalizeUrl($layout, 'phtml'));
        $this->_view->assign($tpl, $data, $layout);
        $this->_view->render();
    }

    public function redirect($host)
    {
        header('Location:' . $host);
    }
}