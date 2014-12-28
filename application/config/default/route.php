<?php
return [
    "route" => [
        'default' => array(
            'template' => '^\/(\w+)(\/?)(\w*)[\/\?]+(.*)?$',
            //{some_digit} means there will be filled  data from regexp. {0} contains string(or substring) that matched to this template
            'controller' => '{1}',
            //dynamic
            'action' => '{3}',
            //dynamic
            'params' => array(
                'queryString' => '{4}'
                //dynamic again
            ),
        ),
        'main' => array(
            'template' => '^\/$',
            'controller' => 'home', //static
            'action' => 'index',//static
            'params' => array()
        ),
        'static' => array(
            '/home' => '/',
            '/login' => '/user/login',
            '/logout' => '/user/logout',
            '/registration' => '/user/registration',
            '/confirmation' => '',
            '/restore-password' => '',
            '/error404' => '/error/error404',
        )
    ]
];