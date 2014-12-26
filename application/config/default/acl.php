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
        ],
        'error' => [
            'index' => ['all'],
            'error404' => ['all'],
        ],
    ],
];