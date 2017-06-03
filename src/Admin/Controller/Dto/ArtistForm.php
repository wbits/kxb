<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Admin\Controller\Dto;

use Wbits\Kxb\Gallery\Domain\FullName;

final class ArtistForm
{
    private $firstName;
    private $lastName;

    public function fullName(): FullName
    {
        return new FullName($this->firstName, $this->lastName);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): ArtistForm
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): ArtistForm
    {
        $this->lastName = $lastName;

        return $this;
    }
}
