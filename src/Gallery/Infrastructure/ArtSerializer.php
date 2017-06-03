<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Infrastructure;

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

final class ArtSerializer
{
    public function serialize(Art $art): string
    {
        return json_encode([
            'id' => (string) $art->getId(),
            'title' => (string) $art->getTitle(),
            'material' => (string) $art->getMaterial(),
            'size' => (string) $art->getSize(),
            'year' => (string) $art->getYear(),
            'availability' => (string) $art->getAvailability(),
            'price' => (string) $art->getPrice(),
            'artist_id' => (string) $art->getArtistId(),
        ]);
    }

    public function deserialize(string $json): Art
    {
        $art = JsonDecoder::decode($json);

        return Art::create(
            new ArtId($art['id']),
            new Title($art['title']),
            new ArtDetails(
                new Material($art['material'] ?? ''),
                Dimensions::extract($art['size'] ?? ''),
                new CreatedInYear(new \DateTimeImmutable($art['year'] ?? 'now'))
            ),
            new Availability((int) $art['availability'] ?? 0),
            new Price((float) $art['price'] ?? 0),
            new ArtistId($art['artist_id'])
        );
    }
}
