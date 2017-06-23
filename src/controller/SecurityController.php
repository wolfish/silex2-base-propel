<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;
use form\LoginForm;

function buildLoginForm($app) {
    return $app['form.factory']->createNamedBuilder(null, FormType::class)
        ->add('_username', TextType::class, array(
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Email()
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Email address'
            )
        ))
        ->add('_password', PasswordType::class, array(
            'constraints' => array(
                new Assert\NotBlank()
            ),
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Password'
            )
        ))
        ->add('submit', SubmitType::class, array(
            'label' => 'Sign in',
            'attr' => array(
                'class' => 'btn btn-lg btn-primary btn-block'
            )
        ))
        ->getForm();
}

$app->get('/login', function(Request $request) use ($app){
    $form = buildLoginForm($app);

    return $app['twig']->render('view/Security/login.html.twig',array(
        'form' => $form->createView(),
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username')
    ));
})->bind('login');

