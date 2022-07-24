<?php

namespace Middleware;

use Request\Request;
use Response\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class CsrfMiddleware implements MiddlewareInterface
{

    private CsrfTokenManagerInterface $csrfTokenManager;

    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function process(Request $request, Response $response, callable $next)
    {
        if ($request->getMethod() === "POST" && $this->tokenIsInvalid($request)){
            return new Response("CSRF token is not present", [], 403, "Forbidden");
        }
        return $next($request, $response);
    }

    private function tokenIsInvalid(Request $request)
    {
        return !$this->csrfTokenManager->isTokenValid(new CsrfToken("_csrf", $request->getParam("_csrf")));
    }
}