<?php

class ViewHelper
{
    private static $errorPath = '/application/views/error/';

    public static function generateError($code)
    {
        switch ($code) {
            case 404:
               var_dump($code);
                return file_get_contents($_SERVER['DOCUMENT_ROOT'] . self::$errorPath . 'error404.phtml');
        }
    }

}