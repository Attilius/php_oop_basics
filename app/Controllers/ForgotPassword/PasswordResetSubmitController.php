<?php

namespace Controllers\ForgotPassword;

use Exception\SqlException;
use Request\Request;
use Services\ForgotPasswordService;

class PasswordResetSubmitController
{
    private Request $request;
    private ForgotPasswordService $service;

    public function __construct(Request $request, ForgotPasswordService $service)
    {
        $this->request = $request;
        $this->service = $service;
    }

    /**
     * @return string[]
     * @throws SqlException
     */
    public function submit(): array
    {
        $params = $this->request->getParams();
        $session = $this->request->getSession();
        $valid = $this->validate($params);
        if ($valid){
            $this->service->updatePassword($params["token"], $params["password"]);
            $session->put("resetPassword", true);
            return [
                "redirect:/reset"
            ];
        } else {
            $session->put("failed", true);
            return [
                "redirect:/reset"
            ];
        }
    }

    /**
     * @param $params
     * @return bool
     * @throws SqlException
     */
    private function validate($params)
    {
        $password = $params["password"];
        $passwordConf = $params["password_confirmation"];
        return $password == $passwordConf && strlen($password) >= 8 && $this->service->checkTokenExist($params["token"]);
    }
}