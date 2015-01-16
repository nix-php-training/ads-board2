<?php
return [
    "acl" => [
        'home' => [
            'index' => ['all'],
            'postlist' => ['all'],
            'pricing' => ['all'],
            'terms' => ['all'],
            'about' => ['all'],
            'postdetail' => ['all'],
            'addpost' => ['user', 'admin'],
            'imagedownload' => ['user', 'admin']
        ],
        'user' => [
            'login' => ['all'],
            'registration' => ['guest'],
            'logout' => ['user', 'admin'],
            'plan' => ['user'],
            'paypal' => ['user'],
            'success' => ['user'],
            'cancelled' => ['user'],
            'confirm' => ['all'],
            'restore' => ['guest'],
            'profile' => ['all'],
            'editprofile' => ['user', 'admin'],
            'registrationmessage' => ['guest'],
            'restoremessage' => ['guest']
        ],
        'error' => [
            'index' => ['all'],
            'error404' => ['all'],
            'error403' => ['all'],
        ],
        'admin' => [
            'index' => ['admin'],
            'users' => ['admin'],
            'plans' => ['admin'],
            'categories' => ['admin'],
            'advertisements' => ['admin'],
            // user management
            'getusers' => ['admin'],
            'banuser' => ['admin'],
            'unbanuser' => ['admin'],
            // plan management
            'saveplan' => ['admin'],
            'removeplan' => ['admin'],
            'getplans' => ['admin'],
            // category management
            'removecategory' => ['admin'],
            'savecategory' => ['admin'],
            'getcategories' => ['admin'],
            // advertisement management
            'removeadvertisement' => ['admin'],
            'getadvertisements' => ['admin']
        ]
    ],
];