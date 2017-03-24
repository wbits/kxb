<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Application;

use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\Availability;
use Wbits\Kxb\Gallery\Domain\Price;
use Wbits\Kxb\Gallery\Domain\Title;
use Wbits\Kxb\Gallery\Domain\WorkOfArt;
use Wbits\Kxb\Gallery\Domain\WorkOfArtDetails;
use Wbits\Kxb\Gallery\Domain\WorkOfArtRepository;

final class WorkOfArtService
{
    private $repository;

    public function __construct(WorkOfArtRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllWorksOfArt(): array
    {
        return $this->repository->getAll();
    }

    public function createWorkOfArt(
        Title $title,
        WorkOfArtDetails $details,
        Availability $availability,
        Price $price,
        Artist $artist
    ) {
        $id = $this->repository->getNextIdentifier();
        $work = WorkOfArt::create($id, $title, $details, $availability, $price, $artist);
        $this->repository->save($work);
    }
}
