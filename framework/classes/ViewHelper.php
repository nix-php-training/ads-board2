<?php

/**
 * !!!USELESS NOW!!!
 *
 * Include error or message template
 *
 * Class ViewHelper
 */
class ViewHelper
{
    /**
     * Default path to template folder
     *
     * @var string
     */
    private static $errorPath = '/application/views/error/';

    /**
     * Include error or message page according to error/message code
     *
     * @param $code
     * @return string
     */
    public static function generateError($code)
    {
        switch ($code) {
            case 404:
                return file_get_contents($_SERVER['DOCUMENT_ROOT'] . self::$errorPath . 'error404.phtml');
        }
    }
}