<?php

class HomeController extends Controller
{

    function IndexAction()
    {
        $this->view->generate('home.phtml', 'layout.phtml');
    }
}