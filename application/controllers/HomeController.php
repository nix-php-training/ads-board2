<?php

class HomeController extends Controller
{

    function indexAction()
    {
        $this->view('content/index');
    }
}