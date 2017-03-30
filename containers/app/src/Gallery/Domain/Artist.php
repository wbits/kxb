<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class Artist
{
    private $id;
    private $name;

    public function __construct(ArtistId $id, FullName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): ArtistId
    {
        return $this->id;
    }

    public function getFullName(): FullName
    {
        return $this->name;
    }
}
