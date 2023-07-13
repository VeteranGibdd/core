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
        /**
         * Count age from birthday
         * @param string $birthday
         * @return int
         */
        function calculateAge(string $birthday): int
        {
            $birthday_timestamp = strtotime($birthday);
            $age = date('Y') - date('Y', $birthday_timestamp);
            if (date('md', $birthday_timestamp) > date('md')) {
                $age--;
            }
            return $age;
        }

        /**
         * Add "год, года, лет" to year
         * @param int $year
         * @return string
         */
        function yearTextArg(int $year): string
        {
            $year = abs($year);
            $t1 = $year % 10;
            $t2 = $year % 100;
            return $year . ' ' . ($t1 == 1 && $t2 != 11 ? "год" : ($t1 >= 2 && $t1 <= 4 && ($t2 < 10 || $t2 >= 20) ? "года" : "лет"));
        }

        /**
         * Reformat date
         * @param DateTime $date
         * @return string
         */
        function getDate(DateTime $date): string
        {
            $intlFormatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::MEDIUM, IntlDateFormatter::MEDIUM);
            $intlFormatter->setPattern('dd MMMM yyyy' . ' г.');
            return $intlFormatter->format($date);
        }

        $birthdate = new DateTime($this->dbRow['birth_date']);
        $validity = new DateTime($this->dbRow['certificate_validity']);

        return [
            'id' => $this->dbRow['id'],
            'firstname' => $this->dbRow['first_name'],
            'lastname' => $this->dbRow['last_name'],
            'middlename' => $this->dbRow['middle_name'],
            'birthdate' => getDate($birthdate),
            'age' => yearTextArg(calculateAge($this->dbRow['birth_date'])),
            'liveaddress' => $this->dbRow['live_address'],
            'paspaddress' => $this->dbRow['passport_address'],
            'rank' => $this->dbRow['rank'],
            'lengthservice' => yearTextArg($this->dbRow['length_service']),
            'lengthservicepolice' => yearTextArg($this->dbRow['length_service_police']),
            'retirementstatus' => $this->dbRow['retirement_status'],
            'retirementyear' => $this->dbRow['retirement_year'],
            'certnumber' => $this->dbRow['certificate_number'],
            'validity' => getDate($validity),
            'status' => $this->dbRow['status'],
            'yearentrytopolice' => $this->dbRow['year_entry_to_police'],
            'duty' => $this->dbRow['duty'],
            'mobphone' => $this->dbRow['mobile_phone'],
            'reservephone' => $this->dbRow['reserve_phone'],
            'email' => $this->dbRow['email'],
            'passport' => $this->dbRow['passport'],
            'awards' => $this->dbRow['awards'],
            'disability' => $this->dbRow['disability'],
            'participation' => $this->dbRow['hostilities_participation'],
            'additionally' => $this->dbRow['additionally'],
            'yeardismissal' => $this->dbRow['year_of_dismissal'],
        ];
    }

}
