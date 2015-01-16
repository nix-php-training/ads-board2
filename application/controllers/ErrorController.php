<?php

/**
 * Class ErrorController
 */
class ErrorController extends BaseController
{

    /**
     * Default error
     */
    public function indexAction()
    {
        $this->view('error/error404', '', 'error');
    }

    /**
     * 404 Error
     */
    public function error404Action()
    {
        $this->view('error/error404', array('title' => 'Page not found!'), 'error');
    }

    /**
     * 403 Error
     */
    public function error403Action()
    {
        $this->view('error/error403', array('title' => 'Access denied!'), 'error');
    }

}
