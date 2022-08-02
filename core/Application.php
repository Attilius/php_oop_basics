<?php

use Response\Response;

class Application
{
    private ServiceContainer $container;

    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $basePath
     * @return void
     */
    public function start(string $basePath): void
    {
        try {
            $this->container->put("basePath", $basePath);
            ob_start();
            $response = $this->container
                ->get("pipeline")
                ->pipe($this->container->get("request"), new Response("", [], 200, "OK"));
            $this->container->get('responseEmitter')->emit($response);
        } catch (\Exception $e){
            logMessage('ERROR', $e->getMessage());
            die("Critical error occured during page load. Please try again later.");
        }
    }
}