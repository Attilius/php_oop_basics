<?php

namespace Controllers\ForgotPassword;

use Request\Request;

class PasswordResetController
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function show(): array
    {
        return [
            "reset",
            [
                "title" => "Set your new password",
                "failed" => $this->failed(),
                "sent" => $this->sent(),
                "token" => $this->request->getParams()["token"]
            ]
        ];
    }

    private function failed()
    {
        return $this->getAndDeleteFormSession("failed");
    }

    private function sent()
    {
        return $this->getAndDeleteFormSession("resetPassword");
    }

    /**
     * @param $key
     * @return bool
     */
    private function getAndDeleteFormSession($key): bool
    {
        $has = $this->request->getSession()->has($key);
        $this->request->getSession()->remove($key);
        return $has;
    }
}