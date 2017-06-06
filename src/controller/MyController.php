<?php 
use Symfony\Component\HttpFoundation\Request;

$app->get('/', function(Request $request) use ($app) {
    $hello = 'Hello';
    return $app['twig']->render('view/My/example.html.twig',array(
        'hello' => $hello
    ));
})->bind('homepage');

$app->get('/admin', function (Request $request) use ($app) {
    return $app['twig']->render('view/My/admin.html.twig', array(

    ));
})->bind('admin');
