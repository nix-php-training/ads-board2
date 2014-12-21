<?php
return [
    "acl" => [
        'home' => [
            'index' => ['all'],
        ],
        'user' => [
            'login'=> ['all'],
            'registration' => ['admin'],
            'logout' => ['user', 'admin'],
        ],
        'error404' => [
            'index'=> ['all'],
        ],
    ],
];