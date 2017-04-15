<?php

declare(strict_types = 1);

namespace unit\Wbits\Kxb\Gallery\Domain;

use PHPUnit\Framework\TestCase;
use Wbits\Kxb\Gallery\Domain\Price;

final class PriceTestDisabled extends TestCase
{
    public function testItWillConvertAFloatToMoneyFormattedStringUsingDutchLocale()
    {
//        self::assertEquals('EUR 5 600,75', (string) new Price(5600.75));
    }
}
