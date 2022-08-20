<?php

use Controllers\Auth\LoginFormController;
use Controllers\Auth\LoginSubmitController;
use Controllers\Auth\LogoutSubmitController;
use Controllers\ForgotPassword\ForgotPasswordController;
use Controllers\ForgotPassword\ForgotPasswordSubmitController;
use Controllers\ForgotPassword\PasswordResetController;
use Controllers\ForgotPassword\PasswordResetSubmitController;
use Controllers\Image\HomeController;
use Controllers\Image\ImageCreateFormController;
use Controllers\Image\ImageCreateSubmitController;
use Controllers\Image\ImageServeController;
use Controllers\Image\SingleImageController;
use Controllers\Image\SingleImageDeleteController;
use Controllers\Image\SingleImageEditController;
use Controllers\Locale\LocaleChangeController;
use Controllers\NotFoundController;
use Exception\SqlException;
//use Laminas\I18n\Translator\Loader\Gettext;
use Laminas\I18n\Translator\Loader\PhpArray;
use Laminas\I18n\Translator\Translator;
use Middleware\AuthorizationMiddleware;
use Middleware\CsrfMiddleware;
use Middleware\DispatchingMiddleware;
use Middleware\FlashMessageCleanupMiddleware;
use Middleware\LocalizationMiddleware;
use Middleware\MiddlewareStack;
use Request\RequestFactory;
use Response\ResponseEmitter;
use Response\ResponseFactory;
use Services\AuthService;
use Services\ForgotPasswordService;
use Services\PhotoService;
use Session\SessionFactory;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Validation\Validator;

return [
    "translator" => function(ServiceContainer $container){
        $translator =  new Translator();
        $baseDir = $container->get("basePath"). "/i18n/";
        //$pattern = "%s/LC_MESSAGES/messages.mo";
        //$translator->addTranslationFilePattern(Gettext::class, $baseDir, $pattern, "messages");
        $pattern = "%s/messages.php";
        $translator->addTranslationFilePattern(PhpArray::class, $baseDir, $pattern, "messages");
        return $translator;
    },
    "responseFactory" => function(ServiceContainer $container){
        return new ResponseFactory($container->get("viewRenderer"));
    },
    "viewRenderer" => function(ServiceContainer $container){
        return new ViewRenderer($container->get("basePath"), $container->get("csrf"), $container->get("translator"));
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
    "validator" => function(){
        return new Validator();
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
    "imageServeController" => function(ServiceContainer $container){
        return new ImageServeController($container->get("basePath"));
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
    "localeChangeController" => function(ServiceContainer $container){
        return new LocaleChangeController($container->get("request"), $container->get("config")["available_locales"]);
    },
    "passwordResetSubmitController" => function(ServiceContainer $container){
        return new PasswordResetSubmitController($container->get("request"), $container->get("forgotPasswordService"));
    },
    "notFoundController" => function(){
        return new NotFoundController();
    },
    "imageCreateFormController" => function(ServiceContainer $container){
        return new ImageCreateFormController($container->get("session"));
    },
    "imageCreateSubmitController" => function(ServiceContainer $container){
        return new ImageCreateSubmitController($container->get("basePath"), $container->get("request"),
            $container->get("photoService"), $container->get("validator"));
    },
    "session" => function(ServiceContainer $container){
        $sessionConfig = $container->get("config")["session"];
        return SessionFactory::build($sessionConfig["driver"], $sessionConfig["config"]);
    },
    "request" => function(ServiceContainer $container){
        return RequestFactory::createFromGlobals($container);
    },
    "mailer" => function(ServiceContainer $container){
        $mailerConfig = $container->get("config")["mail"];
        $transport = (new Swift_SmtpTransport($mailerConfig["host"], $mailerConfig["port"]))
            ->setUsername($mailerConfig["username"])
            ->setPassword($mailerConfig["password"]);
        return new Swift_Mailer($transport);
    },
    "csrf" => function(ServiceContainer $container){
        return new CsrfTokenManager(new UriSafeTokenGenerator(), $container->get("session"));
    },
    "pipeline" => function(ServiceContainer $container){
        $config =  $container->get("config");
        $pipeLine = new MiddlewareStack();
        $authMiddleware = new AuthorizationMiddleware(["^/$", "^/image/[0-9]+$", "^/private/[a-z\.0-9]+"], $container->get("authService"), "/login");
        $dispatcherMiddleware = new DispatchingMiddleware($container->get("dispatcher"), $container->get("responseFactory"));
        $pipeLine->addMiddleware(new CsrfMiddleware($container->get("csrf")));
        $pipeLine->addMiddleware($authMiddleware);
        $pipeLine->addMiddleware(new FlashMessageCleanupMiddleware());
        $pipeLine->addMiddleware(new LocalizationMiddleware($config["default_locale"], $config["available_locales"]));
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
        $dispatcher->addRoute('/private/(?<id>[a-z\.0-9]+)', 'imageServeController@show');

        $dispatcher->addRoute('/login', 'loginFormController@show');
        $dispatcher->addRoute('/logout', 'logoutSubmitController@submit');
        $dispatcher->addRoute('/login', 'loginSubmitController@submit','POST');

        $dispatcher->addRoute('/register', 'registerFormController@show');
        $dispatcher->addRoute('/register', 'registerSubmitController@submit','POST');

        $dispatcher->addRoute('/forgotpass', 'forgotPasswordController@show');
        $dispatcher->addRoute('/forgotpass', 'forgotPasswordSubmitController@submit','POST');
        $dispatcher->addRoute('/reset', 'passwordResetController@show');
        $dispatcher->addRoute('/reset', 'passwordResetSubmitController@submit','POST');

        $dispatcher->addRoute('/image/add', 'imageCreateFormController@show');
        $dispatcher->addRoute('/image/add', 'imageCreateSubmitController@submit','POST');

        $dispatcher->addRoute('/locale/(?<locale>[a-z_A-Z]+)', 'localeChangeController@change');

        return $dispatcher;
    }
];