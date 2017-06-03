<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Admin\Controller;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Wbits\Kxb\Admin\Controller\Dto\ArtistForm;
use Wbits\Kxb\Admin\Controller\Form\ArtistType;
use Wbits\Kxb\Gallery\Application\ArtistService;

final class ArtistController
{
    private $artistService;
    private $formFactory;
    private $twig;

    public function __construct(ArtistService $artistService, FormFactory $formFactory, \Twig_Environment $twig)
    {
        $this->artistService = $artistService;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
    }

    public function addArtistFormAction()
    {
        $form = $this->createArtistForm();

        return $this->twig->render('admin/artist/add.html.twig', ['form' => $form->createView()]);
    }

    public function saveArtistAction(Request $request)
    {
        $form = $this->createArtistForm();
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return new RedirectResponse('admin/artists/add', ['form' => $form->createView()]);
        }

        $data = $form->getData();
        $id = (string) $this->artistService->addArtist($data->fullName());

        return new RedirectResponse(sprintf('/admin/art/create', $id));
    }

    private function createArtistForm(): FormInterface
    {
        return $this->formFactory->create(ArtistType::class, new ArtistForm());
    }
}
