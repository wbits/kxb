<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Controller;

use Controller\Form\ArtType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Wbits\Kxb\Controller\Dto\CreateArtPieceRequest;
use Wbits\Kxb\Gallery\Application\ArtService;
use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\ArtPieceDetails;
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

    public function createArtPieceAction(Request $request)
    {
        $form = $this->formFactory->create(ArtType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CreateArtPieceRequest $data */
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
            $id = $this->artService->createArtPiece($title, $details, $availability, $price, $artist);

            return new RedirectResponse(sprintf('/admin/art/%s', $id));
        }

        return $this->twig->render('createPieceOfArt.twig', ['form' => $form->createView()]);
    }
}
