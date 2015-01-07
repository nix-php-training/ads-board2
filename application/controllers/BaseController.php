<?php

class BaseController extends Controller
{

    private $_auth;

    function __construct($params, $model)
    {
        parent::__construct($params, $model);
        $this->_auth = new Auth(new User());
    }
}