<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Admin\Controller\Dto;

use Wbits\Kxb\Gallery\Domain\ArtDetails;
use Wbits\Kxb\Gallery\Domain\Artist;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\Availability;
use Wbits\Kxb\Gallery\Domain\CreatedInYear;
use Wbits\Kxb\Gallery\Domain\Dimensions;
use Wbits\Kxb\Gallery\Domain\Material;
use Wbits\Kxb\Gallery\Domain\Price;
use Wbits\Kxb\Gallery\Domain\Title;

final class ArtForm
{
    private $title;
    private $material;
    private $width;
    private $height;
    private $year;
    private $numberOfCopies;
    private $price;
    private $artistId;
    private $artistChoices;

    /**
     * @param array|Artist $artists
     */
    public function __construct(array $artists)
    {
        $artistChoices = [];
        /** @var Artist $artist */
        foreach ($artists as $artist) {
            $key = (string)$artist->getFullName();
            $artistChoices[$key] = (string) $artist->getId();
        }

        $this->artistChoices = $artistChoices;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getMaterial()
    {
        return $this->material;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getNumberOfCopies()
    {
        return $this->numberOfCopies;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getArtistId()
    {
        return $this->artistId;
    }

    public function title(): Title
    {
        return new Title($this->title);
    }

    public function details(): ArtDetails
    {
        return new ArtDetails(
            new Material($this->material),
            new Dimensions($this->width, $this->height),
            new CreatedInYear(new \DateTimeImmutable($this->year))
        );
    }

    public function availability(): Availability
    {
        return new Availability((int) $this->numberOfCopies);
    }

    public function price(): Price
    {
        return new Price((float) $this->price);
    }

    public function artistId(): ArtistId
    {
        return new ArtistId('1');
    }

    public function setTitle($title): ArtForm
    {
        $this->title = $title;

        return $this;
    }

    public function setMaterial($material): ArtForm
    {
        $this->material = $material;

        return $this;
    }

    public function setWidth($width): ArtForm
    {
        $this->width = $width;

        return $this;
    }

    public function setHeight($height): ArtForm
    {
        $this->height = $height;

        return $this;
    }

    public function setYear($year): ArtForm
    {
        $this->year = $year;

        return $this;
    }

    public function setNumberOfCopies($numberOfCopies): ArtForm
    {
        $this->numberOfCopies = $numberOfCopies;

        return $this;
    }

    public function setPrice($price): ArtForm
    {
        $this->price = $price;

        return $this;
    }

    public function setArtistId($artistId): ArtForm
    {
        $this->artistId = $artistId;

        return $this;
    }

    public function  getArtistChoices(): array
    {
        return $this->artistChoices;
    }
}
