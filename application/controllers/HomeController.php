<?php

class HomeController extends BaseController
{
    function indexAction()
    {
        $this->view('content/index');
    }
}