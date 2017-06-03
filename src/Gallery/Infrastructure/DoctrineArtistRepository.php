<?php

declare(strict_types=1);

namespace Gallery\Infrastructure;

use Ramsey\Uuid\Uuid;
use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\ArtistRepository;
use Wbits\Kxb\Gallery\Infrastructure\DbalRepository;

final class DoctrineArtistRepository implements ArtistRepository
{
    private $dbalRepository;

    public function __construct(DbalRepository $dbalRepository)
    {
        $this->dbalRepository = $dbalRepository;
    }

    public function getNextIdentifier(): ArtistId
    {
        $uuid = Uuid::uuid4();

        return new ArtistId((string) $uuid);
    }

    public function get(ArtistId $artistId): Artist
    {
        // TODO: Implement get() method.
    }

    /**
     * @return array|Artist[]
     */
    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    public function save(Artist $artist): void
    {
        // TODO: Implement save() method.
    }
}

