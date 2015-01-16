<?php
return [
    "route" => [
        'default' => array(
            //'template' => '^\/(\w+)(\/?)(\w*)[\/\?]+(.*)?$',
            'template' => '^\/(\w+)(\/?)(\w*)(\/?)(\??)(.*)?$',
            //{some_digit} means there will be filled  data from regexp. {0} contains string(or substring) that matched to this template
            'controller' => '{1}',
            //dynamic
            'action' => '{3}',
            //dynamic
            'params' => array(
                'queryString' => '{6}'
                //dynamic again
            ),
        ),
        'main' => array(
            'template' => '^\/$',
            'controller' => 'home', //static
            'action' => 'index',//static
            'params' => array()
        ),
        'postdetail' => array(
            'template' => '^\/postdetail\/(\w+)$',
            'controller' => 'home', //static
            'action' => 'postdetail',//static
            'params' => array(
                'adsId' => '[1]'
            )
        ),
        'static' => array(
            '/home' => '/',
            '/terms' => '/home/terms',
            '/about' => '/home/about',
            '/login' => '/user/login',
            '/logout' => '/user/logout',
            '/profile' => '/profile/profile',
            '/edit' => '/profile/editprofile',
            '/registration' => '/user/registration',
            '/confirm' => '/user/confirm',
            '/success' => '/user/success',
            '/cancelled' => '/user/cancelled',
            '/restore' => '/user/restore',
            '/error404' => '/error/error404',
            '/error403' => '/error/error403',
            '/plan' => '/user/plan',
            '/postlist' => '/home/postlist',
            //   '/postdetail' => '/home/postdetail',
            '/addpost' => '/home/addpost',
            '/imagedownload' => '/home/imagedownload',
            '/admin' => '/admin/index'
        )
    ]
];