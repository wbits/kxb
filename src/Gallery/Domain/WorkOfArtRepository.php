<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

interface WorkOfArtRepository
{
    public function getNextIdentifier(): WorkOfArtId;

    public function save(WorkOfArt $workOfArt);

    public function get(WorkOfArtId $workOfArtId): WorkOfArt;

    /**
     * @return WorkOfArt[]
     */
    public function getAll(): array;
}
