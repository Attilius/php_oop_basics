<?php

namespace Middleware;

use Locale;
use Request\Request;
use Response\Response;

class LocalizationMiddleware implements MiddlewareInterface
{
    private string $defaultLocale;
    private array $availableLocales;

    public function __construct(string $defaultLocale, array $availableLocales)
    {
        $this->defaultLocale = $defaultLocale;
        $this->availableLocales = $availableLocales;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     */
    public function process(Request $request, Response $response, callable $next)
    {
        $localeFromRequest = "";

        if (array_key_exists("Accept-Language", $request->getHeaders())){
            $localeFromRequest = Locale::acceptFromHttp($request->getHeaders()["Accept-Language"]);
        }

        if ($request->getSession()->has("user")){
            $localeFromRequest = Locale::parseLocale($request->getSession()->get("user")["locale"]);
        }

        if ($request->getSession()->has("locale")){
            $localeFromRequest = Locale::parseLocale($request->getSession()->get("locale"));
        }

        $locale = in_array($localeFromRequest, $this->availableLocales) ? $localeFromRequest : $this->defaultLocale;
        return $next($request->withLocale($locale), $response);
    }
}