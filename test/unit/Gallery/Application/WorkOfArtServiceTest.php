<?php

declare(strict_types = 1);

namespace unit\Wbits\Kxb\Gallery\Application;

use PHPUnit\Framework\TestCase;
use Wbits\Kxb\Gallery\Application\WorkOfArtService;
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
        $this->workOfArtService->createWorkOfArt();
        $works = $this->workOfArtService->getAllWorksOfArt();

        static::assertCount(1, $works);
    }
}

