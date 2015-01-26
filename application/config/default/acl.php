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
            'imageupload' => ['user', 'admin'],
            'adsload' => ['all']
        ],
        'user' => [
            'login' => ['all'],
            'registration' => ['guest'],
            'logout' => ['all'],
            'plan' => ['user', 'admin'],
            'paypal' => ['user', 'admin'],
            'success' => ['user', 'admin'],
            'cancelled' => ['user', 'admin'],
            'confirm' => ['all', 'admin'],
            'restore' => ['guest'],
            'profile' => ['all'],
            'editprofile' => ['user', 'admin'],
            'registrationmessage' => ['guest'],
            'restoremessage' => ['guest'],
            'reset' => ['user', 'admin'],
        ],
        'error' => [
            'index' => ['all'],
            'error404' => ['all'],
            'error403' => ['all'],
        ],
        'profile' => [
            'profile' => ['all'],
            'editprofile' => ['user', 'admin'],
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
        ],
        'searching' => [
            'search' => ['all'],
            'livesearch' => ['all'],
        ]
    ],
];