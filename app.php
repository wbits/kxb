<?php

declare(strict_types=1);

use Silex\Provider\FormServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TranslationServiceProvider;

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new ServiceControllerServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider());

return $app;
