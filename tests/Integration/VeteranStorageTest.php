<?php

namespace Gibdd\Core\Tests\Integration;

use Gibdd\Core\VeteranStorage;
use stdClass;

class VeteranStorageTest extends TestDbCase
{
    private VeteranStorage $veteran;

    protected function setUp(): void
    {
        parent::setUp();

        $this->veteran = new VeteranStorage(self::$db);

    }

    private function veteran(): \stdClass
    {
        return (object)[
            'firstName' => 'Иван',
            'lastName' => 'Ивановванов',
            'middleName' => 'Иванович',
            'birthDate' => '1970-03-25',
            'district' => 'Сочи',
            'address' => 'г. Сочи, ул. Победы д. 17 кв. 4',
            'mobilePhone' => '89881234567',
            'reservePhone' => '89887654321',
            'email' => 'test2@mail.ru',
            'disability' => '2 группа',

            'passport' => (object)[
                'serial' => '0322',
                'number' => '687533',
                'dateOfIssue' => '2027-08-13',
            ],

            'policeDuty' => (object)[
                'rank' => 'майор полиции',
                'lengthService' => 22,
                'lengthServiceTrafficPolice' => 12,
                'dutyStatus' => 'В отставке',
                'retirementYear' => 2021,
                'awards' => 'за выслугу лет',
                'hostilitiesParticipation' => 'Карабах',
            ],

            'organisation' => (object)[
                'status' => 'Ветеран',
                'joiningYear' => 2008,
                'role' => 'Актив',
                'certNumber' => '0219',
                'validity' => '2023-07-03',
            ],
        ];
    }

    public function minVeteran(): \stdClass
    {
        return (object)[
            'firstName' => 'Иван',
            'lastName' => 'Ивановванов',
            'middleName' => 'Иванович',
            'birthDate' => '1970-03-25',
            'district' => 'Сочи',

            'policeDuty' => (object)[
                'rank' => 'майор полиции',
                'dutyStatus' => 'В отставке',
            ],

            'organisation' => (object)[
                'status' => 'Ветеран',
                'joiningYear' => 2008,
            ],
        ];
    }

    public function testAdd(): void
    {
        $this->veteran->add($this->veteran());
        $vet = (object)['id' => 1];
        $vet_merged = (object)array_merge((array)$vet, (array)$this->veteran());

        $this->assertSame(json_encode($vet_merged, JSON_UNESCAPED_UNICODE), json_encode($this->veteran->byId(1), JSON_UNESCAPED_UNICODE));
    }

    public function testUpdate(): void
    {
        $updateData = (object)[
            'lastName' => 'Крутой',
        ];
        $vet = (object)['id' => 1];
        $vet_merged = (object)array_merge((array)$vet, (array)$this->veteran(), (array)$updateData);

        $this->veteran->add($this->veteran());

        $this->veteran->update($updateData, 1);

        $this->assertSame(json_encode($vet_merged, JSON_UNESCAPED_UNICODE), json_encode($this->veteran->byId(1), JSON_UNESCAPED_UNICODE));
    }

    public function testDelete(): void
    {
        $this->veteran->add($this->veteran());

        $this->veteran->delete(1);

        $this->assertSame('[]', json_encode($this->veteran->allVeterans()));
    }

    public function testMinAdd(): void
    {
        $this->veteran->add($this->minVeteran());

        $vet = (object)['id' => 1];
        $vet_merged = (object)array_merge((array)$vet, (array)$this->minVeteran());

        $this->assertSame(json_encode($vet_merged, JSON_UNESCAPED_UNICODE), json_encode($this->veteran->byId(1), JSON_UNESCAPED_UNICODE));
    }

    public function tstMinUpdate(): void
    {
        $updateData = (object)[
            'lastName' => 'Крутой',
        ];

        $this->veteran->add($this->minVeteran());

        $this->veteran->update($updateData, 1);

        $vet = (object)['id' => 1];
        $vet_merged = (object)array_merge((array)$vet, (array)$this->minVeteran(), (array)$updateData);

        $this->assertSame(json_encode($vet_merged, JSON_UNESCAPED_UNICODE), json_encode($this->veteran->byId(1), JSON_UNESCAPED_UNICODE));

    }

}
