<?php

class Dispatcher
{
    private static $pureControllerName;
    private static $pureActionName;

<<<<<<< HEAD
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

        $modelFile = $modelName . '.php';
        $modelPath = ROOT_PATH . '/application/models/' . $modelFile;
        if (file_exists($modelPath)) {
            include $modelPath;
            Registry::set('model', $modelName);
        }
=======
    static function start()
    {

        $router = new Router();
        $router->initRoutes();
        $router->getActiveRoute();

        self::$pureControllerName = ucfirst($router->getControllerName());
        self::$pureActionName  = strtolower($router->getActionName());


        $actionName = self::$pureActionName . 'Action';
        $controllerName = self::$pureControllerName . 'Controller';
>>>>>>> 31f2180af2c18b610cb490d6d41daf1639409b5c

        $controllerFile = $controllerName . '.php';
<<<<<<< HEAD
        $controllerPath = ROOT_PATH . '/application/controllers/' . $controllerFile;
=======
        $controllerPath = "application/controllers/" . $controllerFile;
>>>>>>> 31f2180af2c18b610cb490d6d41daf1639409b5c
        if (file_exists($controllerPath)) {
            include $controllerPath;
            Registry::set('controller', $controllerName);
        } else {
            self::ErrorPage404();
        }

<<<<<<< HEAD
=======

>>>>>>> 31f2180af2c18b610cb490d6d41daf1639409b5c
        $controller = new $controllerName(self::$pureActionName);
        $action = $actionName;



        if (method_exists($controller, $action)) {
            Registry::set('action', $actionName);

            $controller->$action();
        } else {
<<<<<<< HEAD
            self::ErrorPage404();
        }
=======
>>>>>>> 31f2180af2c18b610cb490d6d41daf1639409b5c

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



