<?php

declare(strict_types = 1);

namespace unit\Wbits\Kxb\Gallery\Domain;

use PHPUnit\Framework\TestCase;
use Wbits\Kxb\Gallery\Domain\FullName;

final class FullNameTest extends TestCase
{
    public function testItSeparatesFirstNameAndLastNameWithASpace()
    {
        self::assertEquals('Foo Bar', (string)new FullName('Foo', 'Bar'));
    }

    public function testItAcceptsALastNameOnlyAndTrims()
    {
        self::assertEquals('Foo', (string)new FullName('', 'Foo'));
        self::assertEquals('Foo', (string)new FullName(' ', 'Foo'));
    }

    public function testItValidatesLastNameOnBeingRequired()
    {
        $this->expectException(\InvalidArgumentException::class);
        new FullName('foo', '');
    }
}

