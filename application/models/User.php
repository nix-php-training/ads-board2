<?php

class User extends Model
{
    protected $table = 'users';

    function getEmail($email)
    {
        return $this->fetchRow('users', ['*'], ['email' => $email]);
    }
}