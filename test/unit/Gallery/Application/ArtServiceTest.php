<?php

declare(strict_types = 1);

namespace unit\Wbits\Kxb\Gallery\Application;

use PHPUnit\Framework\TestCase;
use Wbits\Kxb\Gallery\Application\ArtService;
use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\ArtPiece;
use Wbits\Kxb\Gallery\Domain\Availability;
use Wbits\Kxb\Gallery\Domain\CreatedInYear;
use Wbits\Kxb\Gallery\Domain\Dimensions;
use Wbits\Kxb\Gallery\Domain\FullName;
use Wbits\Kxb\Gallery\Domain\Material;
use Wbits\Kxb\Gallery\Domain\Price;
use Wbits\Kxb\Gallery\Domain\Title;
use Wbits\Kxb\Gallery\Domain\ArtPieceDetails;
use Wbits\Kxb\Gallery\Domain\ArtPieceId;
use Wbits\Kxb\Gallery\Infrastructure\InMemoryArtRepository;

final class ArtServiceTest extends TestCase
{
    const NON_EXISTING_WORK_ID = '555';

    /**
     * @var ArtService
     */
    private $artService;

    protected function setUp()
    {
        $this->artService = new ArtService(new InMemoryArtRepository());
    }

    public function testItDoesNotReturnAnyWorksOfArtWhenNoneWereCreated()
    {
        $works = $this->artService->getAllWorks();
        static::assertEmpty($works);
    }

    public function testItReturnsACollectionOfWorksWhen()
    {
        $this->createWorkOfArt();
        $works = $this->artService->getAllWorks();
        static::assertCount(1, $works);
    }

    public function testItCanFetchAWorkOfArtById()
    {
        $this->createWorkOfArt();
        $id = new ArtPieceId('1');
        $work = $this->artService->getWork($id);
        self::assertInstanceOf(ArtPiece::class, $work);
    }

    public function testItThrowsAnInvalidArgumentExceptionWhenItCouldNotFind()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->artService->getWork(new ArtPieceId(self::NON_EXISTING_WORK_ID));
    }

    private function createWorkOfArt()
    {
        $title = new Title('title');
        $details = new ArtPieceDetails(
            new Material('paint on canvas'),
            new Dimensions('60 cm', '50 cm'),
            new CreatedInYear(new \DateTimeImmutable('2015'))
        );
        $availability = new Availability(100);
        $price = new Price(1200.50);
        $artist = new Artist(
            new ArtistId('1'),
            new FullName('Vincent', 'van Gogh')
        );

        $this->artService->createWorkOfArt($title, $details, $availability, $price, $artist);
    }
}
