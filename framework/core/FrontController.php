<?php

class FrontController
{

    public function __construct()
    {
        Config::init(APP_ENV);
        Dispatcher::start();
    }

}

