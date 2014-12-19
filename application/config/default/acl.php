<?php
return [
    "acl" => [
        'home' => [
            'index' => ['all'],
        ],
        'user' => [
            'login'=> ['registered-user', 'admin'],
            'registration' => ['guest'],
        ],
        'error404' => [
            'index'=> ['all'],
        ],
    ],
];