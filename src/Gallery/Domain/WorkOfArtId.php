<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class WorkOfArtId
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return $this->id;
    }
}
