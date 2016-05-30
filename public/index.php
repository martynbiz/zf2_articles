<?php

// ini_set ( "error_reporting", E_ALL & ~ E_DEPRECATED & ~E_USER_DEPRECATED  & ~ E_STRICT );

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Setup autoloading
require 'init_autoloader.php';

MartynBiz\Mongo\Connection::getInstance()->init(array(
    'db' => 'zf2_articles',
    // 'username' => 'myuser',
    // 'password' => '89dD7HH7di!89',
    'classmap' => array(
        'articles' => '\\Article\\Model\\Article',
    ),
));

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
