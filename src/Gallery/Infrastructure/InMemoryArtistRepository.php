<?php

declare(strict_types=1);

namespace Gallery\Infrastructure;

use Ramsey\Uuid\Uuid;
use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\ArtistRepository;

final class InMemoryArtistRepository implements ArtistRepository
{
    private $artistCollection = [];

    public function getNextIdentifier(): ArtistId
    {
        $uuid = Uuid::uuid4();

        return new ArtistId((string) $uuid);
    }

    public function get(ArtistId $artistId): Artist
    {
        $key = (string)$artistId;
        if (!array_key_exists($key, $this->artistCollection)) {
            throw new \InvalidArgumentException('Artist was not found');
        }

        return $this->artistCollection[$key];
    }

    /**
     * @return array|Artist[]
     */
    public function getAll(): array
    {
        return $this->artistCollection;
    }

    public function save(Artist $artist): void
    {
        $key = (string)$artist->getId();
        $this->artistCollection[$key] = $artist;
    }
}
