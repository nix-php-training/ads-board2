<?php

class Error404Controller extends Controller
{

    function indexAction()
    {
        $this->view('', ViewHelper::generateError(404));
    }

}
