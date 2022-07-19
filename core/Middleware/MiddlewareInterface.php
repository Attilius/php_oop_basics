<?php

namespace Middleware;

use Request;
use Response;

interface MiddlewareInterface
{
    public function process(Request $request, Response $response, callable $next);
}