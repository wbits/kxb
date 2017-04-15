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

    public function save(ArtPiece $workOfArt)
    {
        $key = (string) $workOfArt->getId();
        $this->artCollection[$key] = $workOfArt;
    }

    public function get(ArtPieceId $workOfArtId): ArtPiece
    {
        if (!array_key_exists((string) $workOfArtId, $this->artCollection)) {
            throw new \InvalidArgumentException('Not found');
        }

        return $this->artCollection[(string) $workOfArtId];
    }

    /**
     * @return ArtPiece[]
     */
    public function getAll(): array
    {
        return $this->artCollection;
    }
}
