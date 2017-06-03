<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class Art
{
    private $id;
    private $title;
    private $details;
    private $availability;
    private $price;
    private $artistId;

    private function __construct(
        ArtId $id,
        Title $title,
        ArtDetails $details,
        Availability $availability,
        Price $price,
        ArtistId $artistId
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->details = $details;
        $this->artistId = $artistId;
        $this->availability = $availability;
        $this->price = $price;
    }

    public static function create(
        ArtId $id,
        Title $title,
        ArtDetails $details,
        Availability $availability,
        Price $price,
        ArtistId $artistId
    ): Art {
        return new self($id, $title, $details, $availability, $price, $artistId);
    }

    public function getId(): ArtId
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
            'artist_id' => (string) $this->artistId,
        ];
    }
}
