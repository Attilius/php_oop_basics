<?php

namespace Middleware;

use Request\Request;
use Response\Response;

interface MiddlewareInterface
{
    public function process(Request $request, Response $response, callable $next);
}