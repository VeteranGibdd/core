<?php

namespace Gibdd\Core\Tests\Unit;

use Gibdd\Core\Veteran;
use PHPUnit\Framework\TestCase;

class VeteranTest extends TestCase
{
    public function testJsonSerialize()
    {
        $veteran = new Veteran(['first_name' => 'Ivan', 'last_name' => 'Ivanov']);

        $this->assertSame(json_encode(['first_name' => 'Ivan', 'last_name' => 'Ivanov']), json_encode($veteran));
    }

}
