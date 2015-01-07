<?php

class BaseController extends Controller
{

    private $_auth;

    function __construct($name, $model)
    {
        parent::__construct($name, $model);
        $this->_auth = new Auth(new User());
    }
}