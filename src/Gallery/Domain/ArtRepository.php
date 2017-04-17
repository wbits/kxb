<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

interface ArtRepository
{
    public function getNextIdentifier(): ArtPieceId;

    public function save(ArtPiece $artPiece);

    public function get(ArtPieceId $artPieceId);

    /**
     * @return ArtPiece[]
     */
    public function getAll(): array;
}
