<?php

class Application
{
    private $container;


    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
    }

    public function start(string $basePath){
        $this->container->put("basePath", $basePath);
        ob_start();
        $uri = $_SERVER['REQUEST_URI'];
        $cleand = explode("?", $uri)[0];
        $controllerResult = $this->container->get('dispatcher')->dispatch($cleand);
        //$data['user'] = createUser();
        $response = $this->container->get('responseFactory')->createResponse($controllerResult);
        $this->container->get('responseEmitter')->emit($response);
    }
}