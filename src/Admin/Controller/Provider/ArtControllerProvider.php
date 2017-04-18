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
use Wbits\Kxb\Gallery\Application\ArtService;
use Wbits\Kxb\Gallery\Infrastructure\ArtSerializer;
use Wbits\Kxb\Gallery\Infrastructure\DbalRepository;
use Wbits\Kxb\Gallery\Infrastructure\DoctrineArtRepository;

final class ArtControllerProvider implements ControllerProviderInterface, ServiceProviderInterface, EventListenerProviderInterface, BootableProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['artController'] = function (Container $pimple) {
            return new ArtController($pimple['artService'], $pimple['form.factory'], $pimple['twig']);
        };

        $pimple['artService'] = function (Container $pimple) {
            return new ArtService(
                new DoctrineArtRepository(new DbalRepository($pimple['db'], 'art_piece'), new ArtSerializer())
            );
        };
    }

    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];
        $controllers->get('art/id/{id}', 'artController:showArtPieceAction');
        $controllers->post('art/create', 'artController:saveArtPieceAction');
        $controllers->get('art/create', 'artController:createArtPieceFormAction');

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
