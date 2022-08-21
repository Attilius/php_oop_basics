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
}