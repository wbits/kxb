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
use Wbits\Kxb\Admin\Controller\ArtistController;
use Wbits\Kxb\Gallery\Application\ArtistService;
use Wbits\Kxb\Gallery\Infrastructure\ArtistSerializer;
use Wbits\Kxb\Gallery\Infrastructure\DbalRepository;
use Wbits\Kxb\Gallery\Infrastructure\DoctrineArtistRepository;

final class ArtistControllerProvider implements ControllerProviderInterface, ServiceProviderInterface, EventListenerProviderInterface, BootableProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['artistController'] = function (Container $pimple) {
            return new ArtistController(
                $pimple['artistService'],
                $pimple['form.factory'],
                $pimple['twig']
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

        $controllers->post('artists/add', 'artistController:saveArtistAction');
        $controllers->get('artists/add', 'artistController:addArtistFormAction');
        $controllers->get('artists', 'artistController:getArtistListAction');

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
