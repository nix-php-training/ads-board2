<?php

class Dispatcher
{
    private static $pureControllerName;
    private static $pureActionName;

    public static function start()
    {
        $controllerName = 'home';
        $actionName = 'index';
        self::$pureActionName = $actionName;
        self::$pureControllerName = $controllerName;

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1])) {
            $controllerName = $routes[1];
            self::$pureControllerName = $controllerName;
        }

        if (!empty($routes[2])) {
            $actionName = $routes[2];
            self::$pureActionName = $actionName;
        }

        $modelName = ucfirst(strtolower($controllerName)) . 'Model';
        $controllerName = ucfirst(strtolower($controllerName)) . 'Controller';
        $actionName = strtolower($actionName) . 'Action';

        ChromePhp::log($actionName);

        $modelFile = $modelName . '.php';
        $modelPath = ROOT_PATH . '/application/models/' . $modelFile;
        if (file_exists($modelPath)) {
            include $modelPath;
            Registry::set('model', $modelName);
        }

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
