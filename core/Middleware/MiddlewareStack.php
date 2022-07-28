<?php

namespace Middleware;

use Request\Request;
use Response\Response;

class MiddlewareStack
{
    private array $middlewares = [];

    public function addMiddleware(MiddlewareInterface $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function pipe(Request $request, Response $response): Response
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