<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Admin\Controller\Dto;

use Wbits\Kxb\Gallery\Domain\ArtDetails;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\Availability;
use Wbits\Kxb\Gallery\Domain\CreatedInYear;
use Wbits\Kxb\Gallery\Domain\Dimensions;
use Wbits\Kxb\Gallery\Domain\Material;
use Wbits\Kxb\Gallery\Domain\Price;
use Wbits\Kxb\Gallery\Domain\Title;

final class CreateArtDto
{
    private $title;
    private $material;
    private $width;
    private $height;
    private $year;
    private $numberOfCopies;
    private $price;
    private $artistId;

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
            new Material($this->title),
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

    public function setTitle($title): CreateArtDto
    {
        $this->title = $title;

        return $this;
    }

    public function setMaterial($material): CreateArtDto
    {
        $this->material = $material;

        return $this;
    }

    public function setWidth($width): CreateArtDto
    {
        $this->width = $width;

        return $this;
    }

    public function setHeight($height): CreateArtDto
    {
        $this->height = $height;

        return $this;
    }

    public function setYear($year): CreateArtDto
    {
        $this->year = $year;

        return $this;
    }

    public function setNumberOfCopies($numberOfCopies): CreateArtDto
    {
        $this->numberOfCopies = $numberOfCopies;

        return $this;
    }

    public function setPrice($price): CreateArtDto
    {
        $this->price = $price;

        return $this;
    }

    public function setArtistId($artistId): CreateArtDto
    {
        $this->artistId = $artistId;

        return $this;
    }
}
