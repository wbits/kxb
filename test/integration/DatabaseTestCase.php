<?php

declare(strict_types = 1);

namespace integration\Wbits\Kxb;

use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;

abstract class DatabaseTestCase extends TestCase
{
    use TestCaseTrait;
    const DB_NAME = 'kxb_test';
    const HOST = '192.168.99.100';
    const DB_USER = 'kxbusr';
    const DB_PASS = 'kxbpss';

    /**
     * @var \PDO
     */
    protected static $pdo;
    private $conn;

    final public function getConnection()
    {
        $dsn = sprintf('pgsql:dbname=%s;host=%s', self::DB_NAME, self::HOST);

        if ($this->conn === null) {
            if (self::$pdo === null) {
                self::$pdo = new \PDO($dsn, self::DB_USER, self::DB_PASS);
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, self::DB_NAME);
        }

        return $this->conn;
    }
}
