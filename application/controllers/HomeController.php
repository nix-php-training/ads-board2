<?php

class HomeController extends BaseController
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

    function postDetailAction()
    {
        $this->view('content/postDetail');
    }
}