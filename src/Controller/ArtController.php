<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Controller;

use Controller\Form\ArtType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Wbits\Kxb\Gallery\Application\ArtService;

final class ArtController
{
    private $artService;
    private $formFactory;

    public function __construct(ArtService $artService, FormFactory $formFactory)
    {
        $this->artService = $artService;
        $this->formFactory = $formFactory;
    }

    public function createPieceOfArtAction(Request $request)
    {
        $form = $this->formFactory->create(ArtType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $id = $this->artService->createArtPiece();
            return new RedirectResponse(sprintf('/admin/art/%s', $id));
        }

        // display the form
        return $app['twig']->render('index.twig', array('form' => $form->createView()));
    }
}
