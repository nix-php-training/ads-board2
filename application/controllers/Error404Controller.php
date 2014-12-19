<?php

class Error404Controller extends Controller
{

    function IndexAction()
    {
        $this->view->generateError('404.phtml', 'layout.phtml');
    }

}
