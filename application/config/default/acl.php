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
        'error' => [
            'index' => ['all'],
            'error404' => ['all'],
            'error403' => ['all'],
        ],
    ],
];