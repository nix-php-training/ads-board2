<?php

class Registry
{
    protected static $data;

    public static function set($key, $value)
    {
        self::$data[$key] = $value;
    }


    /**
     * If function has parameter returns value of key or null.
     * If parameter is null or doesn't exist returns all registry
     * @param null $key
     * @return null
     */
    public static function get($key = null)
    {
        if (!is_null($key)) {
            if (self::has($key))
                return self::$data[$key];
            else
                return null;
        } else {
            return self::$data;
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