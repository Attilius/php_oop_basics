<?php

namespace Controllers\Locale;

use Request\Request;

class LocaleChangeController
{
    private array $availableLocales;
    private Request $request;

    public function __construct(Request $request, array $availableLocales)
    {
        $this->availableLocales = $availableLocales;
        $this->request = $request;
    }

    /**
     * @param $params
     * @return array
     */
    public function change($params): array
    {
        $locale = $params["locale"];
        if (in_array($locale, $this->availableLocales)){
            $this->request->getSession()->put("locale", $locale);
        }

        $redirectTarget = "/";

        if (array_key_exists("Referer", $this->request->getHeaders())){
            $referer = $this->request->getHeaders()["Referer"];
        }
        if (strpos($referer, "http://localhost") === 0){
            $redirectTarget = $referer;
        }
        return [
            "redirect:" . $redirectTarget,
            []
        ];
    }
}