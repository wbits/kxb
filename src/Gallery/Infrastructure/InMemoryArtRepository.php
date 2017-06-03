<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Infrastructure;

use Wbits\Kxb\Gallery\Domain\Art;
use Wbits\Kxb\Gallery\Domain\ArtId;
use Wbits\Kxb\Gallery\Domain\ArtRepository;

final class InMemoryArtRepository implements ArtRepository
{
    private $sequence = 0;
    private $artCollection = [];

    public function getNextIdentifier(): ArtId
    {
        ++$this->sequence;

        return new ArtId((string) $this->sequence);
    }

    public function save(Art $artPiece)
    {
        $key = (string) $artPiece->getId();
        $this->artCollection[$key] = $artPiece;
    }

    public function get(ArtId $artPieceId): Art
    {
        if (!array_key_exists((string) $artPieceId, $this->artCollection)) {
            throw new \InvalidArgumentException('Not found');
        }

        return $this->artCollection[(string) $artPieceId];
    }

    /**
     * @return Art[]
     */
    public function getAll(): array
    {
        return $this->artCollection;
    }
}
