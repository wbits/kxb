<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Controller\Dto;

final class CreateArtPieceRequest
{
    private $title;
    private $material;
    private $width;
    private $height;
    private $year;
    private $number_of_copies;
    private $price;
    private $artist;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMaterial(): string
    {
        return $this->material;
    }

    public function getWidth(): string
    {
        return $this->width;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function getNumberOfCopies(): string
    {
        return $this->number_of_copies;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getArtist(): string
    {
        return $this->artist;
    }

    public function setTitle($title): CreateArtPieceRequest
    {
        $this->title = $title;

        return $this;
    }

    public function setMaterial($material): CreateArtPieceRequest
    {
        $this->material = $material;

        return $this;
    }

    public function setWidth($width): CreateArtPieceRequest
    {
        $this->width = $width;

        return $this;
    }

    public function setHeight($height): CreateArtPieceRequest
    {
        $this->height = $height;

        return $this;
    }

    public function setYear($year): CreateArtPieceRequest
    {
        $this->year = $year;

        return $this;
    }

    public function setNumberOfCopies($number_of_copies): CreateArtPieceRequest
    {
        $this->number_of_copies = $number_of_copies;

        return $this;
    }

    public function setPrice($price): CreateArtPieceRequest
    {
        $this->price = $price;

        return $this;
    }

    public function setArtist($artist): CreateArtPieceRequest
    {
        $this->artist = $artist;

        return $this;
    }
}
