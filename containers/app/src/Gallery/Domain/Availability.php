<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class Availability
{
    private $numberOfCopies;

    public function __construct(int $numberOfCopies)
    {
        $this->numberOfCopies = $numberOfCopies;
    }

    public function __toString(): string
    {
        return (string) $this->numberOfCopies;
    }
}
