<?php

class Error404Controller extends Controller
{

    function IndexAction()
    {
        $this->view('', '404 Page not found');
    }

}
