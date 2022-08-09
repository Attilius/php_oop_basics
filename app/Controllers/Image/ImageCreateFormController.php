<?php

namespace Controllers\Image;

use Session\SessionInterface;

class ImageCreateFormController
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
        $violations = $this->session->flash()->get("violations");
        return [
            "add",
            [
                "title" => "Add new photo",
                "violations" => $violations
            ]
        ];
    }
}