<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class WorkOfArtDetails
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

    public function toArray()
    {
        return [
            'material' => $this->material,
            'size' => $this->size,
            'year' => $this->year,
        ];
    }
}
