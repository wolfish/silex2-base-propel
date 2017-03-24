<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

// set debug mode
$app['debug'] = true;
if ($app['debug']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(null);
}

// Add global constants here (if a lot, move it to seperate file)
const upload_dir = __DIR__ . '/uploads/';
const web_dir = __DIR__ . '/';
const project_dir = __DIR__ . '/../';

// services (firewall, twig, user, etc)
require_once __DIR__ . '/../src/controller/Services.php';

// Add your controllers here!
require_once __DIR__ . '/../src/controller/MyController.php';

$app->run();
