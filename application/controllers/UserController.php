<?php

class UserController extends Controller
{

    function LoginAction()
    {
        $this->view->generate('login.phtml', 'layout.phtml');
    }

    function RegistrationAction()
    {
        $this->view->generate('registration.phtml', 'layout.phtml');
    }
}