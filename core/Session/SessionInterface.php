<?php

namespace Session;

use StorageInterface;

interface SessionInterface extends StorageInterface
{
    public function toArray();
}