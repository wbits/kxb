<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class ArtPiece
{
    private $id;
    private $title;
    private $details;
    private $availability;
    private $price;
    private $artist;

    private function __construct(
        ArtPieceId $id,
        Title $title,
        ArtPieceDetails $details,
        Availability $availability,
        Price $price,
        Artist $artist
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->details = $details;
        $this->artist = $artist;
        $this->availability = $availability;
        $this->price = $price;
    }

    public static function create(
        ArtPieceId $id,
        Title $title,
        ArtPieceDetails $details,
        Availability $availability,
        Price $price,
        Artist $artist
    ): ArtPiece {
        return new self($id, $title, $details, $availability, $price, $artist);
    }

    public function getId(): ArtPieceId
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => (string) $this->id,
            'title' => (string) $this->title,
            'material' => (string) $this->details->getMaterial(),
            'size' => (string) $this->details->getSize(),
            'year' => (string) $this->details->getYear(),
            'availability' => (string) $this->availability,
            'price' => (string) $this->price,
            'artist_id' => (string) $this->artist->getId(),
            'artist_name' => (string) $this->artist->getFullName(),
        ];
    }
}
