<?php

namespace Session;

class BuiltInSession implements SessionInterface
{
    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * @param $key
     * @return string
     */
    public function get($key)
    {
        return $_SESSION[$key];
    }

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     * @return void
     */
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * @return void
     */
    public function clear()
    {
        unset($_SESSION);
    }

    public function toArray()
    {
        return $_SESSION;
    }

    public function flash()
    {
        return new Flash($this);
    }
}