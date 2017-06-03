<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

interface ArtRepository
{
    public function getNextIdentifier(): ArtId;

    public function save(Art $art);

    public function get(ArtId $artId);

    /**
     * @return Art[]
     */
    public function getAll(): array;
}
