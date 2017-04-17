<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Infrastructure;

use Wbits\Kxb\Gallery\Domain\ArtPiece;
use Wbits\Kxb\Gallery\Domain\ArtPieceId;
use Wbits\Kxb\Gallery\Domain\ArtRepository;

final class InMemoryArtRepository implements ArtRepository
{
    private $sequence = 0;
    private $artCollection = [];

    public function getNextIdentifier(): ArtPieceId
    {
        ++$this->sequence;

        return new ArtPieceId((string) $this->sequence);
    }

    public function save(ArtPiece $artPiece)
    {
        $key = (string) $artPiece->getId();
        $this->artCollection[$key] = $artPiece;
    }

    public function get(ArtPieceId $artPieceId): ArtPiece
    {
        if (!array_key_exists((string) $artPieceId, $this->artCollection)) {
            throw new \InvalidArgumentException('Not found');
        }

        return $this->artCollection[(string) $artPieceId];
    }

    /**
     * @return ArtPiece[]
     */
    public function getAll(): array
    {
        return $this->artCollection;
    }
}
