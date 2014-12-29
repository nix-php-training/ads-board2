<?php

class User extends Model
{
    protected $table = 'users';


    function getByEmail($email)
    {
        $where = [':email' => $email];
        return $this->_db->query("SELECT users.*, roles.role, status.status
                                  FROM users
                                  JOIN status ON users.status_id=status.id
                                  JOIN roles ON users.role_id=roles.id
                                  WHERE users.email=:email", $where)->fetch(PDO::FETCH_OBJ);
    }

    function registration()
    {

    }
}