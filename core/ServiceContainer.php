<?php

use Exception\ServiceNotFoundException;

class ServiceContainer
{
    private array $definitions;

    public function __construct(array $definitions = [])
    {
        $this->definitions = $definitions;
    }

    /**
     * @param $service
     * @throws ServiceNotFoundException
     */
    public function get($service)
    {
        if (array_key_exists($service, $this->definitions)){
            if (is_callable($this->definitions[$service])){
                $factory = $this->definitions[$service];
                $this->definitions[$service] = $factory($this);
            }
        } else {
            throw new ServiceNotFoundException($service);
        }
        return $this->definitions[$service];
    }

    /**
     * @param $key
     * @param $service
     * @return void
     */
    public function put($key, $service): void
    {
        $this->definitions[$key] = $service;
    }
}