<?php

class HomeController extends Controller
{

    function IndexAction()
    {
        $this->view($this->_name);
    }
}