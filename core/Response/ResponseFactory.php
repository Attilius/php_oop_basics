<?php

namespace Response;

use ModelAndView;
use Request\Request;
use ViewRenderer;

class ResponseFactory
{
    private ViewRenderer $viewRenderer;

    public function __construct(ViewRenderer $viewRenderer)
    {
        $this->viewRenderer = $viewRenderer;
    }

    /**
     * @param $controllerResult
     * @param Request $request
     * @return Response|ResponseInterface|void
     */
    public function createResponse($controllerResult, Request $request)
    {
        if ($controllerResult instanceof ResponseInterface){
            return $controllerResult;
        }
        if ($controllerResult instanceof Redirect){
            foreach ($controllerResult->getFlashMessages() as $key => $value){
                $request->getSession()->flash()->put($key, $value);
            }
            return new Response("", [
                "Location" => $controllerResult->getTarget()
            ], 302, "Found");
        }
        if (is_array($controllerResult)){
            if (preg_match("%^redirect\:%", $controllerResult[0])) {
                return new Response("", [
                    "Location" => substr($controllerResult[0], 9)
                ], 302, "Found");
            } else {
                $modelAndView = new ModelAndView($controllerResult[0], array_merge($controllerResult[1], $request->getSession()->toArray()));
                return new Response($this->viewRenderer->render($modelAndView, $request->getLocale()), [], 200,"Ok");
            }
        }
    }
}