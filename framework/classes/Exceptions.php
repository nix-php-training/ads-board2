<?php

class DatabaseConnectException extends Exception
{
    protected $message = "Cannot connect to database, please contact administrator.";

    public function __toString()
    {
        return $this->message;
    }
}

class ConfigLoadException extends Exception
{
    protected $message = "Cannot find configs's folder. Set right path and try again.";

    public function __toString()
    {
        return $this->message;
    }
}

/**
 * Class CurleException
 */
class CurleException extends Exception
{
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return $this->message;
    }
}

/**
 * Class PageNotFoundException
 *
 * Redirect to 404 Page not found page
 */
class PageNotFoundException extends Exception
{
    public function redirect()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        header('Location:' . $host . 'error404');
    }
}

/**
 * Class AccessDenyException
 *
 * Redirect to 403 Access deny page
 */
class AccessDenyException extends Exception
{
    public function redirect()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 403 Access deny');
        header('Status: 403 Access deny');
        header('Location:' . $host . 'error403');
    }
}

class InitRoutesException extends Exception
{
    protected $message = "Route error. Check router configuration.";

    public function __toString()
    {
        return $this->message;
    }
}