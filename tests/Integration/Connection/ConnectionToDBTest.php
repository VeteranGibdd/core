<?php

namespace Gibdd\Core\Tests\Integration\Connection;

class ConnectionToDBTest extends TestDbCase
{
    public function testDbConnection()
    {
        self::assertSame(1, self::$db->fetchOne('SELECT 1'));
    }
}
