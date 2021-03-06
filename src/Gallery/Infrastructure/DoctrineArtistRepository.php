<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Infrastructure;

use Ramsey\Uuid\Uuid;
use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\ArtistRepository;

final class DoctrineArtistRepository implements ArtistRepository
{
    private $dbal;
    private $serializer;

    public function __construct(DbalRepository $dbalRepository, ArtistSerializer $serializer)
    {
        $this->dbal = $dbalRepository;
        $this->serializer = $serializer;
    }

    public function getNextIdentifier(): ArtistId
    {
        $uuid = Uuid::uuid4();

        return new ArtistId((string) $uuid);
    }

    public function get(ArtistId $artistId): Artist
    {
        $result = $this->dbal->fetchById((string) $artistId);
        if (!$result) {
            throw new \InvalidArgumentException('Artist was not found');
        }

        return $this->serializer->deserialize($result['doc']);
    }

    /**
     * @return array|Artist[]
     */
    public function getAll(): array
    {
        $list = $this->dbal->fetchAll();

        return array_map(function ($item) {
            return $this->serializer->deserialize($item['doc']);
        }, $list);
    }

    public function save(Artist $artist): void
    {
        $json = $this->serializer->serialize($artist);
        $this->dbal->upsert((string) $artist->getId(), $json);
    }
}
