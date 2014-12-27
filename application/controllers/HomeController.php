<?php

class HomeController extends Controller
{
    function indexAction()
    {
        $this->redirect('/');
    }
}