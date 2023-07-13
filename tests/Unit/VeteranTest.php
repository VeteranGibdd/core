<?php

namespace Gibdd\Core\Tests\Unit;

use Gibdd\Core\Veteran;
use PHPUnit\Framework\TestCase;

class VeteranTest extends TestCase
{
    public function testJsonSerialize()
    {
        $vetData = [
            'id' => 1,
            'first_name' => 'Джон',
            'last_name' => 'Тестовый',
            'middle_name' => 'Деппович',
            'birth_date' => '1978-05-27',
            'live_address' => 'Хоста',
            'passport_address' => 'г.Сочи, Хоста, п. Кудепста, ул. Калиновая, д.6',
            'rank' => 'Капитан полиции',
            'length_service' => 31,
            'length_service_police' => 20,
            'retirement_status' => 'В отставке',
            'retirement_year' => 2018,
            'certificate_number' => 'ККС № 0205',
            'certificate_validity' => '2023-07-03',
            'status' => 'Ветеран',
            'year_entry_to_police' => 2012,
            'duty' => 'Актив',
            'mobile_phone' => 89881234567,
            'reserve_phone' => 2123456,
            'email' => 'test@mail.ru',
            'passport' => '03 20 682534',
            'awards' => 'за выслугу лет',
            'disability' => '2 группа',
            'hostilities_participation' => 'Карабах',
            'additionally' => 'Большой молодец',
            'year_of_dismissal' => 2022,
        ];

        $vetDataJson = [
            'id' => 1,
            'firstname' => 'Джон',
            'lastname' => 'Тестовый',
            'middlename' => 'Деппович',
            'birthdate' => '27 мая 1978 г.',
            'age' => '45 лет',
            'liveaddress' => 'Хоста',
            'paspaddress' => 'г.Сочи, Хоста, п. Кудепста, ул. Калиновая, д.6',
            'rank' => 'Капитан полиции',
            'lengthservice' => '31 год',
            'lengthservicepolice' => '20 лет',
            'retirementstatus' => 'В отставке',
            'retirementyear' => 2018,
            'certnumber' => 'ККС № 0205',
            'validity' => '03 июля 2023 г.',
            'status' => 'Ветеран',
            'yearentrytopolice' => 2012,
            'duty' => 'Актив',
            'mobphone' => 89881234567,
            'reservephone' => 2123456,
            'email' => 'test@mail.ru',
            'passport' => '03 20 682534',
            'awards' => 'за выслугу лет',
            'disability' => '2 группа',
            'participation' => 'Карабах',
            'additionally' => 'Большой молодец',
            'yeardismissal' => 2022,
        ];

        $veteran = new Veteran($vetData);

        $this->assertSame(json_encode($vetDataJson, JSON_UNESCAPED_UNICODE), json_encode($veteran, JSON_UNESCAPED_UNICODE));
    }

}
