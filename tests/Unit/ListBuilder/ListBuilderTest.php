<?php

namespace Gibdd\Core\Tests\Unit\ListBuilder;

use Doctrine\DBAL\Connection;
use Gibdd\Core\ListBuilder\Veteran;
use Ifedko\DoctrineDbalPagination\ListBuilder;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class ListBuilderTest extends TestCase
{
    public function testCanBuildVeteranListBuilder(): void
    {
        $db = m::mock(Connection::class);

        $listBuilder = new Veteran($db);
        self::assertInstanceOf(ListBuilder::class, $listBuilder);
    }
}
