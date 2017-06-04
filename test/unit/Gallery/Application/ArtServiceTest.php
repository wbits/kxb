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
        $this->createArtPiece();
        $works = $this->artService->getAllArt();
        self::assertCount(1, $works);
    }

    public function testItCanFetchAnArtPieceById()
    {
        $this->createArtPiece();
        $id = new ArtId('1');
        $work = $this->artService->getArt($id);
        self::assertInstanceOf(Art::class, $work);
    }

    public function testItThrowsAnInvalidArgumentExceptionWhenItCouldNotFindAnArtPieceWithGivenId()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->artService->getArt(new ArtId(self::NON_EXISTING_ART_PIECE_ID));
    }

    private function createArtPiece()
    {
        $id = $this->repository->getNextIdentifier();
        $title = new Title('title');
        $details = new ArtDetails(
            new Material('paint on canvas'),
            new Dimensions('60 cm', '50 cm'),
            new CreatedInYear(new \DateTimeImmutable('2015'))
        );
        $availability = new Availability(100);
        $price = new Price(1200.50);
        $artistId = new ArtistId('1');

        $art = Art::create($id, $title, $details, $availability, $price, $artistId);

        $this->repository->save($art);
    }
}
