<?php
require_once __DIR__ . '/../vendor/autoload.php';

class MyApplication extends Silex\Application {
    use Silex\Application\TranslationTrait;
}

$app = new MyApplication();

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

// Add global constants here (if a lot, move it to separate file)
const upload_dir = __DIR__ . '/uploads/';
const web_dir = __DIR__ . '/';
const project_dir = __DIR__ . '/../';

// services (propel, twig, translate, etc)
require_once __DIR__ . '/../src/library/UserProvider.php';
require_once __DIR__ . '/../src/library/Services.php';
$app->boot();

// additional libraries that require to be included AFTER boot() when services are ready
require_once __DIR__ . '/../src/library/Twig.php';

// Add your controllers here!
require_once __DIR__ . '/../src/controller/SecurityController.php';
require_once __DIR__ . '/../src/controller/MyController.php';

$app->run();
