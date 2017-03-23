<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class WorkOfArt
{
    private $id;

    private function __construct(WorkOfArtId $id)
    {
        $this->id = $id;
    }

    public static function create(WorkOfArtId $id): WorkOfArt
    {
        return new self($id);
    }

    public function getId(): WorkOfArtId
    {
        return $this->id;
    }
}
