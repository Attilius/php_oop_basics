<?php

namespace Controllers\Auth;

use Session\SessionInterface;

class RegisterFormController
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @return bool
     */
    private function checkForError(): bool
    {
        $containsError = $this->session->has("containsError");
        $this->session->remove("containsError");
        return $containsError;
    }
}