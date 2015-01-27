<?php

class Auth
{

    /**
     * @param $users User
     */
    function __construct($users)
    {
        session_start();
        if (isset($_COOKIE['hash']) && isset($_COOKIE['id'])) {
            $userId = $users->getIdByHash();
            if ($_COOKIE['id'] == $users->hashCoockie($userId)) {
                $user = $users->getBy('id', $userId);
                $_SESSION['userLogin'] = $user['login'];
                $_SESSION['userId'] = $user['id'];
                $_SESSION['userRole'] = $user['role'];
                $_SESSION['userStatus'] = $user['status'];
                $_SESSION['userAdsCounter'] = $users->db->fetchOne('currentPlan', 'adsCounter', ['userId'=>$userId]);
            }
        }
    }

    static function roleDefault()
    {
        if (empty($_SESSION['userRole'])) {
            $_SESSION['userRole'] = 'guest';
        }
    }
}