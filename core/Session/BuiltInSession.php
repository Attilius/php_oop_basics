<?php

namespace Session;

class BuiltInSession implements SessionInterface
{
    /**
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * @param $key
     * @return string
     */
    public function get($key): string
    {
        return $_SESSION[$key];
    }

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function put($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     * @return void
     */
    public function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        unset($_SESSION);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $_SESSION;
    }

    /**
     * @return Flash
     */
    public function flash(): Flash
    {
        return new Flash($this);
    }
}