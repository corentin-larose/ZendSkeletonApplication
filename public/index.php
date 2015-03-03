<?php
call_user_func(function () {
    if (getenv('APPLICATION_ENV')) {
        define('APPLICATION_ENV', getenv('APPLICATION_ENV'));
    } else {
        define('APPLICATION_ENV', 'testing');
    }

    $locale = \Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    \Locale::setDefault($locale);

    /**
     * This makes our life easier when dealing with paths. Everything is relative
     * to the application root now.
     */
    chdir(dirname(__DIR__));

    // Decline static file requests back to the PHP built-in webserver
    if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
        return false;
    }

    // Setup autoloading
    require 'init_autoloader.php';

    $appConfig = include 'config/application.config.php';

    if (is_file('config/development.config.php')) {
        $appConfig = \Zend\Stdlib\ArrayUtils::merge(
            $appConfig,
            include 'config/development.config.php'
        );
    }

    // Run the application!
    Zend\Mvc\Application::init($appConfig)->run();
});
