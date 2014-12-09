<?php

class Router
{
    private $_url;
    private $_route;

    public function __construct()
    {
        $request = Requests::request();
        $this->_url = $request['action'];
    }

    public function getUrl()
    {

        // getting page name
        $this->_route = isset($this->_url) ? Tools::cutExtension($this->_url, true) : 'Home';

        return $this->_route;
    }
} 