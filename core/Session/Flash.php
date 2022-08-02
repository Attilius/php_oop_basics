<?php

namespace Session;

use StorageInterface;

class Flash implements StorageInterface
{
    private SessionInterface $session;
    const KEY = "flash";

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param $key
     * @return bool|void
     */
    public function has($key)
    {
        if ($this->session->has(self::KEY)){
            $flash = $this->session->get(self::KEY);
            return array_key_exists($key, $flash);
        }
    }

    /**
     * @param $key
     * @return mixed|void
     */
    public function get($key)
    {
        if ($this->session->has(self::KEY)){
            $flash = $this->session->get(self::KEY);
            if (array_key_exists($key, $flash)){
                return $flash[$key];
            }
        }
    }

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function put($key, $value): void
    {
        if ($this->session->has(self::KEY)){
            $flash = $this->session->get(self::KEY);
            $flash[$key] = $value;
            $this->session->put(self::KEY, $flash);
        } else {
            $this->session->put(self::KEY, [
                $key => $value
            ]);
        }
    }

    public function remove($key)
    {
        if ($this->session->has(self::KEY)){
            $flash = $this->session->get(self::KEY);
            unset($flash[$key]);
            $this->session->put(self::KEY, $flash);
        }
    }

    public function clear()
    {
        $this->session->remove(self::KEY);
    }
}