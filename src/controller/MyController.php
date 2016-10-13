<?php 
use Symfony\Component\HttpFoundation\Request;

$app->get('/', function(Request $request) use ($app){
    $hello = 'Hello';

    return $app['twig']->render('view/example.html.twig',array(
        'hello' => $hello
    ));
})->bind('homepage');
