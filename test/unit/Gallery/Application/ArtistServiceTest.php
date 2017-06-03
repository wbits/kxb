<?php

declare(strict_types=1);

namespace unit\Gallery\Application;

use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\FullName;
use Wbits\Kxb\Gallery\Infrastructure\InMemoryArtistRepository;
use PHPUnit\Framework\TestCase;
use Wbits\Kxb\Gallery\Application\ArtistService;

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
}

