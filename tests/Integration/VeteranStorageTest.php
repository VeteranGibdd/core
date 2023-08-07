<?php

namespace Gibdd\Core\Tests\Integration;

use Doctrine\DBAL\Exception;
use Gibdd\Core\VeteranStorage;
use Gibdd\Core;
use Opis\JsonSchema\Validator;

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
            'disability' => 2,

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

    /**
     * @throws Exception
     */
    public function testAdd(): void
    {
        $veteranId = $this->veteran->add($this->veteran());
        $veteran = $this->veteran->byId($veteranId);

        $this->assertSame(($this->veteran()->lastName | $this->veteran()->organisation->status), ($veteran->jsonSerialize()['lastName'] | $veteran->jsonSerialize()['organisation']['status']));
    }

    /**
     * @throws Exception
     */
    public function testUpdate(): void
    {
        $updateData = (object)[
            'firstName' => 'Иван',
            'lastName' => 'Крутой',
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

        $veteranId = $this->veteran->add($this->veteran());
        $this->veteran->update($updateData, $veteranId);
        $veteran = $this->veteran->byId($veteranId);

        $this->assertSame(('Крутой' | 'Ветеран'), ($veteran->jsonSerialize()['lastName'] | $veteran->jsonSerialize()['organisation']['status']));
    }

    /**
     * @throws Exception
     */
    public function testDelete(): void
    {
        $veteranId = $this->veteran->add($this->veteran());

        $this->veteran->delete($veteranId);

        $this->assertSame('[]', json_encode($this->veteran->allVeterans()));
    }

    public function testMinAdd(): void
    {
        $veteranId = $this->veteran->add($this->minVeteran());
        $veteran = $this->veteran->byId($veteranId);

        $this->assertSame(($this->minVeteran()->lastName | $this->minVeteran()->organisation->status), ($veteran->jsonSerialize()['lastName'] | $veteran->jsonSerialize()['organisation']['status']));
    }

    /**
     * @throws Exception
     */
    public function testMinUpdate(): void
    {
        $updateData = (object)[
            'firstName' => 'Иван',
            'lastName' => 'Крутой',
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

        $veteranId = $this->veteran->add($this->minVeteran());
        $this->veteran->update($updateData, $veteranId);
        $veteran = $this->veteran->byId($veteranId);


        $this->assertSame(('Крутой' | 'Ветеран'), ($veteran->jsonSerialize()['lastName'] | $veteran->jsonSerialize()['organisation']['status']));

    }

}
