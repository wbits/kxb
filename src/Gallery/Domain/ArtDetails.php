<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class ArtDetails
{
    private $material;
    private $size;
    private $year;

    public function __construct(Material $material, Dimensions $dimensions, CreatedInYear $year)
    {
        $this->material = $material;
        $this->size = $dimensions;
        $this->year = $year;
    }

    public function getSize(): Dimensions
    {
        return $this->size;
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function getYear(): CreatedInYear
    {
        return $this->year;
    }
}
