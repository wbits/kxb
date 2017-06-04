<?php

declare(strict_types = 1);

namespace unit\Wbits\Kxb\Gallery\Application;

use PHPUnit\Framework\TestCase;
use Wbits\Kxb\Gallery\Application\ArtService;
use Wbits\Kxb\Gallery\Domain\Art;
use Wbits\Kxb\Gallery\Domain\ArtDetails;
use Wbits\Kxb\Gallery\Domain\ArtId;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\Availability;
use Wbits\Kxb\Gallery\Domain\CreatedInYear;
use Wbits\Kxb\Gallery\Domain\Dimensions;
use Wbits\Kxb\Gallery\Domain\Material;
use Wbits\Kxb\Gallery\Domain\Price;
use Wbits\Kxb\Gallery\Domain\Title;
use Wbits\Kxb\Gallery\Infrastructure\InMemoryArtRepository;

final class ArtServiceTest extends TestCase
{
    const NON_EXISTING_ART_PIECE_ID = '555';

    /**
     * @var ArtService
     */
    private $artService;

    /**
     * @var InMemoryArtRepository
     */
    private $repository;

    /**
     * @var ArtId
     */
    private $id;

    protected function setUp()
    {
        $this->repository = new InMemoryArtRepository();
        $this->artService = new ArtService($this->repository);
    }

    public function testItDoesNotReturnAnyArtPiecesWhenNoneWereCreated()
    {
        $works = $this->artService->getAllArt();
        self::assertEmpty($works);
    }

    public function testItReturnsACollectionOfArtPieces()
    {
        $this->createSomeArt();
        $works = $this->artService->getAllArt();
        self::assertCount(1, $works);
    }

    public function testItCanFetchAnArtPieceById()
    {
        $this->createSomeArt();
        $id = new ArtId('1');
        $work = $this->artService->getArt($id);
        self::assertInstanceOf(Art::class, $work);
    }

    public function testItThrowsAnInvalidArgumentExceptionWhenItCouldNotFindAnArtPieceWithGivenId()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->artService->getArt(new ArtId(self::NON_EXISTING_ART_PIECE_ID));
    }

    public function testItShouldUpdateTheTitle()
    {
        $this->createSomeArt();
        $newTitle = new Title('some new title');

        $this->artService->updateArtTitle($this->id, $newTitle);
        $updatedTopic = $this->artService->getArt($this->id);

        self::assertEquals($newTitle, $updatedTopic->getTitle());
    }

    private function createSomeArt()
    {
        $this->id = $this->repository->getNextIdentifier();
        $title = new Title('title');
        $details = new ArtDetails(
            new Material('paint on canvas'),
            new Dimensions('60 cm', '50 cm'),
            new CreatedInYear(new \DateTimeImmutable('2015'))
        );
        $availability = new Availability(100);
        $price = new Price(1200.50);
        $artistId = new ArtistId('1');

        $art = Art::create($this->id, $title, $details, $availability, $price, $artistId);

        $this->repository->save($art);
    }
}
