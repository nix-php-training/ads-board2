<?php

class Config
{
    private static $conf;

    public static function init($confName = null)
    {
        self::$conf = require DEFCONF . 'default.php';

        if (!is_null($confName)) {
            $dev = require ACONF . $confName . '/conf.php';

            self::$conf = array_merge(self::$conf, $dev);
        }

    }

    public static function get($key = null)
    {
        if (array_key_exists($key, self::$conf))
            return self::$conf[$key];
        return self::$conf;

    }


} 