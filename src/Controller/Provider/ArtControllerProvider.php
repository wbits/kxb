<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Controller\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Api\ControllerProviderInterface;
use Silex\Api\EventListenerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Wbits\Kxb\Controller\ArtController;
use Wbits\Kxb\Gallery\Application\ArtService;
use Wbits\Kxb\Gallery\Infrastructure\InMemoryArtRepository;

final class ArtControllerProvider implements ControllerProviderInterface, ServiceProviderInterface, EventListenerProviderInterface, BootableProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['artController'] = function (Container $pimple) {
            return new ArtController($pimple['artService'], $pimple['form.factory'], $pimple['twig']);
        };

        $pimple['artService'] = function () {
            return new ArtService(new InMemoryArtRepository()); // todo replace inMemoryRepository
        };
    }

    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];
        $controllers->get('art/{id}', 'artController:showArtPieceAction');
        $controllers->post('create_art_piece', 'artController:saveArtPieceAction');
        $controllers->get('create_art_piece', 'artController:createArtPieceFormAction');

        return $controllers;
    }

    public function boot(Application $app)
    {
        $app->mount('/admin', $this);
    }

    public function subscribe(Container $app, EventDispatcherInterface $dispatcher)
    {
        // TODO: Implement subscribe() method.
    }
}

