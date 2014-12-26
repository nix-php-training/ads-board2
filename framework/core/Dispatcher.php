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
        $controllerPath = "application/controllers/" . $controllerFile;
        if (file_exists($controllerPath)) {
            include $controllerPath;
        } else {
            self::ErrorPage404();
        }

        $modelFile = self::$pureControllerName . '.php';
        $modelPath = "application/models/" . $modelFile;
        if (file_exists($modelPath)) {
            include $modelPath;
            $model = new self::$pureControllerName();
            Registry::set('model', $model);
        }

        $controller = new $controllerName(self::$pureActionName);
        $action = $actionName;

        if (method_exists($controller, $action)) {
            if ($controller->acl->isAllow(strtolower(self::$pureControllerName), self::$pureActionName)) {
                $controller->$action();
            } else {
                echo 'Access Deny';
            }
        } else {
            self::ErrorPage404();
        }
    }

    private static function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . 'error404');
    }
}
