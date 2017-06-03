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

    public function save(Art $art)
    {
        $key = (string) $art->getId();
        $this->artCollection[$key] = $art;
    }

    public function get(ArtId $artId): Art
    {
        if (!array_key_exists((string) $artId, $this->artCollection)) {
            throw new \InvalidArgumentException('Not found');
        }

        return $this->artCollection[(string) $artId];
    }

    /**
     * @return Art[]
     */
    public function getAll(): array
    {
        return $this->artCollection;
    }
}
