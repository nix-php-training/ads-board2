<?php

class Profile extends Model
{

    protected $table = 'profiles';

    protected $rules = [
        'login' => ['login', 'min_length(3)', 'max_length(32)'],
        'email' => ['email'],
        'password' => ['min_length(3)', 'max_length(32)']
    ];

    public function getProfile($id)
    {
        return $this->db->fetchRow($this->table, ['*'], ['userId'=>$id]);
    }

}