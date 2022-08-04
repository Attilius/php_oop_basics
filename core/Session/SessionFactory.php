<?php

namespace Session;

use Exception;

class SessionFactory
{
    /**
     * @param $driver
     * @param array $config
     * @return BuiltInSession|FileSession
     * @throws Exception
     */
    public static function build($driver, array $config): BuiltInSession|FileSession
    {
        return match ($driver) {
            'file' => new FileSession($config),
            'default' => new BuiltInSession(),
            default => throw new Exception("No driver found for key " . $driver),
        };
    }
}