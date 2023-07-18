<?php

namespace Gibdd\Core\Tests\Integration;

use Gibdd\Core\VeteranStorage;
use stdClass;

class VeteranStorageTest extends TestDbCase
{
    private VeteranStorage $veteran;
    private stdClass $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->veteran = new VeteranStorage(self::$db);

        $this->data = (object)[
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
            'yearEntryToPolice' => 2008,
            'duty' => 'Актив',
            'mobilePhone' => '89881234567',
            'reservePhone' => '89887654321',
            'email' => 'test2@mail.ru',
            'passport' => '03 22 687533',
            'awards' => 'за выслугу лет',
            'disability' => '2 группа',
            'hostilitiesParticipation' => 'Карабах',
            'yearOfDismissal' => '2022',
        ];
    }

    public function testAddData(): void
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
            'yearEntryToPolice' => 2008,
            'duty' => 'Актив',
            'mobilePhone' => '89881234567',
            'reservePhone' => '89887654321',
            'email' => 'test2@mail.ru',
            'passport' => '03 22 687533',
            'awards' => 'за выслугу лет',
            'disability' => '2 группа',
            'hostilitiesParticipation' => 'Карабах',
            'yearOfDismissal' => 2022,
        ];

        $this->veteran->addData($this->data);

        $this->assertSame(json_encode($jsonData, JSON_UNESCAPED_UNICODE), json_encode($this->veteran->byId(100500), JSON_UNESCAPED_UNICODE));
    }

    public function testUpdateData(): void
    {
        $updateData = (object)[
            'lastName' => 'Крутой',
            'email' => 'cool@mail.ru',
            'passport' => '03 22 689594',
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
            'yearEntryToPolice' => 2008,
            'duty' => 'Актив',
            'mobilePhone' => '89881234567',
            'reservePhone' => '89887654321',
            'email' => 'cool@mail.ru',
            'passport' => '03 22 689594',
            'awards' => 'за выслугу лет',
            'disability' => '2 группа',
            'hostilitiesParticipation' => 'Карабах',
            'yearOfDismissal' => 2022,
        ];

        $this->veteran->addData($this->data);

        $this->veteran->updateById($updateData, 100500);

        $this->assertSame(json_encode($updatedJsonData, JSON_UNESCAPED_UNICODE), json_encode($this->veteran->byId(100500), JSON_UNESCAPED_UNICODE));
    }

    public function testDeleteData(): void
    {
        $this->veteran->addData($this->data);

        $this->veteran->deleteData();

        $this->assertSame('[]', json_encode($this->veteran->allVeterans()));
    }
}
