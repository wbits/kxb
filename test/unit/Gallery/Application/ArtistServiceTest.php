<?php

declare(strict_types=1);

namespace unit\Gallery\Application;

use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Infrastructure\InMemoryArtistRepository;
use PHPUnit\Framework\TestCase;
use Wbits\Kxb\Gallery\Application\ArtistService;

final class ArtistServiceTest extends TestCase
{
    /**
     * @var ArtistService
     */
    private $artistService;

    protected function setUp()
    {
        parent::setUp();

        $this->artistService = new ArtistService(new InMemoryArtistRepository());
    }

    public function testItReturnsAnEmptyListOfArtistsWhenNoArtistsWereCreated()
    {
        $artistList = $this->artistService->getAllArtists();

        self::assertEmpty($artistList);
    }

    public function testItCanAddANewArtist()
    {
        $artist = $this->artistService->addArtist();

        self::assertInstanceOf(Artist::class, $artist);
    }
}

