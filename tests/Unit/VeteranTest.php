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
            'certificate_number' => 0205,
            'certificate_validity' => '2023-07-03',
            'status' => 'Ветеран',
            'year_entry_to_police' => 2012,
            'duty' => 'Актив',
            'mobile_phone' => '89881234567',
            'reserve_phone' => '2123456',
            'email' => 'test@mail.ru',
            'passport' => '03 20 682534',
            'awards' => 'за выслугу лет',
            'disability' => '2 группа',
            'hostilities_participation' => 'Карабах',
            'additionally' => '',
            'year_of_dismissal' => 2022,
        ];

        $vetDataJson = [
            'id' => 1,
            'firstName' => 'Джон',
            'lastName' => 'Тестовый',
            'middleName' => 'Деппович',
            'birthDate' => '1978-05-27',
            'liveAddress' => 'Хоста',
            'passportAddress' => 'г.Сочи, Хоста, п. Кудепста, ул. Калиновая, д.6',
            'rank' => 'Капитан полиции',
            'lengthService' => 31,
            'lengthServicePolice' => 20,
            'retirementStatus' => 'В отставке',
            'retirementYear' => 2018,
            'certNumber' => 0205,
            'validity' => '2023-07-03',
            'status' => 'Ветеран',
            'yearEntryToPolice' => 2012,
            'duty' => 'Актив',
            'mobilePhone' => '89881234567',
            'reservePhone' => '2123456',
            'email' => 'test@mail.ru',
            'passport' => '03 20 682534',
            'awards' => 'за выслугу лет',
            'disability' => '2 группа',
            'hostilitiesParticipation' => 'Карабах',
            'yearOfDismissal' => 2022,
        ];

        $veteran = new Veteran($vetData);

        $this->assertSame(json_encode($vetDataJson, JSON_UNESCAPED_UNICODE), json_encode($veteran, JSON_UNESCAPED_UNICODE));
    }

}
