<?php

namespace Gibdd\Core;

use JsonSerializable;

class Veteran implements JsonSerializable
{
    private array $dbRow;

    public function __construct(array $dbRow)
    {
        $this->dbRow = $dbRow;
    }

    public function jsonSerialize(): array
    {
        $veteran = [
            'id' => $this->dbRow['id'],
            'firstName' => $this->dbRow['first_name'],
            'lastName' => $this->dbRow['last_name'],
            'middleName' => $this->dbRow['middle_name'],
            'birthDate' => $this->dbRow['birth_date'],
            'district' => $this->dbRow['district'] ?? null,
            'address' => $this->dbRow['address'] ?? null,
            'mobilePhone' => $this->dbRow['mobile_phone'] ?? null,
            'reservePhone' => $this->dbRow['reserve_phone'] ?? null,
            'email' => $this->dbRow['email'] ?? null,
            'disability' => $this->dbRow['disability'] ?? null,
            'additionally' => $this->dbRow['additionally'] ?? null,

            'serial' => $this->dbRow['serial'] ?? null,
            'number' => $this->dbRow['number'] ?? null,
            'dateOfIssue' => $this->dbRow['date_of_issue'] ?? null,

            'status' => $this->dbRow['status'] ?? null,
            'joiningYear' => $this->dbRow['joining_year'] ?? null,
            'role' => $this->dbRow['role'] ?? null,
            'certNumber' => $this->dbRow['certificate_number'] ?? null,
            'validity' => $this->dbRow['certificate_validity'] ?? null,

            'rank' => $this->dbRow['rank'] ?? null,
            'lengthService' => $this->dbRow['length_service'] ?? null,
            'lengthServicePolice' => $this->dbRow['length_service_traffic_police'] ?? null,
            'dutyStatus' => $this->dbRow['duty_status'] ?? null,
            'retirementYear' => $this->dbRow['retirement_year'] ?? null,
            'awards' => $this->dbRow['awards'] ?? null,
            'hostilitiesParticipation' => $this->dbRow['hostilities_participation'] ?? null,
        ];

        return array_diff($veteran, array(NULL));
    }

}
