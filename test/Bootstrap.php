<?php



// Composer autoloading
if (file_exists('./vendor/autoload.php')) {
    $loader = include './vendor/autoload.php';
}
$loader->add('UghAuthorizationTest', "./test/UghAuthorizationTest");
Zend\Mvc\Application::init(require './test/config/application.config.php');