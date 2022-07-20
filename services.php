<?php

use Controllers\ForgotPasswordController;
use Controllers\ForgotPasswordSubmitController;
use Controllers\HomeController;
use Controllers\LoginFormController;
use Controllers\LoginSubmitController;
use Controllers\LogoutSubmitController;
use Controllers\NotFoundController;
use Controllers\PasswordResetController;
use Controllers\PasswordResetSubmitController;
use Controllers\SingleImageController;
use Controllers\SingleImageDeleteController;
use Controllers\SingleImageEditController;
use Exception\SqlException;
use Middleware\AuthorizationMiddleware;
use Middleware\DispatchingMiddleware;
use Middleware\MiddlewareStack;
use Services\AuthService;
use Services\ForgotPasswordService;
use Services\PhotoService;
use Session\SessionFactory;

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
        return new AuthService($container->get("connection"), $container->get("session"));
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
    "loginFormController" => function(ServiceContainer $container){
        return new LoginFormController($container->get("session"));
    },
    "loginSubmitController" => function(ServiceContainer $container){
        return new LoginSubmitController($container->get("authService"), $container->get("session"));
    },
    "logoutSubmitController" => function(ServiceContainer $container){
        return new LogoutSubmitController($container->get("authService"));
    },
    "registerFormController" => function(){
        return new RegisterFormController();
    },
    "registerSubmitController" => function(){
        return new RegisterSubmitController();
    },
    "forgotPasswordController" => function(ServiceContainer $container){
        return new ForgotPasswordController($container->get("session"));
    },
    "forgotPasswordSubmitController" => function(ServiceContainer $container){
        return new ForgotPasswordSubmitController($container->get("request"), $container->get("forgotPasswordService"));
    },
    "passwordResetController" => function(ServiceContainer $container){
        return new PasswordResetController($container->get("request"));
    },
    "passwordResetSubmitController" => function(ServiceContainer $container){
        return new PasswordResetSubmitController($container->get("request"), $container->get("forgotPasswordService"));
    },
    "notFoundController" => function(){
        return new NotFoundController();
    },
    "session" => function(ServiceContainer $container){
        $sessionConfig = $container->get("config")["session"];
        return SessionFactory::build($sessionConfig["driver"], $sessionConfig["config"]);
    },
    "request" => function(ServiceContainer $container){
        return new Request($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"], $container->get("session"), file_get_contents("php://input"), getallheaders(), $_COOKIE, array_merge($_GET, $_POST));
    },
    "mailer" => function(ServiceContainer $container){
        $mailerConfig = $container->get("config")["mail"];
        $transport = (new Swift_SmtpTransport($mailerConfig["host"], $mailerConfig["port"]))
            ->setUsername($mailerConfig["username"])
            ->setPassword($mailerConfig["password"]);
        return new Swift_Mailer($transport);
    },
    "pipeline" => function(ServiceContainer $container){
        $pipeLine = new MiddlewareStack();
        $authMiddleware = new AuthorizationMiddleware(["/"], $container->get("authService"), "/login");
        $dispatcherMiddleware = new DispatchingMiddleware($container->get("dispatcher"), $container->get("responseFactory"));
        $pipeLine->addMiddleware($authMiddleware);
        $pipeLine->addMiddleware($dispatcherMiddleware); // This is last in stack
        return $pipeLine;
    },
    "baseUrl" => function(){
        $protocol = strpos($_SERVER["SERVER_PROTOCOL"], "https") === 0 ? 'https://' : 'http://';
        return $protocol.$_SERVER["HTTP_HOST"];
    },
    "forgotPasswordService" => function(ServiceContainer $container){
        return new ForgotPasswordService($container->get("connection"), $container->get("mailer"), $container->get("baseUrl"));
    },
    "dispatcher" => function(ServiceContainer $container){
        $dispatcher = new Dispatcher($container,'notFoundController@handle');

        $dispatcher->addRoute('/', 'homeController@handle');
        $dispatcher->addRoute('/image/(?<id>[\d]+)', 'singleImageController@display');
        $dispatcher->addRoute('/image/(?<id>[\d]+)/edit', 'singleImageEditController@edit', 'POST');
        $dispatcher->addRoute('/image/(?<id>[\d]+)/delete', 'singleImageDeleteController@delete', 'POST');
        $dispatcher->addRoute('/login', 'loginFormController@show');
        $dispatcher->addRoute('/logout', 'logoutSubmitController@submit');
        $dispatcher->addRoute('/login', 'loginSubmitController@submit','POST');
        $dispatcher->addRoute('/register', 'registerFormController@show');
        $dispatcher->addRoute('/register', 'registerSubmitController@submit','POST');
        $dispatcher->addRoute('/forgotpass', 'forgotPasswordController@show');
        $dispatcher->addRoute('/forgotpass', 'forgotPasswordSubmitController@submit','POST');
        $dispatcher->addRoute('/reset', 'passwordResetController@show');
        $dispatcher->addRoute('/reset', 'passwordResetSubmitController@submit','POST');

        return $dispatcher;
    }
];