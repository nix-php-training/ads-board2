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
                    $profile = $users->db->query("SELECT * FROM profiles WHERE userId={$user['id']}")->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['profile']=$profile;
                    $_SESSION['userLogin'] = $user['login'];
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