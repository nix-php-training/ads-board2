<?php

class Controller
{
    protected $_view;
    public $model;
    protected $_params;

    public function __construct($params)
    {
        $this->acl = new Acl();
        $this->_params = $params;
        $this->_view = new View();
        if (Registry::has('model')) {
            $this->model = Registry::get('model');
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