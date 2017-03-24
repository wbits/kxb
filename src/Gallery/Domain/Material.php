<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class Material
{
    private $material;

    public function __construct(string $material)
    {
        $this->material = $material;
    }

    public function __toString()
    {
        return $this->material;
    }
}
