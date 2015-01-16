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

                        // run action
                        $controller->$action();

                    } else {
                        throw new AccessDenyException();
                    }
                } else {
                    throw new PageNotFoundException();
                }
            } else {
                throw new PageNotFoundException();
            }
        } catch (InitRoutesException $e) {
            $data['message'] = $e->getMessage();
            $data['adminEmail'] = Config::get('site')['adminEmail'];
            $controller->view('error/error', $data);
        } catch (DatabaseConnectException $e) {
            $data['message'] = $e->getMessage();
            $data['adminEmail'] = Config::get('site')['adminEmail'];
            $controller->view('error/error', $data);
        }
    }
}
