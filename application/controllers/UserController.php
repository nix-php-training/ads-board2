<?php

class UserController extends Controller
{

    function LoginAction()
    {
        if (Auth::authentication()){
            $this->view->generate('home.phtml', 'layout.phtml');
        }else {
            $this->view->generate('login.phtml', 'layout.phtml');
        }
    }

    function RegistrationAction()
    {
        $this->view->generate('registration.phtml', 'layout.phtml');
    }
}