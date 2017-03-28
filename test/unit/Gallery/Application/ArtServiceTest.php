<?php

declare(strict_types = 1);

namespace unit\Wbits\Kxb\Gallery\Application;

use PHPUnit\Framework\TestCase;
use Wbits\Kxb\Gallery\Application\ArtService;
use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\ArtPiece;
use Wbits\Kxb\Gallery\Domain\ArtPieceDetails;
use Wbits\Kxb\Gallery\Domain\ArtPieceId;
use Wbits\Kxb\Gallery\Domain\Availability;
use Wbits\Kxb\Gallery\Domain\CreatedInYear;
use Wbits\Kxb\Gallery\Domain\Dimensions;
use Wbits\Kxb\Gallery\Domain\FullName;
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

    protected function setUp()
    {
        $this->artService = new ArtService(new InMemoryArtRepository());
    }

    public function testItDoesNotReturnAnyArtPiecesWhenNoneWereCreated()
    {
        $works = $this->artService->getAllPieces();
        static::assertEmpty($works);
    }

    public function testItReturnsACollectionOfArtPieces()
    {
        $this->createArtPiece();
        $works = $this->artService->getAllPieces();
        static::assertCount(1, $works);
    }

    public function testItCanFetchAnArtPieceById()
    {
        $this->createArtPiece();
        $id = new ArtPieceId('1');
        $work = $this->artService->getPiece($id);
        self::assertInstanceOf(ArtPiece::class, $work);
    }

    public function testItThrowsAnInvalidArgumentExceptionWhenItCouldNotFindAnArtPieceWithGivenId()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->artService->getPiece(new ArtPieceId(self::NON_EXISTING_ART_PIECE_ID));
    }

    private function createArtPiece()
    {
        $title = new Title('title');
        $details = new ArtPieceDetails(
            new Material('paint on canvas'),
            new Dimensions('60 cm', '50 cm'),
            new CreatedInYear(new \DateTimeImmutable('2015'))
        );
        $availability = new Availability(100);
        $price = new Price(1200.50);
        $artistId = new ArtistId('1');

        $this->artService->createArtPiece($title, $details, $availability, $price, $artistId);
    }
}
