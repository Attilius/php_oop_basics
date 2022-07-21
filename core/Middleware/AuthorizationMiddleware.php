<?php

namespace Middleware;

use Request\Request;
use Response\Response;
use Services\AuthService;

class AuthorizationMiddleware implements MiddlewareInterface
{

    private array $protectedUrls;
    private AuthService $authService;
    private string $loginUrl;

    /**
     * AuthorizationMiddleware constructor
     * @param string[] $protectedUrls
     * @param AuthService $authService
     * @param string $loginUrl
     */
    public function __construct(array $protectedUrls, AuthService $authService, string $loginUrl)
    {
        $this->protectedUrls = $protectedUrls;
        $this->authService = $authService;
        $this->loginUrl = $loginUrl;
    }

    public function process(Request $request, Response $response, callable $next)
    {
        if (in_array($request->getUri(), $this->protectedUrls) && !$this->authService->check()){
            return Response::redirect($this->loginUrl);
        }
        return $next($request, $response);
    }
}