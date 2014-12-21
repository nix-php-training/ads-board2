<?php

class Auth
{
    static function authentication(){
        if (empty($_SESSION['userRole']))
            $_SESSION['userRole'] = 'guest';
    }
} 