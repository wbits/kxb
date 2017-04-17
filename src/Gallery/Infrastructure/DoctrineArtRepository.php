<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Infrastructure;

use Ramsey\Uuid\Uuid;
use Wbits\Kxb\Gallery\Domain\ArtPiece;
use Wbits\Kxb\Gallery\Domain\ArtPieceId;
use Wbits\Kxb\Gallery\Domain\ArtRepository;

final class DoctrineArtRepository implements ArtRepository
{
    private $dbalRepository;
    private $serializer;

    public function __construct(DbalRepository $dbalRepository, ArtSerializer $serializer)
    {
        $this->dbalRepository = $dbalRepository;
        $this->serializer = $serializer;
    }

    public function getNextIdentifier(): ArtPieceId
    {
        $uuid = Uuid::uuid4();

        return new ArtPieceId((string) $uuid);
    }

    public function save(ArtPiece $workOfArt): void
    {
        $data = $this->serializer->serialize($workOfArt);
        $this->dbalRepository->upsert((string) $workOfArt->getId(), $data);
    }

    public function get(ArtPieceId $workOfArtId)
    {
        $result = $this->dbalRepository->fetchById((string) $workOfArtId);

        return $this->serializer->deserialize($result['doc']);
    }

    /**
     * @return ArtPiece[]
     */
    public function getAll(): array
    {
        return [];
        $result = [];
        $pieces = $this->conn->fetchAll('SELECT * FROM art_piece');

        foreach ($pieces as $piece) {
            $result[] = $this->fromArray(new ArtPieceId($piece['id']), json_decode($piece['doc'], true));
        }

        return $result;
    }
}
