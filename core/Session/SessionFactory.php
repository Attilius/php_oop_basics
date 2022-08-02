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
        switch ($driver){
            case 'file':
                return new FileSession($config);
            case 'default':
                return new BuiltInSession();
            default:
                throw new Exception("No driver found for key ". $driver);
        }
    }
}