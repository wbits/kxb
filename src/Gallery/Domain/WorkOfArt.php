<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Domain;

final class WorkOfArt
{
    private $id;
    private $title;
    private $artist;

    /**
     * @var WorkOfArtDetails
     */
    private $details;

    private function __construct(WorkOfArtId $id, Title $title, WorkOfArtDetails $details, Artist $artist)
    {
        $this->id = $id;
        $this->title = $title;
        $this->details = $details;
        $this->artist = $artist;
    }

    public static function create(WorkOfArtId $id, Title $title, WorkOfArtDetails $details, Artist $artist): WorkOfArt
    {
        return new self($id, $title, $details, $artist);
    }

    public function getId(): WorkOfArtId
    {
        return $this->id;
    }
}
