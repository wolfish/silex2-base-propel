<?php
/**
 * TWIG CONFIG
 */
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../',
    'twig.options' => array(
        // 'cache' => true,
        'strict_variables' => true,
        'debug' => $app['debug'],
        'autoescape' => 'html'
    )
));

$app->extend('twig', function ($twig, $app) {
    $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) {
        return sprintf('/%s', ltrim($asset, '/../'));
    }));

    $twig->addGlobal('monthArray', array(
        1 => $app->trans('January'),
        2 => $app->trans('February'),
        3 => $app->trans('March'),
        4 => $app->trans('April'),
        5 => $app->trans('May'),
        6 => $app->trans('June'),
        7 => $app->trans('July'),
        8 => $app->trans('August'),
        9 => $app->trans('September'),
        10 => $app->trans('October'),
        11 => $app->trans('November'),
        12 => $app->trans('December')
    ));

    $twig->addGlobal('srcDir', __DIR__ . '/../');

    return $twig;
});

$app['twig.loader.filesystem']->addPath(__DIR__ . '/../', 'src');
