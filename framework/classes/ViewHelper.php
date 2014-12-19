<?php

class ViewHelper
{
    private static $errorPath = '/application/views/error/';

    public static function generateError($code)
    {
        switch ($code) {
            case 404:
<<<<<<< HEAD
=======
               var_dump($code);
>>>>>>> 31f2180af2c18b610cb490d6d41daf1639409b5c
                return file_get_contents($_SERVER['DOCUMENT_ROOT'] . self::$errorPath . 'error404.phtml');
        }
    }

}