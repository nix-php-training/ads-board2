<?php

class Requests
{
    public static function request()
    {
        return $_REQUEST;
    }

    public static function post()
    {
        return $_POST;
    }

    public static function get()
    {
        return $_GET;
    }
} 