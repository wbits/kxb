<?php

declare(strict_types = 1);

namespace integration\Wbits\Kxb\Gallery\Infrastructure;

use Doctrine\DBAL\DriverManager;
use integration\Wbits\Kxb\DatabaseTestCase;
use Ramsey\Uuid\Uuid;
use Wbits\Kxb\Gallery\Infrastructure\DbalRepository;

final class DbalRepositoryTest extends DatabaseTestCase
{
    const TEST_ART_PIECE_UUID = '166bbf4b-d684-46a2-bad3-c696c2ede80a';
    const TEST_ARTIST_UUID = 'fbca3048-ad2d-4581-81f1-e84048636826';

    /**
     * @var DbalRepository
     */
    private $dbalRepository;

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

        $this->dbalRepository = new DbalRepository(DriverManager::getConnection($connectionParams), 'art_piece');
    }



    public function testItFetchesARowById()
    {
        $result = $this->dbalRepository->fetchById(self::TEST_ART_PIECE_UUID);

        self::assertEquals(self::TEST_ART_PIECE_UUID, $result['id']);
    }

    public function testItReturnsFalseWhenTryingToFetchSomethingThatDoesNotExist()
    {
        $newUuid = Uuid::uuid4();
        $result = $this->dbalRepository->fetchById((string) $newUuid);

        self::assertFalse($result);
    }

    public function testItFetchesAList()
    {
        $results = $this->dbalRepository->fetchAll();

        self::assertEquals(1, count($results));
    }

    public function testItWillUpdateAnExistingRow()
    {
        $json = '{"foo": "bar"}';

        $this->dbalRepository->upsert(self::TEST_ART_PIECE_UUID, $json);
        $artPiece = $this->dbalRepository->fetchById(self::TEST_ART_PIECE_UUID);

        self::assertEquals($json, $artPiece['doc']);
    }

    public function testItWillInsertANewRow()
    {
        $json = '{"new": "doc"}';
        $newUuid = Uuid::uuid4();

        $this->dbalRepository->upsert((string) $newUuid, $json);
        $artPiece = $this->dbalRepository->fetchById((string) $newUuid);

        self::assertEquals($json, $artPiece['doc']);
    }

    protected function getDataSet()
    {
        return $this->createXmlDataSet(__DIR__ . '/../../fixture.xml');
    }
}
