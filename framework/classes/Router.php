<?php

class Router
{
    private $_url;
    private $_route;

    public function __construct()
    {
        $request = Requests::request();
        $this->_url = isset($request['action']) ? $request['action'] : 'Home';
    }

    public function getUrl()
    {

        // getting page name
        $this->_route = isset($this->_url) ? Tools::cutExtension($this->_url) : 'Home';

        return $this->_route;
    }
} 