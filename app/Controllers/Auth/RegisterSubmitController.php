<?php

namespace Controllers\Auth;

use Exception\SqlException;
use Services\AuthService;
use Session\SessionInterface;

class RegisterSubmitController
{

    public function __construct(AuthService $authService, SessionInterface $session)
    {
        $this->authService = $authService;
        $this->session = $session;
    }
}