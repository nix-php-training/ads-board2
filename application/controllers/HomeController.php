<?php

class HomeController extends Controller
{
    function indexAction()
    {
        $this->view('content/index');
    }

    function postListAction()
    {
        $this->view('content/postList');
    }

    function pricingAction()
    {
        $this->view('content/pricing');
    }
}