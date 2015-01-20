<?php

class Auth
{

    /**
     * @param $users User
     */
    function __construct($users)
    {
        session_start();
        if (empty($_SESSION['userId'])) {
            if (isset($_COOKIE['hash']) && isset($_COOKIE['id'])) {
                $userId = $users->getIdByHash($_COOKIE['hash']);
                if ($_COOKIE['id'] == $users->hashCoockie($userId)) {
                    $user = $users->getBy('id', $userId);
                    $str = strpos($user['email'], "@");
                    $_SESSION['userLogin'] = substr($user['email'], 0, $str);
                    $_SESSION['userId'] = $user['id'];
                    $_SESSION['userRole'] = $user['role'];
                    $_SESSION['userStatus'] = $user['status'];
                }
            }
        }
        self::roleDefault();
    }

    static function roleDefault()
    {
        if (empty($_SESSION['userRole'])) {
            $_SESSION['userRole'] = 'guest';
        }
    }
}