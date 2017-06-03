<?php

declare(strict_types=1);

namespace Wbits\Kxb\Gallery\Application;

use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\ArtistRepository;
use Wbits\Kxb\Gallery\Domain\FullName;

final class ArtistService
{
    private $repository;

    public function __construct(ArtistRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllArtists(): array
    {
        return [];
    }

    public function addArtist(FullName $fullName): ArtistId
    {
        $id = $this->repository->getNextIdentifier();
        $artist = new Artist($id, $fullName);
        $this->repository->save($artist);

        return $id;
    }
}

