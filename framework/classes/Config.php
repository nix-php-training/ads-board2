<?php

/**
 * Class Config
 *
 * Collects all configs from files.
 * Generates one array of configs.
 */
class Config
{
    /**
     * Array of configs
     *
     * @var
     */
    private static $conf;

    /**
     * Get config by key or key with subkey
     *
     * @param null $key
     * @param null $subkey
     * @return bool
     */
    public static function get($key = null, $subkey = null)
    {
        if (is_null($key) && is_null($subkey))
            return self::$conf;
        if (array_key_exists($key, self::$conf) && is_null($subkey))
            return self::$conf[$key];
        if (array_key_exists($subkey, self::$conf[$key]) && !is_null($key) && !is_null($subkey))
            return self::$conf[$key][$subkey];
        return false;
    }


    /**
     * Initialize config array
     *
     * ACONF is path to folder with configs by user
     * DEFCONF is path to folder with configs by default
     * Please, declare those paths before call function init
     *
     * @param null $dir
     * @return array
     */
    public static function init($dir = null)
    {
        $confDefault = Config::assembleConfig(DEFCONF);
        self::$conf = $confDefault;

        if (isset($dir)) {
            $pathConfig = ACONF . $dir . '/';
            $confUser = Config::assembleConfig($pathConfig);
            self::$conf = array_replace_recursive($confDefault, $confUser);
        }

        $reg = self::get('registry');
        if (!is_null($reg))
            foreach ($reg as $k => $v) {
                Registry::set($k, $v);
            }
    }

    /**
     * Create one config array from all files in directory which is passed like parameter
     *
     * @param $path
     * @return array
     */
    public static function assembleConfig($path)
    {
        $filesList = glob($path . '*.php');
        $config = array();
        foreach ($filesList as $file) {
            $confTemp = require_once $file;
            $config = array_merge($config, $confTemp);
        }
        return $config;
    }

}