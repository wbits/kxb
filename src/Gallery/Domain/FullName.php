<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class FullName
{
    private $firstName;
    private $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }
}
