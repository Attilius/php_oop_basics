<?php

namespace Controllers\ForgotPassword;

use Request\Request;
use Services\ForgotPasswordService;

class ForgotPasswordSubmitController
{

    private Request $request;
    private ForgotPasswordService $service;

    public function __construct(Request $request, ForgotPasswordService $service)
    {
        $this->request = $request;
        $this->service = $service;
    }

    /**
     * @return array
     */
    public function submit(): array
    {
        $this->markForgotPasswordSent();
        $params = $this->request->getParams();
        $this->service->forgotPassword($params["email"]);
        return [
            "redirect:/forgotpass",
            []
        ];
    }

    /**
     * @return void
     */
    private function markForgotPasswordSent(): void
    {
        $this->request->getSession()->put("sentPassword", 1);
    }
}