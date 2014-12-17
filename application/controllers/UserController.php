<?php

class UserController extends Controller
{

    function loginAction()
    {
        $this->view($this->_name);
    }

    function registrationAction()
    {
        $this->view($this->_name);
    }
}