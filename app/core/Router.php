<?php

namespace core;

class Router
{

    private $uri;
    private $requestMethod;

    public function __construct($uri, $requestMethod)
    {
        $this->uri = trim($uri, "/");
        $this->requestMethod = $requestMethod;
    }

    public function get($route, $controllerAction)
    {
        $args = $this->isCorrectRoute($route);
        if (!$args || $this->requestMethod != 'GET')
            return;

        $this->callFunction($controllerAction, $args);
    }

    public function post($route, $controllerAction)
    {
        $args = $this->isCorrectRoute($route);
        if (!$args || $this->requestMethod != 'POST')
            return;

        $args = array_merge(array('request' => $_POST), $args);

        $this->callFunction($controllerAction, $args);
    }

    public function delete($route, $controllerAction)
    {
        $args = $this->isCorrectRoute($route);
        if (!$args || $this->requestMethod != 'DELETE')
            return;

        $this->callFunction($controllerAction, $args);
    }

    public function put($route, $controllerAction)
    {
        $args = $this->isCorrectRoute($route);
        if (!$args ||$this->requestMethod != 'PUT')
            return;

        parse_str(file_get_contents("php://input"),$putRequestBody);

        $args = array_merge(array('request' => $putRequestBody), $args);

        $this->callFunction($controllerAction, $args);
    }

    private function callFunction($controllerAction, $args){
        $controller = explode('@', $controllerAction)[0];
        $action = explode('@', $controllerAction)[1];

        call_user_func_array(array(new $controller, $action), $args);
    }

    private function isCorrectRoute($route){
        $route = trim($route, '/');
        $definedRoute = explode('/', $this->uri);
        $passedRoute = explode('/', $route);

        if (count($passedRoute) !== count($definedRoute)) {
            return false;
        }

        $args = array();

        foreach ($passedRoute as $index => $itemPassedRoute) {

            //IF startWith('{') AND endsWith('}')
            if (substr($itemPassedRoute, 0, 1) === '{' && substr($itemPassedRoute, strlen($itemPassedRoute) - 1, strlen($itemPassedRoute)) === '}') {
                $paramName = substr($itemPassedRoute, 1, strlen($itemPassedRoute) - 2);
                $args[$paramName] = $definedRoute[$index];
                continue;
            }

            if ($itemPassedRoute !== $definedRoute[$index]) {
                return false;
            }
        }

        return $args;
    }
}
