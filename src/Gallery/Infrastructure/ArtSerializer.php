<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Infrastructure;

use Wbits\Kxb\Exception\InvalidJson;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\ArtPiece;
use Wbits\Kxb\Gallery\Domain\ArtPieceDetails;
use Wbits\Kxb\Gallery\Domain\ArtPieceId;
use Wbits\Kxb\Gallery\Domain\Availability;
use Wbits\Kxb\Gallery\Domain\CreatedInYear;
use Wbits\Kxb\Gallery\Domain\Dimensions;
use Wbits\Kxb\Gallery\Domain\Material;
use Wbits\Kxb\Gallery\Domain\Price;
use Wbits\Kxb\Gallery\Domain\Title;

final class ArtSerializer
{
    public function serialize(ArtPiece $artPiece): string
    {
        return json_encode($artPiece->toArray());
    }

    public function deserialize(string $artPiece): ArtPiece
    {
        $art = self::decode($artPiece);

        return ArtPiece::create(
            new ArtPieceId($art['id']),
            new Title($art['title']),
            new ArtPieceDetails(
                new Material($art['material']),
                Dimensions::extract($art['size']),
                new CreatedInYear(new \DateTimeImmutable($art['year']))
            ),
            new Availability((int)$art['availability']),
            new Price((float) $art['price']),
            new ArtistId('some-artist-id')
        );
    }

    private static function decode($json)
    {
        $result = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $message = json_last_error_msg();
            throw new InvalidJson($message);
        }

        return $result;
    }
}

