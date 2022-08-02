<?php

namespace Middleware;

use Request\Request;
use Response\Response;

interface MiddlewareInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     */
    public function process(Request $request, Response $response, callable $next);
}