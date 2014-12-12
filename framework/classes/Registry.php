<?php

class Registry
{
    protected static $data;

    public static function set($key, $value)
    {
        self::$data[$key] = $value;
    }

    public static function get($key)
    {
        if (self::has($key)) {
            return self::$data[$key];
        } else {
            return null;
        }
    }

    public static function delete($key)
    {
        if (self::has($key)) {
            unset(self::$data[$key]);
        }
    }

    public static function has($key)
    {
        return isset(self::$data[$key]);
    }
}