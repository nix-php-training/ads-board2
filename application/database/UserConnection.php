<?php

/**
 * Class UserConnection
 */
class UserConnection extends Database
{

    /**
     * @param $user
     * @return int
     */
    public function register($user)
    {
        if (!$this->extract($user['email'])) {
            $query = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";
            $sth = $this->pdo->prepare($query);
            $sth->bindParam(':username', $user['name']);
            $sth->bindParam(':email', $user['email']);
            $sth->bindParam(':password', $user['password']);
            if ($sth->execute())
                return 1; // ok
            else
                return 3; // unknown error
        } else {
            return 2; // user already exist
        }
    }

    /**
     * @param $email
     * @return mixed
     */
    public function extract($email)
    {
        $query = "SELECT email FROM user WHERE email=?";
        $sth = $this->pdo->prepare($query);
        $sth->execute(array($email));

        return $sth->fetch();
    }
}