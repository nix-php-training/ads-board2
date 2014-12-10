<?php

include CLS . 'Router.php';
include CLS . 'Requests.php';
include CLS . 'Tools.php';
include CLS . 'ChromePhp.php';
include CLS . 'ViewHelper.php';

include DB . 'Database.php';
include ADB . 'UserConnection.php';


include MDL . 'UserModel.php';

include 'Controller.php';
include 'Model.php';
include 'View.php';


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