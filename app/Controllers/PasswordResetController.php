<?php

namespace Controllers;

use Request;

class PasswordResetController
{

    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function show()
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

    private function getAndDeleteFormSession($key)
    {
        $has = $this->request->getSession()->has($key);
        $this->request->getSession()->remove($key);
        return $has;
    }
}