<?php

class Controller
{
    private $_view;
    public $model;
    private $_params;

    /**
     * @return View
     */
    public function getView()
    {
        return $this->_view;
    }


    /**
     * @return mixed
     */
    public function getParams($key=null)
    {
        if(isset($key))
            return array_key_exists($key, $this->_params) ? $this->_params[$key]:false ;
        else
            return $this->_params;

    }




    public function __construct($params)
    {
        $this->acl = new Acl();
        $this->_params = $params;
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