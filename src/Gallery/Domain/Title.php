<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class Title
{
    private $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function __toString()
    {
        return $this->title;
    }
}
