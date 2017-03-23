<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Application;

use Wbits\Kxb\Gallery\Domain\WorkOfArt;
use Wbits\Kxb\Gallery\Domain\WorkOfArtRepository;

final class WorkOfArtService
{
    private $repository;

    public function __construct(WorkOfArtRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllWorksOfArt(): array
    {
        return $this->repository->getAll();
    }

    public function createWorkOfArt()
    {
        $work = WorkOfArt::create($this->repository->getNextIdentifier());
        $this->repository->save($work);
    }
}

