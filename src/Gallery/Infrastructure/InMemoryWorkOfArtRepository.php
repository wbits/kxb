<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Infrastructure;

use Wbits\Kxb\Gallery\Domain\WorkOfArt;
use Wbits\Kxb\Gallery\Domain\WorkOfArtId;
use Wbits\Kxb\Gallery\Domain\WorkOfArtRepository;

final class InMemoryWorkOfArtRepository implements WorkOfArtRepository
{
    private $sequence = 0;
    private $artCollection = [];

    public function getNextIdentifier(): WorkOfArtId
    {
        ++$this->sequence;

        return new WorkOfArtId((string)$this->sequence);
    }

    public function save(WorkOfArt $workOfArt)
    {
        $key = (string)$workOfArt->getId();
        $this->artCollection[$key] = $workOfArt;
    }

    public function get(WorkOfArtId $workOfArtId): WorkOfArt
    {
        // TODO: Implement get() method.
    }

    /**
     * @return WorkOfArt[]
     */
    public function getAll(): array
    {
        return $this->artCollection;
    }
}

