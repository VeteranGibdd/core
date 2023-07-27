<?php

namespace Gibdd\Core\Tests\Unit;

use Gibdd\Core\Veteran;
use PHPUnit\Framework\TestCase;
use function Gibdd\Core\testVeteranValidation;

class VeteranTest extends TestCase
{
    public function testJsonSerialize()
    {
        $vetData = [
            'id' => 100500,
            'first_name' => 'Иван',
            'last_name' => 'Ивановванов',
            'middle_name' => 'Иванович',
            'birth_date' => '1970-03-25',
            'district' => 'Сочи',
            'address' => 'г. Сочи, ул. Победы д. 17 кв. 4',
            'mobile_phone' => '89881234567',
            'reserve_phone' => '89887654321',
            'disability' => 2,
            'email' => 'test2@mail.ru',

//            'passport' => [
            'serial' => '0322',
            'number' => '687533',
            'date_of_issue' => '2027-08-13',
//            ],

//            'policeDuty' => [
            'rank' => 'майор полиции',
            'length_service' => 22,
            'length_service_traffic_police' => 12,
            'duty_status' => 'В отставке',
            'retirement_year' => 2021,
            'awards' => 'за выслугу лет',
            'hostilities_participation' => 'Карабах',
//            ],

//            'organisation' => [
            'status' => 'Ветеран',
            'joining_year' => 2008,
            'role' => 'Актив',
            'certificate_number' => '0219',
            'certificate_validity' => '2023-07-03',
//            ],
        ];

        $vetDataJson = [
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
            'disability' => 2,

            'passport' => [
                'serial' => '0322',
                'number' => '687533',
                'dateOfIssue' => '2027-08-13',
            ],

            'policeDuty' => [
                'rank' => 'майор полиции',
                'lengthService' => 22,
                'lengthServiceTrafficPolice' => 12,
                'dutyStatus' => 'В отставке',
                'retirementYear' => 2021,
                'awards' => 'за выслугу лет',
                'hostilitiesParticipation' => 'Карабах',
            ],

            'organisation' => [
                'status' => 'Ветеран',
                'joiningYear' => 2008,
                'role' => 'Актив',
                'certNumber' => '0219',
                'validity' => '2023-07-03',
            ],
        ];

        $veteran = new Veteran($vetData);

        testVeteranValidation(json_encode($veteran, JSON_UNESCAPED_UNICODE));

        $this->assertSame(json_encode($vetDataJson, JSON_UNESCAPED_UNICODE), json_encode($veteran, JSON_UNESCAPED_UNICODE));
    }

}
