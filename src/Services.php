<?php

$app->register(new Silex\Provider\RoutingServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());

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
    'locale_fallbacks' => array('pl'),
));

$app->extend('translator', function($translator, $app) {
    $translator->addResource('xliff', __DIR__ . '/translation/pl.xlf', 'pl');
    return $translator;
});

/**
 * TWIG CONFIG
 */
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/',
    'twig.options' => array(
        // 'cache' => true,
        'strict_variables' => true,
        'debug' => $app['debug'],
        'autoescape' => 'html'
    )
));

$app->extend('twig', function ($twig, $app) {
    $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) {
        return sprintf('/%s', ltrim($asset, '/'));
    }));

    $twig->addGlobal('monthArray', array(
        1 => $app->trans('January'),
        2 => $app->trans('Luty'),
        3 => $app->trans('Marzec'),
        4 => $app->trans('Kwiecień'),
        5 => $app->trans('Maj'),
        6 => $app->trans('Czerwiec'),
        7 => $app->trans('Lipiec'),
        8 => $app->trans('Sieprień'),
        9 => $app->trans('Wrzesień'),
        10 => $app->trans('Październik'),
        11 => $app->trans('Listopad'),
        12 => $app->trans('Grudzień')
    ));
    
    $twig->addGlobal('srcDir', __DIR__ . '/');
    
    return $twig;
});

$app['twig.loader.filesystem']->addPath(__DIR__ . '/', 'src');

/**
 * FIREWALL / SECURITY
 */
// DEPRECATED, security methods from 1.3 - needs re-implementation
/*$get = MyUserTableQuery::create()->filterByIsActive(1)->find();
$users = array();

foreach ($get as $user) {
    $users[$user->getEmail()] = array(
        'ROLE_ADMIN',
        $user->getPassword()
    );
}

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'anonymous' => true,
            'pattern' => '^/',
            'form' => array(
                'login_path' => '/login',
                'check_path' => '/admin/login_check',
                'default_target_path' => '/'
            ),
            'logout' => array(
                'logoutPath' => '/logout',
                'invalidateSession' => true
            ),
            'users' => $users
        )
    )
));*/


/**
 * USER OBJECT
 */
// DEPRECATED, user methods from 1.3 - needs re-implementation
/*function getUser($token)
{
    if ($token !== null) {
        $user = $token->getUser();
    } else {
        die($app['debug'] ? 'Token auth failed: ' . print_r($token) : 'Fatal error');
    }
    
    $user = MyUserTableQuery::create()->findOneByEmail($user->getUsername());
    
    if (! $user instanceof ScAdmin) {
        die($app['debug'] ? 'User auth failed: ' . print_r($user) : 'Fatal error');
    }
    
    return $user;
}*/

?>
