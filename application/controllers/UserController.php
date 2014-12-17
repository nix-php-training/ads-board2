<?php

class UserController extends Controller
{

    function LoginAction()
    {
        $this->view($this->_name);
    }

    function RegistrationAction()
    {
        $this->view($this->_name);
    }
}