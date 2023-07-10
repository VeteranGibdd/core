<?php
require_once '/Users/admin/PhpstormProjects/VeteranGibdd/core/class/Veteran.php';

use PHPUnit\Framework\TestCase;

class VeteranTest extends TestCase
{
    private Veteran $veteran;

    protected function setUp(): void
    {
        $this->veteran = new Veteran(['first_name' => 'Ivan', 'last_name' => 'Ivanov']);
    }

    public function testJsonSerialize()
    {
        $this->assertSame(json_encode(['first_name' => 'Ivan', 'last_name' => 'Ivanov']), json_encode($this->veteran));
    }

}
