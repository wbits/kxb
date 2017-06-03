<?php

declare(strict_types = 1);

namespace unit\Gallery\Application;

use PHPUnit\Framework\TestCase;
use Wbits\Kxb\Gallery\Application\ArtistService;
use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\FullName;
use Wbits\Kxb\Gallery\Infrastructure\InMemoryArtistRepository;

final class ArtistServiceTest extends TestCase
{
    /**
     * @var ArtistService
     */
    private $artistService;

    /**
     * @var InMemoryArtistRepository
     */
    private $repository;

    protected function setUp()
    {
        parent::setUp();

        $this->repository = new InMemoryArtistRepository();
        $this->artistService = new ArtistService($this->repository);
    }

    public function testItReturnsAnEmptyListOfArtistsWhenNoArtistsWereCreated()
    {
        $artistList = $this->artistService->getAllArtists();

        self::assertEmpty($artistList);
    }

    public function testItCanAddANewArtist()
    {
        $artistId = $this->artistService->addArtist(new FullName('John', 'Doe'));
        $artist = $this->repository->get($artistId);

        self::assertInstanceOf(Artist::class, $artist);
    }

    public function testItReturnsAListOfArtists()
    {
        $artist = new Artist(new ArtistId('1'), new FullName('John', 'Doe'));
        $this->repository->save($artist);

        $artistList = $this->artistService->getAllArtists();

        self::assertNotEmpty($artistList);
        foreach ($artistList as $artist) {
            self::assertInstanceOf(Artist::class, $artist);
        }
    }

    public function testItReturnsASingleArtistById()
    {
        $artistId = new ArtistId('1');
        $artist = new Artist($artistId, new FullName('John', 'Doe'));
        $this->repository->save($artist);

        $fetchedArtist = $this->artistService->getArtist($artistId);

        self::assertEquals($artist, $fetchedArtist);
    }
}
