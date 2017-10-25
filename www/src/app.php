<?php
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

$app->register(new FormServiceProvider());
$app->register(new LocaleServiceProvider());
$app->register(new TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
));
$app->register(new TwigServiceProvider(), array(
    'twig.path' => array(__DIR__.'/views')
));
$app->register(new ValidatorServiceProvider());

$app['upload_path'] = __DIR__.'/../upload/';
$app['debug'] = true;

return $app;
