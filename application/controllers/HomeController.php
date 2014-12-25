<?php

class HomeController extends Controller
{

    public $rules = array(//todo delete test
        'name' => array(
//            'required',
            'max_length(10)',
            'min_length(3)',
        ),
        'age' => array(
            'required',
            'integer',
        ),
        'email' => array(
            'required',
            'email'
        ),
        'password' => array(
            'max_length(50)',
            'required',
        ),
        'password_verify' => array(
            'required'
        ),
    );

    public $post = ['name' => '',
                    'age' => '25',
                    'email' => '#$%F-kuza-mail.ru',
                    'password' => '',
                    'password_verify' => '123',
                    ];
    function indexAction()
    {
        $validator = new Validator();
        var_dump($validator->validate($this->post, $this->rules));
        var_dump($validator->validateOne('#$%F-kuza-mail.ru', 'email'));
    }
}