<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Application;

use Wbits\Kxb\Gallery\Domain\Art;
use Wbits\Kxb\Gallery\Domain\ArtDetails;
use Wbits\Kxb\Gallery\Domain\ArtId;
use Wbits\Kxb\Gallery\Domain\ArtistId;
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

    public function getAllArt(): array
    {
        return $this->repository->getAll();
    }

    public function createArt(
        Title $title,
        ArtDetails $details,
        Availability $availability,
        Price $price,
        ArtistId $artistId
    ): ArtId {
        $id = $this->repository->getNextIdentifier();
        $piece = Art::create($id, $title, $details, $availability, $price, $artistId);
        $this->repository->save($piece);

        return $piece->getId();
    }

    public function getArt(ArtId $id): Art
    {
        return $this->repository->get($id);
    }
}
