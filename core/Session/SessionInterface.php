<?php

namespace Session;

use StorageInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

interface SessionInterface extends StorageInterface, TokenStorageInterface
{
    /**
     * @return StorageInterface
     */
    public function flash();
}