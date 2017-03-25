<?php

declare(strict_types=1);

use Silex\Provider\FormServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new ServiceControllerServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider(), ['locale' => 'nl']);
$app->register(new TwigServiceProvider(), ['twig.path' => __DIR__ . '/app/views']);

return $app;
