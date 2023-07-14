<?php

namespace Gibdd\Core;

use IntlDateFormatter;
use DateTime;
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
            'firstname' => $this->dbRow['first_name'],
            'lastname' => $this->dbRow['last_name'],
            'middlename' => $this->dbRow['middle_name'],
            'birthdate' => $this->dbRow['birth_date'],
            'liveaddress' => $this->dbRow['live_address'] ?? null,
            'paspaddress' => $this->dbRow['passport_address'] ?? null,
            'rank' => $this->dbRow['rank'] ?? null,
            'lengthservice' => $this->dbRow['length_service'] ?? null,
            'lengthservicepolice' => $this->dbRow['length_service_police'] ?? null,
            'retirementstatus' => $this->dbRow['retirement_status'],
            'retirementyear' => $this->dbRow['retirement_year'] ?? null,
            'certnumber' => $this->dbRow['certificate_number'] ?? null,
            'validity' => $this->dbRow['certificate_validity'] ?? null,
            'status' => $this->dbRow['status'],
            'yearentrytopolice' => $this->dbRow['year_entry_to_police'] ?? null,
            'duty' => $this->dbRow['duty'] ?? null,
            'mobphone' => $this->dbRow['mobile_phone'] ?? null,
            'reservephone' => $this->dbRow['reserve_phone'] ?? null,
            'email' => $this->dbRow['email'] ?? null,
            'passport' => $this->dbRow['passport'] ?? null,
            'awards' => $this->dbRow['awards'] ?? null,
            'disability' => $this->dbRow['disability'] ?? null,
            'participation' => $this->dbRow['hostilities_participation'] ?? null,
            'additionally' => $this->dbRow['additionally'] ?? null,
            'yeardismissal' => $this->dbRow['year_of_dismissal'] ?? null,
        ];

        return array_diff($veteran, array('', NULL, false));
    }

}
