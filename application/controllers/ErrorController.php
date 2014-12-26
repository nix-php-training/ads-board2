<?php

class ErrorController extends Controller
{

    public function indexAction()
    {
        $this->view('', ViewHelper::generateError(404));
    }

    public function error404Action()
    {
        $this->view('', ViewHelper::generateError(404));
    }

}
