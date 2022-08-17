<?php

namespace Controllers\Auth;

use Session\SessionInterface;

class LoginFormController
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
        $containsError = $this->checkForError();
        return [
            "login",
            [
                "title" => "Login",
                "containsError" => $containsError
            ]
        ];
    }

    /**
     * @return bool
     */
    private function checkForError()
    {
        $containsError = $this->session->has("containsError");
        $this->session->remove("containsError");
        return $containsError;
    }
}