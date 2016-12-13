<?php
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'application' . DIRECTORY_SEPARATOR);
define('PUB', ROOT . 'public' . DIRECTORY_SEPARATOR);
// load application config (error reporting etc.)
$config = require_once APP . 'config/config.php';
//require_once PUB . 'lib/Twig/Autoloader.php';
// load application class
require_once APP . 'core/application.php';
// start the application
$app = new Application($config);
$app->run();