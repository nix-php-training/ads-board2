<?php

/**
 * Class Registry
 */
class Registry
{
    /**
     * Array of registry's elements
     *
     * @var
     */
    private static $data;
    /**
     * Array of locked elements
     *
     * @var array
     */
    private static $lock = array();

    /**
     * Create new or change exist element of registry
     *
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        if (!self::hasLock($key))
            self::$data[$key] = $value;
    }

    /**
     *
     * @param $key
     * @return bool
     */
    public static function hasLock($key)
    {
        return isset(self::$lock[$key]);
    }

    /**
     * If function has parameter returns null or value by key.
     * If parameter is null or doesn't exist returns whole registry
     *
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

    /**
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return isset(self::$data[$key]);
    }

    /**
     * Remove element if it's not locked
     *
     * @param $key
     */
    public static function delete($key)
    {
        if (self::has($key) && self::hasLock($key))
            unset(self::$data[$key]);
    }

    /**
     * Lock element from changing or deleting
     *
     * @param $key
     */
    public static function lock($key)
    {
        self::$lock[$key] = true;
    }

    /**
     * @param $key
     */
    public static function unlock($key)
    {
        if (self::hasLock($key)) {
            unset(self::$lock[$key]);
        }
    }
}