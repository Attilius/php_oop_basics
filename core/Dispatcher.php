<?php

use Controllers\NotFoundController;

class Dispatcher
{
    private NotFoundController $notFoundController;
    private ServiceContainer $container;
    private array $routes = [];

    public function __construct(ServiceContainer $container, NotFoundController $notFoundController)
    {
        $this->notFoundController = $notFoundController;
        $this->container = $container;
    }

    public function addRoute($action, $callable, $method = "GET")
    {
        $pattern = "%^$action$%";
        $this->routes[strtoupper($method)][$pattern] = $callable;
    }

    public function dispatch(Request $request)
    {
        $method = $request->getMethod();
        $action = explode("?", $request->getUri())[0];
        if (array_key_exists($method, $this->routes)){
            foreach ($this->routes[$method] as $pattern => $callable) {
                if (preg_match($pattern, $action, $matches)){
                    return $this->invokeHandler($callable, $matches);
                }
            }
        }
        return $this->invokeHandler($this->notFoundController, $matches);
    }

    private function invokeHandler($callable, $matches)
    {
        if (strpos($callable,'@')){
            return $this->invokeFromContainer($callable, $matches);
        } else {
            return $callable($matches);
        }
    }

    private function invokeFromContainer(string $callable, $matches)
    {
        $pair = explode('@', $callable);
        $controller = $pair[0];
        $method = $pair[1];
        return $this->container->get($controller)->$method($matches);
    }
}