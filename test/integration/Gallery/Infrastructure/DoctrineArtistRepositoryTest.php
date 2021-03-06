<?php

declare(strict_types = 1);

namespace integration\Gallery\Infrastructure;

use Doctrine\DBAL\DriverManager;
use integration\Wbits\Kxb\DatabaseTestCase;
use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\FullName;
use Wbits\Kxb\Gallery\Infrastructure\ArtistSerializer;
use Wbits\Kxb\Gallery\Infrastructure\DbalRepository;
use Wbits\Kxb\Gallery\Infrastructure\DoctrineArtistRepository;

final class DoctrineArtistRepositoryTest extends DatabaseTestCase
{
    const TEST_ARTIST_UUID = 'fbca3048-ad2d-4581-81f1-e84048636826';

    /**
     * @var DbalRepository
     */
    private $dbalRepository;

    /**
     * @var DoctrineArtistRepository
     */
    private $repository;

    protected function setUp()
    {
        parent::setUp();

        $connectionParams = [
            'driver' => 'pdo_pgsql',
            'user' => self::DB_USER,
            'password' => self::DB_PASS,
            'dbname' => self::DB_NAME,
            'host' => self::HOST,
            'port' => '5432',
        ];

        $this->dbalRepository = new DbalRepository(DriverManager::getConnection($connectionParams), 'artist');
        $this->repository = new DoctrineArtistRepository($this->dbalRepository, new ArtistSerializer());
    }

    public function testItCanFetchAnArtistById()
    {
        $artistId = new ArtistId(self::TEST_ARTIST_UUID);

        $artist = $this->repository->get($artistId);

        self::assertInstanceOf(Artist::class, $artist);
        self::assertEquals($artistId, $artist->getId());
    }

    public function testItFetchesAllArtists()
    {
        $artists = $this->repository->getAll();

        self::assertNotEmpty($artists);
        foreach ($artists as $artist) {
            self::assertInstanceOf(Artist::class, $artist);
        }
    }

    public function testItCanSaveAnArtist()
    {
        $id = $this->repository->getNextIdentifier();
        $artist = new Artist($id, new FullName('Jack', 'FooBar'));

        $this->repository->save($artist);
        $fetchedArtist = $this->repository->get($id);

        self::assertEquals($artist, $fetchedArtist);
    }

    protected function getDataSet()
    {
        return $this->createXmlDataSet(__DIR__ . '/../../fixture.xml');
    }
}
