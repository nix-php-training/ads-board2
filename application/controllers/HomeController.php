<?php

class HomeController extends Controller
{

    function indexAction()
    {
        $this->view($this->_name);
    }
}