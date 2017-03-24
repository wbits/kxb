<?php

declare(strict_types = 1);

namespace unit\Wbits\Kxb\Gallery\Application;

use PHPUnit\Framework\TestCase;
use Wbits\Kxb\Gallery\Application\WorkOfArtService;
use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\CreatedInYear;
use Wbits\Kxb\Gallery\Domain\Dimensions;
use Wbits\Kxb\Gallery\Domain\FullName;
use Wbits\Kxb\Gallery\Domain\Material;
use Wbits\Kxb\Gallery\Domain\Title;
use Wbits\Kxb\Gallery\Domain\WorkOfArtDetails;
use Wbits\Kxb\Gallery\Infrastructure\InMemoryWorkOfArtRepository;

final class WorkOfArtServiceTest extends TestCase
{
    /**
     * @var WorkOfArtService
     */
    private $workOfArtService;

    protected function setUp()
    {
        $this->workOfArtService = new WorkOfArtService(new InMemoryWorkOfArtRepository());
    }

    public function testItDoesNotReturnAnyWorksOfArtWhenNoneWereCreated()
    {
        $works = $this->workOfArtService->getAllWorksOfArt();

        static::assertEmpty($works);
    }

    public function testItReturnsACollectionOfWorksWhen()
    {
        $title = new Title('title');
        $details = new WorkOfArtDetails(
            new Material('paint on canvas'),
            new Dimensions('60 cm', '50 cm'),
            new CreatedInYear(new \DateTimeImmutable('2015'))
        );
        $artist = new Artist(
            new ArtistId('1'),
            new FullName('Vincent', 'van Gogh')
        );

        $this->workOfArtService->createWorkOfArt($title, $details, $artist);
        $works = $this->workOfArtService->getAllWorksOfArt();

        static::assertCount(1, $works);
    }
}
