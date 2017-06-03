<?php

declare(strict_types=1);

namespace Wbits\Kxb\Gallery\Infrastructure;

use Ramsey\Uuid\Uuid;
use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\ArtistRepository;

final class DoctrineArtistRepository implements ArtistRepository
{
    private $dbalRepository;
    private $serializer;

    public function __construct(DbalRepository $dbalRepository, ArtistSerializer $serializer)
    {
        $this->dbalRepository = $dbalRepository;
        $this->serializer = $serializer;
    }

    public function getNextIdentifier(): ArtistId
    {
        $uuid = Uuid::uuid4();

        return new ArtistId((string) $uuid);
    }

    public function get(ArtistId $artistId): Artist
    {
        $result = $this->dbalRepository->fetchById((string)$artistId);

        return $this->serializer->deserialize($result['doc']);
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

