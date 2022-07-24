<?php

namespace Controllers\Auth;

use Services\AuthService;

class LogoutSubmitController
{
    private AuthService $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function submit()
    {
        $this->authService->logout();
        return [
            "redirect:/",
            []
        ];
    }
}