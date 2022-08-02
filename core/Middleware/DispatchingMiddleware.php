<?php

namespace Middleware;

use Dispatcher;
use Request\Request;
use Response\Response;
use Response\ResponseFactory;
use Response\ResponseInterface;

class DispatchingMiddleware implements MiddlewareInterface
{
    private Dispatcher $dispatcher;
    private ResponseFactory $responseFactory;

    public function __construct(Dispatcher $dispatcher, ResponseFactory $responseFactory)
    {
        $this->dispatcher = $dispatcher;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response|ResponseInterface|void
     */
    public function process(Request $request, Response $response, callable $next)
    {
        $controllerResult = $this->dispatcher->dispatch($request);
        return $this->responseFactory->createResponse($controllerResult, $request);
    }
}