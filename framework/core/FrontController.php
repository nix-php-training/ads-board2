<?php

class FrontController
{

    public function __construct()
    {
       try {
            Config::init(APP_ENV);
            Dispatcher::start();
        } catch (PageNotFoundException $e) {
            $e->redirect();
        } catch (AccessDenyException $e) {
            $e->redirect();
        } catch (ConfigLoadException $e) {
            echo $e->getMessage();
            exit();
        }
    }

}

