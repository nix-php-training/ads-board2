<?php

class FrontController
{

    public function __construct()
    {
        try {
            Config::init(APP_ENV);

        } catch (ConfigLoadException $e) {
            echo $e->getMessage();
            exit();
        }
        Dispatcher::start();

    }

}

