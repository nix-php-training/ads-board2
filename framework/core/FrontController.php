<?php

include 'Dispatcher.php';

class FrontController
{

    public static function run()
    {
        $dispatcher = new Dispatcher();
        $controller = $dispatcher->getController();
        $controller->action();
    }
} 