<?php

namespace Session;

use StorageInterface;

interface SessionInterface extends StorageInterface
{
    /**
     * @return StorageInterface
     */
    public function flash();
}