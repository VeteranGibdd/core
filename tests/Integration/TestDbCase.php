<?php

namespace Gibdd\Core\Tests\Integration;

use Doctrine\DBAL;
use PHPUnit\Framework\TestCase;

class TestDbCase extends TestCase
{
    public static DBAL\Connection $db;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $connectionParams = [
            'path' => __DIR__ . '/../veterans.sqlite3',
            'driver' => 'sqlite3',
        ];

        self::$db = DBAL\DriverManager::getConnection($connectionParams);
    }

    protected function setUp(): void
    {
        parent::setUp();

        self::$db->beginTransaction();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        self::$db->rollBack();
    }
}
