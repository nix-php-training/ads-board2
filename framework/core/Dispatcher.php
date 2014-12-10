<?php


class Dispatcher
{

    private $_controller;
    private $_route;

    public function __construct()
    {
        $router = new Router();
        $this->_route = $router->getUrl();
    }

    public function getController()
    {
        $this->setup();

        return $this->_controller;
    }

    private function setup()
    {
        // controller name
        $ctrlName = ucfirst($this->_route) . 'Controller';

        // path to current controller
        $path = CTRL . Tools::normalizeUrl($ctrlName);

        ChromePhp::log($ctrlName);

        // HomeController -- for if file does not exist
        $home = 'HomeController';
        $homePath = CTRL . Tools::normalizeUrl($home);


        if (@!include $path) {
            include $homePath;
            $ctrlName = $home;
        }

        $this->_controller = new $ctrlName ($this->_route);
    }
}