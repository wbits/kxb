<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Infrastructure;

use Doctrine\DBAL\Connection;
use Ramsey\Uuid\Uuid;
use Wbits\Kxb\Gallery\Domain\ArtistId;
use Wbits\Kxb\Gallery\Domain\ArtPiece;
use Wbits\Kxb\Gallery\Domain\ArtPieceDetails;
use Wbits\Kxb\Gallery\Domain\ArtPieceId;
use Wbits\Kxb\Gallery\Domain\ArtRepository;
use Wbits\Kxb\Gallery\Domain\Availability;
use Wbits\Kxb\Gallery\Domain\CreatedInYear;
use Wbits\Kxb\Gallery\Domain\Dimensions;
use Wbits\Kxb\Gallery\Domain\Material;
use Wbits\Kxb\Gallery\Domain\Price;
use Wbits\Kxb\Gallery\Domain\Title;

final class DoctrineArtRepository implements ArtRepository
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function getNextIdentifier(): ArtPieceId
    {
        $uuid = Uuid::uuid4();

        return new ArtPieceId((string)$uuid);
    }

    public function save(ArtPiece $workOfArt)
    {
        $this->conn->beginTransaction();

        try {
            $this->conn->insert('art_piece',
                [
                    'id' => (string)$workOfArt->getId(),
                    'doc' => json_encode($workOfArt->toArray()),
                ]
            );
            $this->conn->commit();
        } catch (\Exception $exception) {
            $this->conn->rollBack();
            throw $exception;
        }

    }

    public function get(ArtPieceId $workOfArtId)
    {
        // TODO: Implement get() method.
    }

    /**
     * @return ArtPiece[]
     */
    public function getAll(): array
    {
        $result = [];
        $pieces = $this->conn->fetchAll('SELECT * FROM art_piece');

        foreach ($pieces as $piece) {
            $result[] = $this->fromArray(new ArtPieceId($piece['id']), json_decode($piece['doc'], true));
        }

        return $result;
    }

    public function fromArray(ArtPieceId $id, array $artPiece)
    {
        return ArtPiece::create(
            $id,
            new Title($artPiece['title']),
            new ArtPieceDetails(
                new Material($artPiece['material']),
                new Dimensions('500', '500'),
                new CreatedInYear(new \DateTimeImmutable($artPiece['year']))
            ),
            new Availability(1),
            new Price((float)$artPiece['price']),
            new ArtistId('some-artist-id')
        );
    }
}
