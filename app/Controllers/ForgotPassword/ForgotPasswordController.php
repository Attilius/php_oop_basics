<?php

namespace Controllers\ForgotPassword;

use Session\SessionInterface;

class ForgotPasswordController
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function show()
    {
        return [
            "forgotpass",
            [
                "sent" => $this->sent(),
                "title" => "Forgot password"
            ]
        ];
    }

    private function sent()
    {
        $sentPassword = $this->session->has("sentPassword");
        $this->session->remove("sentPassword");
        return $sentPassword;
    }
}