<?php

class UserModel
{
    private $name;
    private $email;
    private $password;

    public function __construct($request)
    {
        $this->name = isset($request['username']) ? Tools::prepareString($request['username']) : 'invalid';
        $this->email = isset($request['email']) ? Tools::prepareString($request['email']) : 'invalid';
        $this->password = isset($request['password']) ? Tools::prepareString($request['password']) : 'invalid';
    }

    public function getUser()
    {

        return array(
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        );
    }
} 