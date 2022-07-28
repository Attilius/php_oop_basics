<?php

namespace Middleware;

use Request\Request;
use Response\Response;
use Response\ResponseInterface;

class FlashMessageCleanupMiddleware implements MiddlewareInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function process(Request $request, Response $response, callable $next): ResponseInterface
    {
        /**
         * @var ResponseInterface
         */
        $finished = $next($request, $response);
        if ($finished->getStatusCode() < 300){
            $request->getSession()->flash()->clear();
        }
        return $finished;
    }
}