<?php

namespace Controllers\Auth;

use Exception\SqlException;
use Services\AuthService;
use Session\SessionInterface;

class RegisterSubmitController
{
    private AuthService $authService;
    private SessionInterface $session;

    public function __construct(AuthService $authService, SessionInterface $session)
    {
        $this->authService = $authService;
        $this->session = $session;
    }

    function submit()
    {
        $password = trim($_POST["password"]);
        $email = trim($_POST["email"]);
        $success = $this->authService->registerUser($email, $password);
        if ($success){
            $view = "redirect:/";
        }else{
            $this->markAsLoginFailed();
            $view = "redirect:/login";
        }
        return [
            $view,
            []
        ];
    }

    /**
     * @return void
     */
    private function markAsLoginFailed(): void
    {
        $this->session->put("containsError", 1);
    }
}