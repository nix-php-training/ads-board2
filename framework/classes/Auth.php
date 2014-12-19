<?php

class Auth
{
    static function login()
    {
        if (isset($_POST['email']) && isset($_POST['email'])) {
            $users = Config::get('users');
            if (is_array($users)) {
                foreach ($users as $k) {
                    if ($k['email'] == $_POST['email'] && $k['password'] == $_POST['password']) {
                        $_SESSION['userRole'] = $k['role'];
                        $_SESSION['userName'] = $k['name'];
                        return true;
                    }
                }
            }
        } else {
            return false;
        }
    }
    static function authentication(){
        if (empty($_SESSION['userRole']))
            $_SESSION['userRole'] = 'guest';
        if (self::login() || ($_SESSION['userRole']!='guest')){
            return true;
        } else return false;

    }
} 