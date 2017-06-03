<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Admin\Controller;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Wbits\Kxb\Admin\Controller\Dto\ArtForm;
use Wbits\Kxb\Admin\Controller\Form\ArtType;
use Wbits\Kxb\Gallery\Application\ArtistService;
use Wbits\Kxb\Gallery\Application\ArtService;
use Wbits\Kxb\Gallery\Domain\Art;
use Wbits\Kxb\Gallery\Domain\ArtId;

final class ArtController
{
    private $artService;
    private $artistService;
    private $formFactory;
    private $twig;

    public function __construct(
        ArtService $artService,
        ArtistService $artistService,
        FormFactory $formFactory,
        \Twig_Environment $twig
    ) {
        $this->artService = $artService;
        $this->artistService = $artistService;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
    }

    public function getArtAction($id)
    {
        $artPiece = $this->artService->getArt(new ArtId($id));
        $artDto = new Dto\Art($artPiece);

        return new JsonResponse($artDto->toArray());
    }

    public function getArtListAction()
    {
        $list = $this->artService->getAllArt();
        $createArtDto = function (Art $art) {
            $artDto = new Dto\Art($art);

            return $artDto->toArray();
        };

        return $this->twig->render('admin/art/list.html.twig', ['list' => array_map($createArtDto, $list)]);
    }

    public function createArtFormAction()
    {
        $form = $this->createArtForm();

        return $this->twig->render('admin/art/create.html.twig', ['form' => $form->createView()]);
    }

    public function saveArtAction(Request $request)
    {
        $form = $this->createArtForm();
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return new RedirectResponse('admin/art/create', ['form' => $form->createView()]);
        }

        $data = $form->getData();
        $id = (string) $this->artService->createArt(
            $data->title(),
            $data->details(),
            $data->availability(),
            $data->price(),
            $data->artistId()
        );

        return new RedirectResponse(sprintf('/admin/art/%s', $id));
    }

    private function createArtForm(): FormInterface
    {
        $artists = $this->artistService->getAllArtists();

        return $this->formFactory->create(ArtType::class, new ArtForm($artists));
    }
}
