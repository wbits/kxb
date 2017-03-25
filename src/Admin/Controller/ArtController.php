<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Admin\Controller;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Wbits\Kxb\Admin\Controller\Dto\CreateArtPieceFormData;
use Wbits\Kxb\Admin\Controller\Form\ArtType;
use Wbits\Kxb\Gallery\Application\ArtService;
use Wbits\Kxb\Gallery\Domain\ArtPieceId;

final class ArtController
{
    private $artService;
    private $formFactory;
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(ArtService $artService, FormFactory $formFactory, \Twig_Environment $twig)
    {
        $this->artService = $artService;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
    }

    public function showArtPieceAction($id)
    {
        $artPieceId = new ArtPieceId($id);
//        $artPiece = $this->artService->getPiece($artPieceId);

        return $this->twig->render('showArtPiece.twig', ['artPiece' => [
            'title' => 'foo',
            'material' => 'bar',
            'price' => 'EU 1 999,90',
        ]]);
    }

    public function createArtPieceFormAction()
    {
        $data = new CreateArtPieceFormData();
        $form = $this->formFactory->create(ArtType::class, $data);

        return $this->twig->render('createArtPieceForm.twig', ['form' => $form->createView()]);
    }

    public function saveArtPieceAction(Request $request)
    {
        $form = $this->formFactory->create(ArtType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return new RedirectResponse('admin/create_art_piece', ['form' => $form->createView()]);
        }

        $data = $form->getData();
        $id = (string) $this->artService->createArtPiece(
            $data->title(),
            $data->details(),
            $data->availability(),
            $data->price(),
            $data->artist()
        );

        return new RedirectResponse(sprintf('/admin/art/%s', $id));
    }
}
