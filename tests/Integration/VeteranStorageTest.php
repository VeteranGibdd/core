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
            'liveAddress' => 'Сочи',
            'passportAddress' => 'г. Сочи, ул. Победы д. 17 кв. 4',
            'rank' => 'майор полиции',
            'lengthService' => 22,
            'lengthServicePolice' => 12,
            'retirementStatus' => 'В отставке',
            'retirementYear' => 2021,
            'certificateNumber' => '0219',
            'certificateValidity' => '2023-07-03',
            'status' => 'Ветеран',
            'yearEntryToVeteranOrg' => 2008,
            'duty' => 'Актив',
            'mobilePhone' => '89881234567',
            'reservePhone' => '89887654321',
            'email' => 'test2@mail.ru',
            'passport' => '03 22 687533',
            'awards' => 'за выслугу лет',
            'disability' => '2 группа',
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
            'yearEntryToVeteranOrg' => 2008,
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
            'liveAddress' => 'Сочи',
            'passportAddress' => 'г. Сочи, ул. Победы д. 17 кв. 4',
            'rank' => 'майор полиции',
            'lengthService' => 22,
            'lengthServicePolice' => 12,
            'retirementStatus' => 'В отставке',
            'retirementYear' => 2021,
            'certNumber' => '0219',
            'validity' => '2023-07-03',
            'status' => 'Ветеран',
            'yearEntryToVeteranOrg' => 2008,
            'duty' => 'Актив',
            'mobilePhone' => '89881234567',
            'reservePhone' => '89887654321',
            'email' => 'test2@mail.ru',
            'passport' => '03 22 687533',
            'awards' => 'за выслугу лет',
            'disability' => '2 группа',
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
            'passport' => '03 22 689594'
        ];

        $updatedJsonData = [
            'id' => 100500,
            'firstName' => 'Иван',
            'lastName' => 'Крутой',
            'middleName' => 'Иванович',
            'birthDate' => '1970-03-25',
            'liveAddress' => 'Сочи',
            'passportAddress' => 'г. Сочи, ул. Победы д. 17 кв. 4',
            'rank' => 'майор полиции',
            'lengthService' => 22,
            'lengthServicePolice' => 12,
            'retirementStatus' => 'В отставке',
            'retirementYear' => 2021,
            'certNumber' => '0219',
            'validity' => '2023-07-03',
            'status' => 'Ветеран',
            'yearEntryToVeteranOrg' => 2008,
            'duty' => 'Актив',
            'mobilePhone' => '89881234567',
            'reservePhone' => '89887654321',
            'email' => 'cool@mail.ru',
            'passport' => '03 22 689594',
            'awards' => 'за выслугу лет',
            'disability' => '2 группа',
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
            'yearEntryToVeteranOrg' => 2008,
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
            'passport' => '03 22 689594'
        ];

        $updatedJsonData = [
            'id' => 100500,
            'firstName' => 'Иван',
            'lastName' => 'Крутой',
            'middleName' => 'Иванович',
            'birthDate' => '1970-03-25',
            'status' => 'Ветеран',
            'yearEntryToPolice' => 2008,
            'email' => 'cool@mail.ru',
            'passport' => '03 22 689594'
        ];

        $this->veteran->add($this->minVeteran());

        $this->veteran->update($updateData, $this->minVeteran()->id);

        $this->assertSame(json_encode($updatedJsonData, JSON_UNESCAPED_UNICODE), json_encode($this->veteran->byId($this->minVeteran()->id), JSON_UNESCAPED_UNICODE));

    }

}
