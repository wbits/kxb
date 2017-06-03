<?php

declare(strict_types=1);

namespace unit\Gallery\Application;

use Wbits\Kxb\Gallery\Infrastructure\InMemoryArtistRepository;
use PHPUnit\Framework\TestCase;
use Wbits\Kxb\Gallery\Application\ArtistService;

final class ArtistServiceTest extends TestCase
{
    public function testItReturnsAnEmptyListOfArtistsWhenNoArtistsWereCreated()
    {
        $artistService = new ArtistService(new InMemoryArtistRepository());
        $artistList = $artistService->getAllArtists();

        self::assertEmpty($artistList);
    }
}

