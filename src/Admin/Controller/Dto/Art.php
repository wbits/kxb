<?php

declare(strict_types=1);

namespace Wbits\Kxb\Admin\Controller\Dto;

final class Art
{
    private $art;

    public function __construct(\Wbits\Kxb\Gallery\Domain\Art $art)
    {
        $this->art = $art;
    }

    public function toArray(): array
    {
        $art = $this->art;
        return [
            'id' => (string) $art->getId(),
            'title' => (string) $art->getTitle(),
            'material' => (string) $art->getMaterial(),
            'size' => (string) $art->getSize(),
            'year' => (string) $art->getYear(),
            'availability' => (string) $art->getAvailability(),
            'price' => (string) $art->getPrice(),
            'artist_id' => (string) $art->getArtistId(),
        ];
    }
}

