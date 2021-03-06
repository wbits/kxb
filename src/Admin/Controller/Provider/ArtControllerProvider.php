<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Admin\Controller\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Api\ControllerProviderInterface;
use Silex\Api\EventListenerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Wbits\Kxb\Admin\Controller\ArtController;
use Wbits\Kxb\Gallery\Application\ArtistService;
use Wbits\Kxb\Gallery\Application\ArtService;
use Wbits\Kxb\Gallery\Infrastructure\ArtistSerializer;
use Wbits\Kxb\Gallery\Infrastructure\ArtSerializer;
use Wbits\Kxb\Gallery\Infrastructure\DbalRepository;
use Wbits\Kxb\Gallery\Infrastructure\DoctrineArtistRepository;
use Wbits\Kxb\Gallery\Infrastructure\DoctrineArtRepository;

final class ArtControllerProvider implements ControllerProviderInterface, ServiceProviderInterface, EventListenerProviderInterface, BootableProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['artController'] = function (Container $pimple) {
            return new ArtController(
                $pimple['artService'],
                $pimple['artistService'],
                $pimple['form.factory'],
                $pimple['twig']
            );
        };

        $pimple['artService'] = function (Container $pimple) {
            return new ArtService(
                new DoctrineArtRepository(new DbalRepository($pimple['db'], 'art_piece'), new ArtSerializer())
            );
        };

        $pimple['artistService'] = function (Container $pimple) {
            return new ArtistService(
                new DoctrineArtistRepository(new DbalRepository($pimple['db'], 'artist'), new ArtistSerializer())
            );
        };
    }

    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->post('art/create', 'artController:saveArtAction');
        $controllers->get('art/create', 'artController:createArtFormAction');
        $controllers->get('art/{id}', 'artController:getArtAction');
        $controllers->get('art', 'artController:getArtListAction');

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
