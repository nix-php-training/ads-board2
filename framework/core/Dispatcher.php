<?php

class Dispatcher
{
    private static $pureControllerName;
    private static $pureActionName;
    private static $parameters;

    static function start()
    {
        /**
         * @var $controller Controller
         */

        try {
            $router = new Router();
            $router->getActiveRoute();
        } catch (InitRoutesException $e) {
            $data['message'] = $e->getMessage();
            $data['adminEmail'] = Config::get('site')['adminEmail'];
            $controller->view('error/error', $data);
        }


        self::$pureControllerName = ucfirst($router->getControllerName());
        self::$pureActionName = strtolower($router->getActionName());
        self::$parameters = $router->getParams();

        $actionName = self::$pureActionName . 'Action';
        $controllerName = self::$pureControllerName . 'Controller';

        if (class_exists($controllerName)) {
            $controller = new $controllerName(self::$parameters, self::$pureControllerName);
            $action = $actionName;

            if (method_exists($controller, $action)) {

                // check if is allow action for current user
                if ($controller->acl->isAllow(strtolower(self::$pureControllerName), self::$pureActionName)) {

                    try {

                        // run action
                        $controller->$action();
                        /**
                         * Expects
                         * @var $e DatabaseConnectException
                         */
                    } catch (DatabaseConnectException $e) {
                        $data['message'] = $e->getMessage();
                        $data['adminEmail'] = Config::get('site')['adminEmail'];
                        $controller->view('error/error', $data);
                    }
                } else {
                    throw new AccessDenyException();
                }
            } else {
                throw new PageNotFoundException();
            }
        } else {
            throw new PageNotFoundException();
        }
    }
}
