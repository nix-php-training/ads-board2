<?php

class Router
{
    private $actionName;
    private $controllerName;
    private $params;
    private $routes;


    public function getRoutes(){return $this->routes;}
    public function setRoutes($routes){$this->routes = $routes;}

    public function getParams(){return $this->params;}
    public function setParams($params){$this->params = $params;}

    public function getControllerName(){return $this->controllerName;}
    public function getActionName(){return $this->actionName;}

    public function setActionName($actionName){$this->actionName = $actionName;}
    public function setControllerName($controllerName){$this->controllerName = $controllerName;}


    public function initRoutes(){
        $routes = Config::get('route');

        if (isset($routes))
            $this->setRoutes($routes);

    }

    public function getActiveRoute()
    {
        $this->setControllerName('Home');
        $this->setActionName('index');

        $url = $_GET['action'];

        if (isset($this->getRoutes()[$url])){

            $this->setControllerName('Home');
            $this->setActionName('index');
        }

        if (!empty($routes[1])) {
            $this->actionName = $routes[1];
        }

        return [$this->controllerName, $this->actionName];

    }

//    function errorPage()
//    {
//        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
//        header('HTTP/1.1 404 Not Found');
//        header("Status: 404 Not Found");
//        include '/application/views/error/ErrorView.php';
//    }

    public function _checkActiveRoute($uri)
    {
        $uri = substr($uri, 1);
        if (trim($uri)) {
            $activeRoute = null;

            foreach($this->_routes as $name => $routeSettings) {
                if (!$routeSettings['template'])
                    continue;
                if (preg_match('@' . $routeSettings['template'] . '@', $uri, $matches)) {
                    if (isset($routeSettings['params'])) {
                        foreach($routeSettings['params'] as $paramName => $param) {
                            $this->_params[$paramName] = $matches[$param];
                        }
                    }
                    $activeRoute = $name;
                }
            }
        } else {
            $activeRoute = 'main';
        }

        return $activeRoute;
    }

    /**
     * dispatch
     *
     * @param string $activeRoute active route name
     */
    public function _dispatch($activeRoute)
    {
        if (isset($this->_routes[$activeRoute])) {
            $this->_controller = $this->_routes[$activeRoute]['controller'];
            $this->_action = $this->_routes[$activeRoute]['action'];
        }
    }






}

