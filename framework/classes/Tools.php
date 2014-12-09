<?php

/**
 * Class Tools
 */
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
     * cut default file extension and add '.php' extension
     * @param $url
     * @return string
     */
    public static function normalizeUrl($url)
    {
        $p = strrpos($url, '.');
        if ($p > 0) return substr($url, 0, $p) . '.php';
        return $url . '.php';
    }

    /**
     * Cut the file extension.
     * If second parameter is true -- first character of name will be capitalized
     * @param $url
     * @param bool $capitalize
     * @return string
     */
    public static function cutExtension($url, $capitalize = false)
    {
        $p = strrpos($url, '.');
        if ($p > 0)
            if ($capitalize) {
                return substr(ucfirst($url), 0, $p);
            } else
                return substr($url, 0, $p);
        return $url;
    }

    /**
     * return application request like array (request, post, get)
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
} 