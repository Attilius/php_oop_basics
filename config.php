<?php

return [
    'db_host' => 'localhost',
    'db_name' => 'training',
    'db_user' => 'training',
    'db_pass' => 'password',
    "default_locale" => "hu_HU",
    "available_locales" => [
        "en_US",
        "hu_HU",
        "fr_FR"
    ],
    'session' => [
        'driver' => 'file',
        'config' => [
            'folder' => realpath(__DIR__)."/storage/sessions"
        ]
    ],
    'mail' => [
        'username' => 'c4657bfd21e306',
        'password' => '7ef83c746d9b72',
        'host' => 'smtp.mailtrap.io',
        'port' => 465
    ]
];
