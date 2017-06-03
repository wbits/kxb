<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

interface ArtRepository
{
    public function getNextIdentifier(): ArtId;

    public function save(Art $artPiece);

    public function get(ArtId $artPieceId);

    /**
     * @return Art[]
     */
    public function getAll(): array;
}
