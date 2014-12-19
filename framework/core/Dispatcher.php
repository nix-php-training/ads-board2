<?php

class Dispatcher
{
    private static $pureControllerName;
    private static $pureActionName;


    static function start()
    {

        $router = new Router();
        $router->initRoutes();
        $router->getActiveRoute();

        self::$pureControllerName = ucfirst($router->getControllerName());
        self::$pureActionName = strtolower($router->getActionName());

        $actionName = self::$pureActionName . 'Action';
        $controllerName = self::$pureControllerName . 'Controller';

        $controllerFile = $controllerName . '.php';
        $controllerPath = ROOT_PATH . '/application/controllers/' . $controllerFile;
        if (file_exists($controllerPath)) {
            include $controllerPath;
            Registry::set('controller', $controllerName);
        } else {
            self::ErrorPage404();
        }

        $controller = new $controllerName(self::$pureActionName);
        $action = $actionName;


        if (method_exists($controller, $action)) {
            Registry::set('action', $actionName);
            $controller->$action();
        } else {
            self::ErrorPage404();
        }
    }


    private static function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        header('Location:' . $host . 'error/error404');
    }
}