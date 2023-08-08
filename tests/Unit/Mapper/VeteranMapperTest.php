<?php

namespace Gibdd\Core\Tests\Unit\Mapper;

use Gibdd\Core\Mapper\Veteran;
use PHPUnit\Framework\TestCase;

class VeteranMapperTest extends TestCase
{
    private Veteran $veteran;

    protected function setUp(): void
    {
        $this->veteran = new Veteran($this->veteran());
    }

    public function testAddDutyId(): void
    {
        $this->veteran->addDutyId(5);
        $this->assertSame(5, $this->veteran->mappedDutyRow()['id']);
    }

    public function testDutyRowMapping(): void
    {
        $this->assertSame($this->veteran()->policeDuty->dutyStatus, $this->veteran->mappedDutyRow()['duty_status']);
        $this->assertArrayNotHasKey('awards', $this->veteran->mappedDutyRow());
    }

    public function testAddPassportId(): void
    {
        $this->veteran->addPassportId(7);
        $this->assertSame(7, $this->veteran->mappedPassportRow()['id']);
    }

    public function testPassportRowMapping(): void
    {
        $this->assertSame($this->veteran()->passport->dateOfIssue, $this->veteran->mappedPassportRow()['date_of_issue']);
        $this->assertArrayNotHasKey('number', $this->veteran->mappedPassportRow());
    }

    public function testAddVeteranId(): void
    {
        $this->veteran->addVeteranId(2);
        $this->assertSame(2, $this->veteran->mappedVeteranRow()['id']);
    }

    public function testVeteranRowMapping(): void
    {
        $this->assertSame($this->veteran()->lastName, $this->veteran->mappedVeteranRow()['last_name']);
        $this->assertArrayNotHasKey('email', $this->veteran->mappedVeteranRow());
    }

    public function testAddOrganisationId(): void
    {
        $this->veteran->addOrganisationId(9);
        $this->assertSame(9, $this->veteran->mappedOrganisationRow()['id']);
    }

    public function testOrganisationRowMapping(): void
    {
        $this->assertSame($this->veteran()->organisation->joiningYear, $this->veteran->mappedOrganisationRow()['joining_year']);
        $this->assertArrayNotHasKey('role', $this->veteran->mappedOrganisationRow());
    }

    private function veteran(): \stdClass
    {
        return (object)[
            'firstName' => 'Иван',
            'lastName' => 'Ивановванов',
            'middleName' => 'Иванович',
            'birthDate' => '1970-03-25',
            'district' => 'Сочи',
            'email' => NULL,

            'passport' => (object)[
                'serial' => '0322',
                'number' => NULL,
                'dateOfIssue' => '2027-08-13',
            ],

            'policeDuty' => (object)[
                'rank' => 'майор полиции',
                'dutyStatus' => 'В отставке',
                'awards' => NULL
            ],

            'organisation' => (object)[
                'status' => 'Ветеран',
                'joiningYear' => 2008,
                'role' => NULL
            ],
        ];
    }
}
