<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Controller;

use Wbits\Kxb\Controller\Form\ArtType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Wbits\Kxb\Controller\Dto\CreateArtPieceRequest;
use Wbits\Kxb\Gallery\Application\ArtService;
use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\ArtPieceDetails;
use Wbits\Kxb\Gallery\Domain\ArtPieceId;
use Wbits\Kxb\Gallery\Domain\Availability;
use Wbits\Kxb\Gallery\Domain\CreatedInYear;
use Wbits\Kxb\Gallery\Domain\Dimensions;
use Wbits\Kxb\Gallery\Domain\FullName;
use Wbits\Kxb\Gallery\Domain\Material;
use Wbits\Kxb\Gallery\Domain\Price;
use Wbits\Kxb\Gallery\Domain\Title;

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
        $data = new CreateArtPieceRequest();
        $form = $this->formFactory->create(ArtType::class, $data);

        return $this->twig->render('createArtPieceForm.twig', ['form' => $form->createView()]);
    }

    public function saveArtPieceAction(Request $request)
    {
        $form = $this->formFactory->create(ArtType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $data = $form->getData();
            $title = new Title($data->getTitle());
            $details = new ArtPieceDetails(
                new Material($data->getTitle()),
                new Dimensions($data->getWidth(), $data->getHeight()),
                new CreatedInYear(new \DateTimeImmutable($data->getYear()))
            );
            $availability = new Availability((int)$data->getNumberOfCopies());
            $price = new Price((float)$data->getPrice());
            $artist = new Artist(new ArtistId('1'), new FullName('', $data->getArtist()));
            $id = (string)$this->artService->createArtPiece($title, $details, $availability, $price, $artist);

            return new RedirectResponse(sprintf('/admin/art/%s', $id));
        }

        return new RedirectResponse('admin/create_art_piece');
    }
}
