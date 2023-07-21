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
            'id' => 100500,
            'firstName' => 'Иван',
            'lastName' => 'Ивановванов',
            'middleName' => 'Иванович',
            'birthDate' => '1970-03-25',
            'district' => 'Сочи',
            'address' => 'г. Сочи, ул. Победы д. 17 кв. 4',
            'mobilePhone' => '89881234567',
            'reservePhone' => '89887654321',
            'disability' => '2 группа',
            'email' => 'test2@mail.ru',
            'serial' => '0322',
            'number' => '687533',
            'dateOfIssue' => '2027-08-13',
            'status' => 'Ветеран',
            'joiningYear' => 2008,
            'role' => 'Актив',
            'certNumber' => '0219',
            'validity' => '2023-07-03',
            'rank' => 'майор полиции',
            'lengthService' => 22,
            'lengthServicePolice' => 12,
            'dutyStatus' => 'В отставке',
            'retirementYear' => 2021,
            'awards' => 'за выслугу лет',
            'hostilitiesParticipation' => 'Карабах',
        ];
    }

    public function minVeteran(): \stdClass
    {
        return (object)[
            'id' => 100500,
            'firstName' => 'Иван',
            'lastName' => 'Ивановванов',
            'middleName' => 'Иванович',
            'birthDate' => '1970-03-25',
            'status' => 'Ветеран',
            'joiningYear' => 2008,
        ];
    }

    public function testAdd(): void
    {
        $jsonData = [
            'id' => 100500,
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
            'serial' => '0322',
            'number' => '687533',
            'dateOfIssue' => '2027-08-13',
            'status' => 'Ветеран',
            'joiningYear' => 2008,
            'role' => 'Актив',
            'certNumber' => '0219',
            'validity' => '2023-07-03',
            'rank' => 'майор полиции',
            'lengthService' => 22,
            'lengthServicePolice' => 12,
            'dutyStatus' => 'В отставке',
            'retirementYear' => 2021,
            'awards' => 'за выслугу лет',
            'hostilitiesParticipation' => 'Карабах',
        ];

        $this->veteran->add($this->veteran());

        $this->assertSame(json_encode($jsonData, JSON_UNESCAPED_UNICODE), json_encode($this->veteran->byId($this->veteran()->id), JSON_UNESCAPED_UNICODE));
    }

    public function testUpdate(): void
    {
        $updateData = $this->veteran();
        $updateData = (object)[
            'lastName' => 'Крутой',
            'email' => 'cool@mail.ru',
            'serial' => '0325',
            'number' => '689537',
            'dateOfIssue' => '2029-03-17',
        ];

        $updatedJsonData = [
            'id' => 100500,
            'firstName' => 'Иван',
            'lastName' => 'Крутой',
            'middleName' => 'Иванович',
            'birthDate' => '1970-03-25',
            'district' => 'Сочи',
            'address' => 'г. Сочи, ул. Победы д. 17 кв. 4',
            'mobilePhone' => '89881234567',
            'reservePhone' => '89887654321',
            'email' => 'cool@mail.ru',
            'disability' => '2 группа',
            'serial' => '0325',
            'number' => '689537',
            'dateOfIssue' => '2029-03-17',
            'status' => 'Ветеран',
            'joiningYear' => 2008,
            'role' => 'Актив',
            'certNumber' => '0219',
            'validity' => '2023-07-03',
            'rank' => 'майор полиции',
            'lengthService' => 22,
            'lengthServicePolice' => 12,
            'dutyStatus' => 'В отставке',
            'retirementYear' => 2021,
            'awards' => 'за выслугу лет',
            'hostilitiesParticipation' => 'Карабах',
        ];

        $this->veteran->add($this->veteran());

        $this->veteran->update($updateData, $this->veteran()->id);

        $this->assertSame(json_encode($updatedJsonData, JSON_UNESCAPED_UNICODE), json_encode($this->veteran->byId($this->veteran()->id), JSON_UNESCAPED_UNICODE));
    }

    public function testDelete(): void
    {
        $this->veteran->add($this->veteran());

        $this->veteran->delete($this->veteran()->id);

        $this->assertSame('[]', json_encode($this->veteran->allVeterans()));
    }

    public function testMinAdd(): void
    {
        $jsonData = [
            'id' => 100500,
            'firstName' => 'Иван',
            'lastName' => 'Ивановванов',
            'middleName' => 'Иванович',
            'birthDate' => '1970-03-25',
            'status' => 'Ветеран',
            'joiningYear' => 2008,
        ];

        $this->veteran->add($this->minVeteran());

        $this->assertSame(json_encode($jsonData, JSON_UNESCAPED_UNICODE), json_encode($this->veteran->byId($this->minVeteran()->id), JSON_UNESCAPED_UNICODE));
    }

    public function tstMinUpdate(): void
    {
        $updateData = $this->minVeteran();
        $updateData = (object)[
            'lastName' => 'Крутой',
            'email' => 'cool@mail.ru',
            'serial' => '0325',
            'number' => '689537',
            'dateOfIssue' => '2029-03-17',
        ];

        $updatedJsonData = [
            'id' => 100500,
            'firstName' => 'Иван',
            'lastName' => 'Крутой',
            'middleName' => 'Иванович',
            'birthDate' => '1970-03-25',
            'status' => 'Ветеран',
            'joiningYear' => 2008,
            'email' => 'cool@mail.ru',
            'serial' => '0325',
            'number' => '689537',
            'dateOfIssue' => '2029-03-17',
        ];

        $this->veteran->add($this->minVeteran());

        $this->veteran->update($updateData, $this->minVeteran()->id);

        $this->assertSame(json_encode($updatedJsonData, JSON_UNESCAPED_UNICODE), json_encode($this->veteran->byId($this->minVeteran()->id), JSON_UNESCAPED_UNICODE));

    }

}
