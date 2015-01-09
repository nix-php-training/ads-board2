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