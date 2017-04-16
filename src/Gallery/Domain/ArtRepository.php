<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

interface ArtRepository
{
    public function getNextIdentifier(): ArtPieceId;

    public function save(ArtPiece $workOfArt);

    public function get(ArtPieceId $workOfArtId);

    /**
     * @return ArtPiece[]
     */
    public function getAll(): array;
}
