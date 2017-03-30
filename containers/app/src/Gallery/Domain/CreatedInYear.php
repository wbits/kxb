<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class CreatedInYear
{
    private $year;

    public function __construct(\DateTimeImmutable $year)
    {
        $this->year = $year;
    }

    public function __toString()
    {
        return $this->year->format('Y');
    }
}
