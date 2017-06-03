<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

interface ArtistRepository
{
    public function getNextIdentifier(): ArtistId;

    public function get(ArtistId $artistId): Artist;

    /**
     * @return array|Artist[]
     */
    public function getAll(): array;

    public function save(Artist $artist): void;
}
