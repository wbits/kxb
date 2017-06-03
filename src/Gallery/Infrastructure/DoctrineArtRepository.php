<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Infrastructure;

use Ramsey\Uuid\Uuid;
use Wbits\Kxb\Gallery\Domain\Art;
use Wbits\Kxb\Gallery\Domain\ArtId;
use Wbits\Kxb\Gallery\Domain\ArtRepository;

final class DoctrineArtRepository implements ArtRepository
{
    private $dbal;
    private $serializer;

    public function __construct(DbalRepository $dbalRepository, ArtSerializer $serializer)
    {
        $this->dbal = $dbalRepository;
        $this->serializer = $serializer;
    }

    public function getNextIdentifier(): ArtId
    {
        $uuid = Uuid::uuid4();

        return new ArtId((string) $uuid);
    }

    public function save(Art $art): void
    {
        $data = $this->serializer->serialize($art);
        $this->dbal->upsert((string) $art->getId(), $data);
    }

    public function get(ArtId $artId)
    {
        $result = $this->dbal->fetchById((string) $artId);

        return $this->serializer->deserialize($result['doc']);
    }

    /**
     * @return Art[]
     */
    public function getAll(): array
    {
        return array_map(function ($item) {
            return $this->serializer->deserialize($item['doc']);
        }, $this->dbal->fetchAll());
    }
}
