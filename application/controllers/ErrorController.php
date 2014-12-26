<?php

/**
 * Class ErrorController
 */
class ErrorController extends Controller
{

    /**
     * Default error
     */
    public function indexAction()
    {
        $this->view('error/error404');
    }

    /**
     * 404 Error
     */
    public function error404Action()
    {
        $this->view('error/error404');
    }

}
