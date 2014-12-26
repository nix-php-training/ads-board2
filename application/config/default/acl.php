<?php
return [
    "acl" => [
        'home' => [
            'index' => ['all'],
        ],
        'user' => [
            'login' => ['all'],
            'registration' => ['all'],
            'logout' => ['user', 'admin'],
            'paypal' => ['all'],
        ],
        'error404' => [
            'index' => ['all'],
        ],
    ],
];