<?php

namespace Gibdd\Core\Tests\Unit;

use Gibdd\Core\VeteranStorage;
use PHPUnit\Framework\TestCase;

class VeteranStorageTest extends TestCase
{
    public function testVeteranStorageAddData()
    {
        require_once __DIR__ . '/../../src/config.php';

        $veteran = new VeteranStorage($connectionParams);

        $data = [
            'id' => 100500,
            'firstname' => 'Иван',
            'lastname' => 'Ивановванов',
            'middlename' => 'Иванович',
            'birthdate' => '1970-03-25',
            'liveaddress' => 'Сочи',
            'passportaddress' => 'г. Сочи, ул. Победы д. 17 кв. 4',
            'rank' => 'майор полиции',
            'lengthservice' => 22,
            'lengthservicepolice' => 12,
            'retirementstatus' => 'В отставке',
            'retirementyear' => 2021,
            'certificatenumber' => '0219',
            'certificatevalidity' => '2023-07-03',
            'status' => 'Ветеран',
            'yearentrytopolice' => 2008,
            'duty' => 'Актив',
            'mobilephone' => '89881234567',
            'reservephone' => '89887654321',
            'email' => 'test2@mail.ru',
            'passport' => '03 22 687533',
            'awards' => 'за выслугу лет',
            'disability' => '2 группа',
            'hostilitiesparticipation' => 'Карабах',
            'additionally' => '',
            'yearofdismissal' => '2022',
        ];

        $jsonData[] = [
            'id' => 100500,
            'firstname' => 'Иван',
            'lastname' => 'Ивановванов',
            'middlename' => 'Иванович',
            'birthdate' => '25 марта 1970 г.',
            'age' => '53 года',
            'liveaddress' => 'Сочи',
            'passaddress' => 'г. Сочи, ул. Победы д. 17 кв. 4',
            'rank' => 'майор полиции',
            'lengthservice' => '22 года',
            'lengthservicepolice' => '12 лет',
            'retirementstatus' => 'В отставке',
            'retirementyear' => 2021,
            'certnumber' => '0219',
            'validity' => '03 июля 2023 г.',
            'status' => 'Ветеран',
            'yearentrytopolice' => 2008,
            'duty' => 'Актив',
            'mobphone' => '89881234567',
            'reservephone' => '89887654321',
            'email' => 'test2@mail.ru',
            'passport' => '03 22 687533',
            'awards' => 'за выслугу лет',
            'disability' => '2 группа',
            'participation' => 'Карабах',
            'yeardismissal' => 2022,
        ];

        $veteran->addData($data);

        $this->assertSame(json_encode($jsonData, JSON_UNESCAPED_UNICODE), json_encode($veteran->veteranByLastName('Ивановванов'), JSON_UNESCAPED_UNICODE));

        $veteran->deleteData(100500);

    }
}
