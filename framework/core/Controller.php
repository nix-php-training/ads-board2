<?php

class Controller
{
    protected $_view;
    protected $_model;
    protected $_name;

    public function __construct($name)
    {
        $this->acl = new Acl();
        $this->_name = $name;
        $this->_view = new View();
        if (Registry::has('model')) {
            $this->_model = Registry::get('model');
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