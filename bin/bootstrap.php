<?php
require_once __DIR__ . '/../vendor/autoload.php';

class MyApplication extends Silex\Application {
    use Silex\Application\SecurityTrait;
}

$app = new MyApplication();

// Services required by commands
/**
 * CONSOLE
 */
$app->register(new Knp\Provider\ConsoleServiceProvider(), array(
    'console.name'              => 'silex2-base-propel',
    'console.version'           => '1.0.0',
    'console.project_directory' => __DIR__ . '/../'
));

/**
 * PROPEL
 */
$app->register(new Propel\Silex\PropelServiceProvider(), array(
    'propel.config_file' => __DIR__ . '/../propel/Config/config.php',
    'propel.model_path' => __DIR__ . '/../propel',
));

$app->register(new Silex\Provider\SecurityServiceProvider(), [
    'security.firewalls' => []
]);

// Commands 
require_once __DIR__ . '/../src/command/ManageUserCommand.php';

return $app;
