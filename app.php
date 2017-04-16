<?php

declare(strict_types = 1);

use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Wbits\Kxb\Admin\Controller\Provider\ArtControllerProvider;

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new ServiceControllerServiceProvider());
$app->register(new DoctrineServiceProvider(), array(
    'db.options' => [
        'driver' => 'pdo_pgsql',
        'user' => 'kxbusr',
        'password' => 'kxbpss',
        'dbname' => 'kxb',
        'host' => '192.168.99.100',
        'port' => '5432',
    ],
));
$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider(), ['locale' => 'nl']);
$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/app/Resources/views',
    'twig.form.templates' => [
        'bootstrap_3_layout.html.twig',
        'bootstrap_3_horizontal_layout.html.twig',
    ],
]);
$app->register(new Silex\Provider\AssetServiceProvider(), [
    'assets.version' => 'v1',
    'assets.named_packages' => [
        'css' => [
            'version' => 'css3',
            'base_path' => __DIR__ . '/app/Resources/css',
        ],
    ],
]);
$app->register(new ArtControllerProvider());

return $app;
