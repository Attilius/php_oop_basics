<?php

interface StorageInterface
{
    public function has($key);
    public function get($key);
    public function put($key, $value);
    public function remove($key);
    public function clear();
}