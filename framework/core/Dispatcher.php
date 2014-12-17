<?php


class Dispatcher
{

    static function start()
    {

        $router = new Router();
        $router->initRoutes();
        $router->getActiveRoute();

        $controllerName = ucfirst($router->getControllerName()) . 'Controller';
        $actionName = $router->getActionName() . 'action';


        // подцепляем файл с классом контроллера
        $controllerFile = $controllerName . '.php';
        $controllerPath = "application/controllers/" . $controllerFile;
        if (file_exists($controllerPath)) {
            include "application/controllers/" . $controllerFile;
        } else {

        }

        // создаем контроллер
        $controller = new $controllerName;
        $action = $actionName;

        if (method_exists($controller, $action)) {
            // вызываем действие контроллера
            $controller->$action();
        } else {
            // здесь также разумнее было бы кинуть исключение
            $router->errorPage();
        }
    }
}






class DispatcherTest
{
    static function start()
    {
        $controllerName = 'home';
        $actionName = 'index';
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1])) {
            $controllerName = $routes[1];
        }

        if (!empty($routes[2])) {
            $actionName = $routes[2];
        }

        $modelName = ucfirst(strtolower($controllerName)) . 'Model';
        $controllerName = ucfirst(strtolower($controllerName)) . 'Controller';
        $actionName = ucfirst(strtolower($actionName)) . 'Action';

        $modelFile = $modelName . '.php';
        $modelPath = ROOT_PATH . "/application/models/" . $modelFile;
        if (file_exists($modelPath)) {
            include $modelPath;
            Registry::set('model', $modelName);
        }


        $controllerFile = $controllerName . '.php';
        $controllerPath = ROOT_PATH . "/application/controllers/" . $controllerFile;
        if (file_exists($controllerPath)) {
            include $controllerPath;
            Registry::set('controller', $controllerName);
        } else {
            Dispatcher::ErrorPage404();
        }

        $controller = new $controllerName;
        $action = $actionName;

        if (method_exists($controller, $action)) {
            Registry::set('action', $actionName);
            $controller->$action();
        } else {
            Dispatcher::ErrorPage404();
        }

    }

    function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . 'error404');
    }

}
