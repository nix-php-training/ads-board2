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
        if (isset($_GET['page'])) {
            $url = $_GET['page'];
        } else $url="";

        $this->_checkActiveRoute($url);

        var_dump($this);

//        if (isset($this->getRoutes()[$url])){
//
//            $this->setControllerName('Home');
//            $this->setActionName('index');
//        }
//
//        if (!empty($routes[1])) {
//            $this->actionName = $routes[1];
//        }

        return [$this->controllerName, $this->actionName, $this->params];

    }


    public function _checkActiveRoute($uri)
    {
//        $uri = substr($uri, 1);
        if (trim($uri)) {
            $activeRoute = null;

            foreach($this->routes as $name => $routeSettings) {


                if (!$routeSettings['template'])
                    continue;
                if (preg_match('@' . $routeSettings['template'] . '@', $uri, $matches)) { //matched and parsed
                    if ($routeSettings['controller'][0]=="{"){ //if controoler name is dynamic
                        $this->controllerName= $matches[$routeSettings['controller'][1]];
                    } else {
                        $this->controllerName=$routeSettings['controller'];
                    }
                    if ($routeSettings['action'][0]=="{"){ //if action name is dynamic
                        $this->actionName= $matches[$routeSettings['action'][1]];
                    } else {
                        $this->actionName=$routeSettings['action'];
                    }



                    if (isset($routeSettings['params'])) {
                        $this->params = array();
                        foreach($routeSettings['params'] as $paramName => $param) {
                            if ($param[0]=="{"){//if $param is dynamic
                                $this->params[$paramName]= $matches[$param[1]];
                            } else {
                                $this->params[$paramName]=$param;
                            }

                        }
                    }
                    $activeRoute = $name;



                    return $activeRoute;


                }
            }
        } else {
            $activeRoute = 'main';
        }

        return $activeRoute;
    }

//    /**
//     * dispatch
//     *
//     * @param string $activeRoute active route name
//     */
//    public function _dispatch($activeRoute)
//    {
//        if (isset($this->_routes[$activeRoute])) {
//            $this->_controller = $this->_routes[$activeRoute]['controller'];
//            $this->_action = $this->_routes[$activeRoute]['action'];
//        }
//    }






}

