<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Application;

use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtPiece;
use Wbits\Kxb\Gallery\Domain\ArtPieceDetails;
use Wbits\Kxb\Gallery\Domain\ArtPieceId;
use Wbits\Kxb\Gallery\Domain\ArtRepository;
use Wbits\Kxb\Gallery\Domain\Availability;
use Wbits\Kxb\Gallery\Domain\Price;
use Wbits\Kxb\Gallery\Domain\Title;

final class ArtService
{
    private $repository;

    public function __construct(ArtRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllPieces(): array
    {
        return $this->repository->getAll();
    }

    public function createArtPiece(
        Title $title,
        ArtPieceDetails $details,
        Availability $availability,
        Price $price,
        Artist $artist
    ) {
        $id = $this->repository->getNextIdentifier();
        $piece = ArtPiece::create($id, $title, $details, $availability, $price, $artist);
        $this->repository->save($piece);
    }

    public function getPiece(ArtPieceId $id)
    {
        return $this->repository->get($id);
    }
}
