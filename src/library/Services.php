<?php

// ROUTING
$app->register(new Silex\Provider\RoutingServiceProvider());

// SESSION
$app->register(new Silex\Provider\SessionServiceProvider());

// FORMS
$app->register(new Silex\Provider\FormServiceProvider());

// VALIDATION
$app->register(new Silex\Provider\ValidatorServiceProvider());

// CSRF PROTECTION
$app->register(new Silex\Provider\CsrfServiceProvider());

/**
 * PROPEL
 */
$app->register(new Propel\Silex\PropelServiceProvider(), array(
    'propel.config_file' => project_dir . 'propel/Config/config.php',
    'propel.model_path' => project_dir . 'propel',
));

/**
 * TRANSLATE
 */
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'), // Set your default language here
));

$app->extend('translator', function($translator) {
    // Add your translation xlf files here (example: Polish translation)
    $translator->addResource('xliff', __DIR__ . '/../translation/pl.xlf', 'pl');
    return $translator;
});


/**
 * SECURITY / FIREWALL
 */
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'anonymous' => true,
            'pattern' => '^/admin',
            'form' => array(
                'login_path' => '/login',
                'check_path' => '/admin/login_check',
                'default_target_path' => '/admin'
            ),
            'logout' => array(
                'logout_path' => '/admin/logout',
                'invalidate_session' => true
            ),
            'users' => function() {
                return new UserProvider();
            }
        )
    )
));

