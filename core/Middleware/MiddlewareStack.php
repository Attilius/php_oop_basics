<?php

namespace Middleware;

use Request;
use Response;

class MiddlewareStack
{
    private array $middlewares = [];

    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function pipe(Request $request, Response $response)
    {
        return $this->__invoke($request, $response);
    }

    public function __invoke(Request $request, Response $response)
    {
        $middleware = array_shift($this->middlewares);
        if ($middleware == null){
            return $response;
        }
        return $middleware->process($request, $response, $this);
    }
}