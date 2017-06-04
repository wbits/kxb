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

    public function updateTitle(Title $title): void
    {
        $this->title = $title;
    }

    public function getId(): ArtId
    {
        return $this->id;
    }

    public function getArtistId(): ArtistId
    {
        return $this->artistId;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getMaterial(): Material
    {
        return $this->details->getMaterial();
    }

    public function getSize(): Dimensions
    {
        return $this->details->getSize();
    }

    public function getYear(): CreatedInYear
    {
        return $this->details->getYear();
    }

    public function getAvailability(): Availability
    {
        return $this->availability;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}
