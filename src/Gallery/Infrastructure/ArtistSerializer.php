<?php

declare(strict_types=1);

namespace Wbits\Kxb\Gallery\Infrastructure;

use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\FullName;

final class ArtistSerializer
{
    public function serialize(Artist $artist): string
    {
        return json_encode([
            'id' => (string) $artist->getId(),
            'name' => (string) $artist->getFullName()
        ]);
    }

    public function deserialize(string $json): Artist
    {
        $artist = JsonDecoder::decode($json);
        $name = explode(' ', $artist['name']);

        return new Artist(
            new ArtistId($artist['id']),
            new FullName($name[0], $name[1])
        );
    }
}

