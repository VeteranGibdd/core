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
            'liveAddress' => $this->dbRow['live_address'] ?? null,
            'passportAddress' => $this->dbRow['address'] ?? null,
            'rank' => $this->dbRow['rank'] ?? null,
            'lengthService' => $this->dbRow['length_service'] ?? null,
            'lengthServicePolice' => $this->dbRow['length_service_police'] ?? null,
            'retirementStatus' => $this->dbRow['retirement_status'] ?? null,
            'retirementYear' => $this->dbRow['retirement_year'] ?? null,
            'certNumber' => $this->dbRow['certificate_number'] ?? null,
            'validity' => $this->dbRow['certificate_validity'] ?? null,
            'status' => $this->dbRow['status'] ?? null,
            'yearEntryToVeteranOrg' => $this->dbRow['year_entry_to_veteran_org'] ?? null,
            'duty' => $this->dbRow['duty'] ?? null,
            'mobilePhone' => $this->dbRow['mobile_phone'] ?? null,
            'reservePhone' => $this->dbRow['reserve_phone'] ?? null,
            'email' => $this->dbRow['email'] ?? null,
            'passport' => $this->dbRow['serial_number'] ?? null,
            'awards' => $this->dbRow['awards'] ?? null,
            'disability' => $this->dbRow['disability'] ?? null,
            'hostilitiesParticipation' => $this->dbRow['hostilities_participation'] ?? null,
            'additionally' => $this->dbRow['additionally'] ?? null,
            'yearOfDismissal' => $this->dbRow['year_of_dismissal'] ?? null,
        ];

        return array_diff($veteran, array(NULL));
    }

}
