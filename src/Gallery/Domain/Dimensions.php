<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class Dimensions
{
    private $width;
    private $height;

    public function __construct(string $width, string $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function __toString()
    {
        return sprintf('%s x %s', $this->width, $this->height);
    }
}
