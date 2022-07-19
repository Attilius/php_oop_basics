<?php

namespace Session;

class SessionFactory
{
    /**
     * @return SessionInterface
     */
    public static function build($driver, array $config)
    {
        switch ($driver){
            case 'file':
                return new FileSession($config);
            case 'default':
                return new BuiltInSession();
            default:
                throw new \Exception("No driver found for key ". $driver);
        }
    }
}