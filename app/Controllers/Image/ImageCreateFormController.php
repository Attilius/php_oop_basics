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

    public function show()
    {
        $violations = $this->session->get("violations");
        $this->session->remove("violations");
        return [
            "add",
            [
                "title" => "Add new photo",
                "violations" => $violations
            ]
        ];
    }
}