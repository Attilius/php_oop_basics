<?php

namespace Controllers;

use Session\SessionInterface;

class LoginFormController
{

    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function show()
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

    private function checkForError()
    {
        $containsError = $this->session->has("containsError");
        $this->session->remove("containsError");
        return $containsError;
    }
}