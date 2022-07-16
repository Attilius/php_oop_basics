<?php

use Controllers\HomeController;
use Controllers\LoginFormController;
use Controllers\LoginSubmitController;
use Controllers\LogoutSubmitController;
use Controllers\NotFoundController;
use Controllers\SingleImageController;
use Controllers\SingleImageDeleteController;
use Controllers\SingleImageEditController;
use Exception\SqlException;
use Middleware\AuthorizationMiddleware;
use Middleware\DispatchingMiddleware;
use Middleware\MiddlewareStack;
use Services\AuthService;
use Services\PhotoService;

return [
    "responseFactory" => function(ServiceContainer $container){
        return new ResponseFactory($container->get("viewRenderer"));
    },
    "viewRenderer" => function(ServiceContainer $container){
        return new ViewRenderer($container->get("basePath"));
    },
    "responseEmitter" => function(){
        return new ResponseEmitter();
    },
    "homeController" => function(ServiceContainer $container){
        return new HomeController($container->get("photoService"));
    },
    "config" => function(ServiceContainer $container){
        $base = $container->get("basePath");
        return include_once $base."/config.php";
    },
    "connection" => function(ServiceContainer $container){
        $config = $container->get("config");
        $connection = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
        if (!$connection) {
            throw new SqlException('Connection error: ' . mysqli_error($connection));
        }

        return $connection;
    },
    "photoService" => function(ServiceContainer $container){
        return new PhotoService($container->get("connection"));
    },
    "authService" => function(ServiceContainer $container){
        return new AuthService($container->get("connection"));
    },
    "singleImageController" => function(ServiceContainer $container){
        return new SingleImageController($container->get("photoService"));
    },
    "singleImageEditController" => function(ServiceContainer $container){
        return new SingleImageEditController($container->get("photoService"));
    },
    "singleImageDeleteController" => function(ServiceContainer $container){
        return new SingleImageDeleteController($container->get("photoService"));
    },
    "loginFormController" => function(){
        return new LoginFormController();
    },
    "loginSubmitController" => function(ServiceContainer $container){
        return new LoginSubmitController($container->get("authService"));
    },
    "logoutSubmitController" => function(ServiceContainer $container){
        return new LogoutSubmitController($container->get("authService"));
    },
    "notFoundController" => function(){
        return new NotFoundController();
    },
    "request" => function(){
        return new Request($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"], "", getallheaders(), $_COOKIE, $_POST);
    },
    "pipeline" => function(ServiceContainer $container){
        $pipeLine = new MiddlewareStack();
        $authMiddleware = new AuthorizationMiddleware(["/"], $container->get("authService"), "/login");
        $dispatcherMiddleware = new DispatchingMiddleware($container->get("dispatcher"), $container->get("responseFactory"));
        $pipeLine->addMiddleware($authMiddleware);
        $pipeLine->addMiddleware($dispatcherMiddleware); // Ez az utolsó a (stack)-ben
        return $pipeLine;
    },
    "dispatcher" => function(ServiceContainer $container){
        $dispatcher = new Dispatcher($container,'notFoundController@handle');

        $dispatcher->addRoute('/', 'homeController@handle');
        $dispatcher->addRoute('/about', 'aboutController');
        $dispatcher->addRoute('/image/(?<id>[\d]+)', 'singleImageController@display');
        $dispatcher->addRoute('/image/(?<id>[\d]+)/edit', 'singleImageEditController@edit', 'POST');
        $dispatcher->addRoute('/image/(?<id>[\d]+)/delete', 'singleImageDeleteController@delete', 'POST');
        $dispatcher->addRoute('/login', 'loginFormController@show');
        $dispatcher->addRoute('/logout', 'logoutSubmitController@submit');
        $dispatcher->addRoute('/login', 'loginSubmitController@submit','POST');

        return $dispatcher;
    }
];