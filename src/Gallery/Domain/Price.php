<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class Price
{
    private $price;

    public function __construct(float $price)
    {
        setlocale(LC_MONETARY, 'nl_NL'); // todo put somewhere globally
        $this->price = money_format('%i', $price);
    }

    public function __toString()
    {
        return $this->price;
    }
}

