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

    public function __construct(array $protectedUrls, AuthService $authService, string $loginUrl)
    {
        $this->protectedUrls = $protectedUrls;
        $this->authService = $authService;
        $this->loginUrl = $loginUrl;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function process(Request $request, Response $response, callable $next): Response
    {
        $matches = array_filter($this->protectedUrls, function ($url) use ($request){
            return preg_match("%".$url."%", $request->getUri());
        });
        if ($matches && !$this->authService->check()){
            return Response::redirect($this->loginUrl);
        }
        return $next($request, $response);
    }
}