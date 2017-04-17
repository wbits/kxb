<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Gallery\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;

final class DbalRepository
{
    const FETCH_ALL         = 'SELECT * FROM %s';
    const FETCH_ONE_BY_ID   = self::FETCH_ALL . 'WHERE id = ?';
    const COUNT_BY_ID       = 'SELECT count(id) FROM %s WHERE id = ?';

    private $connection;
    private $tableExpression;
    private $statements = [];

    public function __construct(Connection $connection, string $tableExpression)
    {
        $this->connection = $connection;
        $this->tableExpression = $tableExpression;
    }

    public function fetchById(string $id)
    {
        $statement = $this->getStatement(sprintf(self::FETCH_ONE_BY_ID, $this->tableExpression));
        $statement->bindValue(1, $id);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAll()
    {
        $statement = $this->getStatement(sprintf(self::FETCH_ALL, $this->tableExpression));
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function upsert(string $identifier, string $json)
    {
        $data = [
            'id' => $identifier,
            'doc' => $json
        ];

        if ($this->exists($identifier)) {
            $this->update($data, $identifier);
        } else {
            $this->insert($data);
        }
    }

    private function exists(string $identifier): bool
    {
        $statement = $this->getStatement(sprintf(self::COUNT_BY_ID, $this->tableExpression));
        $statement->bindValue(1, $identifier);
        $statement->execute();

        return (bool) $statement->fetchColumn();
    }

    private function insert(array $data)
    {
        $this->connection->beginTransaction();

        try {
            $this->connection->insert($this->tableExpression, $data);
            $this->connection->commit();
        } catch (\Exception $exception) {
            $this->connection->rollBack();
            throw $exception;
        }
    }

    private function update(array $data, string $identifier)
    {
        $this->connection->beginTransaction();

        try {
            $this->connection->update($this->tableExpression, $data, ['id' => $identifier]);
            $this->connection->commit();
        } catch (\Exception $exception) {
            $this->connection->rollBack();
            throw $exception;
        }
    }

    private function getStatement(string $sql): Statement
    {
        if (!array_key_exists($sql, $this->statements)) {
            $statement = $this->connection->prepare($sql);
            $this->statements[$sql] = $statement;
        }

        return $this->statements[$sql];
    }
}
