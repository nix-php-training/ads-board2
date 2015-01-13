<?php

class Tools
{
    /**
     * @param $string
     * @return string
     */
    public static function prepareString($string)
    {
        $string = strip_tags($string);
        $string = htmlspecialchars($string);
        $string = htmlentities($string);
        $string = stripslashes($string);
        return $string;
    }

    /**
     * Cut default file extension and add '.php' extension
     *
     * @param $url
     * @return string
     */
    public static function normalizeUrl($url, $extension)
    {
        $p = strrpos($url, '.');
        if ($p > 0) {
            return substr($url, 0, $p) . '.' . $extension;
        }
        return $url . '.' . $extension;
    }

    /**
     * Cut the file extension.
     *
     * @param $url
     * @return string
     */
    public static function cutExtension($url)
    {
        $p = strrpos($url, ' . ');
        if ($p > 0) {
            return substr($url, 0, $p);
        }
        return $url;
    }

    /**
     * Return application request like array (request, post, get)
     *
     * @return array
     */
    public static function getRequest()
    {
        return array(
            'request' => $_REQUEST,
            'post' => $_POST,
            'get' => $_GET
        );
    }

    public static function generatePassword($length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-.";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }
}