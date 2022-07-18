<?php

return [
    'db_host' => 'localhost',
    'db_name' => 'training',
    'db_user' => 'training',
    'db_pass' => 'password',
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
