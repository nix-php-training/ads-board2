<?php
return [
    "acl" => [
        'home' => [
            'index' => ['all'],
        ],
        'user' => [
            'login' => ['all'],
            'registration' => ['admin'],
            'logout' => ['user', 'admin'],
            'paypal' => ['all'],
        ],
        'error404' => [
            'index' => ['all'],
        ],
    ],
];