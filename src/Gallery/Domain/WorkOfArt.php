<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class WorkOfArt
{
    private $id;
    private $title;
    private $details;
    private $availability;
    private $price;
    private $artist;

    private function __construct(
        WorkOfArtId $id,
        Title $title,
        WorkOfArtDetails $details,
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
        WorkOfArtId $id,
        Title $title,
        WorkOfArtDetails $details,
        Availability $availability,
        Price $price,
        Artist $artist
    ): WorkOfArt
    {
        return new self($id, $title, $details, $availability, $price, $artist);
    }

    public function getId(): WorkOfArtId
    {
        return $this->id;
    }
}
