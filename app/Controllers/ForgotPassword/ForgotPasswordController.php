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

    /**
     * @return array
     */
    public function show(): array
    {
        return [
            "forgotpass",
            [
                "sent" => $this->sent(),
                "title" => "Forgot password"
            ]
        ];
    }

    /**
     * @return bool
     */
    private function sent(): bool
    {
        $sentPassword = $this->session->has("sentPassword");
        $this->session->remove("sentPassword");
        return $sentPassword;
    }
}