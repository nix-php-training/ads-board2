<?php

class Auth
{

    static function init()
    {
        session_start();
        if (empty($_SESSION['userId'])){
            $usersPath = Config::get("users");
            if (isset($usersPath) && is_file($usersPath)){
                include_once $usersPath;
                $users = new User();
                if (isset($_COOKIE['hash']) && isset($_COOKIE['id'])){
                    $userId=$users->getIdByHash($_COOKIE['hash']);
                    if ($_COOKIE['id'] == $users->hashCoockie($userId)){
                        $user = $users->getBy('id', $userId);
                        $_SESSION['userId'] = $user->id;
                        $_SESSION['userRole'] = $user->role;
                        $_SESSION['userStatus'] = $user->status;
                    }
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