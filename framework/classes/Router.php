<?php

class Router
{
    private $actionName;
    private $controllerName;
    private $params;
    private $routes;


    public function getRoutes()
    {
        return $this->routes;
    }

    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function setControllerName($controllerName)
    {
        $this->controllerName = $controllerName;
    }

    public function getActionName()
    {
        return $this->actionName;
    }

    public function setActionName($actionName)
    {
        $this->actionName = $actionName;
    }

    public function getQueryParamsFromURL($string)
    {
        $queryParams = array();
        if($string == '') return array();
        else{
            $devidedByAnd = explode('&', $string);
            foreach ($devidedByAnd as $v)
            {
                $devidedByEquil = explode('=', $v);
                $queryParams[$devidedByEquil[0]] = $devidedByEquil[1];
            }
            return $queryParams;

        }


    }

    public function initRoutes()
    {
        $routes = Config::get('route');


        if (isset($routes)) {
            $this->routes = $routes;
        }
    }

    public function getActiveRoute()
    {

        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "";


        $aliases = Config::get('route','static');

        if($aliases && array_key_exists($url,$aliases))
        {
            $url = $aliases[$url];
        }

        $this->checkActiveRoute($url);
        
        return [$this->controllerName, $this->actionName, $this->params];

    }




    public function checkActiveRoute($uri)
    {
        trim($uri);
            foreach ($this->routes as $name => $routeSettings) {
                if (!$routeSettings['template']) {

                    continue;
                }
                if (preg_match('@' . $routeSettings['template'] . '@
                ', $uri, $matches)) { //matched and parsed

                    if ($routeSettings['controller'][0] == "{") { //if controoler name is dynamic
                        $this->controllerName = $matches[$routeSettings['controller'][1]];
                    } else {
                        $this->controllerName = $routeSettings['controller'];
                    }
                    if ($routeSettings['action'][0] == "{") { //if action name is dynamic
                        $this->actionName = $matches[$routeSettings['action'][1]];
                    } else {
                        $this->actionName = $routeSettings['action'];
                    }
                    if (isset($routeSettings['params'])) {
                        $this->params = array();
                        foreach ($routeSettings['params'] as $paramName => $param) {
                            if ($param[0] == "{") {//if $param is dynamic

                                $this->params = $this->getQueryParamsFromURL($matches[$param[1]]);
                            } else
                            {
                                $this->params[$paramName] = $param;
                            }
                        }
                    }

                }

            }

    }




}

