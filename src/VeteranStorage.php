<?php

namespace Gibdd\Core;

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class VeteranStorage
{
    private Connection $db;

    public function __construct($config)
    {
        $this->db = DriverManager::getConnection($config);
    }

    public function veteranByLastName(string $lastName): array
    {
        $stmt = $this->db->prepare(
            <<<SQL
            SELECT *
            FROM veterans
            where last_name = :last_name;
            SQL
        );
        $dbRows = $stmt->executeQuery(['last_name' => $lastName]);
        $result = [];
        foreach ($dbRows->fetchAllAssociative() as $dbRow) {
            $result[] = new Veteran($dbRow);
        }
        return $result;
    }

    public function allVeterans(): array
    {
        $dbRows = $this->db->executeQuery(
            <<<SQL
            SELECT *
            FROM veterans
            ORDER BY id ASC
            SQL
        );
        $result = [];
        foreach ($dbRows->fetchAllAssociative() as $dbRow) {
            $result[] = new Veteran($dbRow);
        }
        return $result;
    }

    public function addData(array $data): void
    {
        $builder = $this->db->createQueryBuilder();
        $builder
            ->insert('veterans')
            ->values(
                [
                    'id' => '?',
                    'first_name' => '?',
                    'last_name' => '?',
                    'middle_name' => '?',
                    'birth_date' => '?',
                    'live_address' => '?',
                    'passport_address' => '?',
                    'rank' => '?',
                    'length_service' => '?',
                    'length_service_police' => '?',
                    'retirement_status' => '?',
                    'retirement_year' => '?',
                    'certificate_number' => '?',
                    'certificate_validity' => '?',
                    'status' => '?',
                    'year_entry_to_police' => '?',
                    'duty' => '?',
                    'mobile_phone' => '?',
                    'reserve_phone' => '?',
                    'email' => '?',
                    'passport' => '?',
                    'awards' => '?',
                    'disability' => '?',
                    'hostilities_participation' => '?',
                    'additionally' => '?',
                    'year_of_dismissal' => '?',
                ]
            )
            ->setParameter(0, $data['id'])
            ->setParameter(1, $data['firstname'])
            ->setParameter(2, $data['lastname'])
            ->setParameter(3, $data['middlename'])
            ->setParameter(4, $data['birthdate'])
            ->setParameter(5, $data['liveaddress'])
            ->setParameter(6, $data['passportaddress'])
            ->setParameter(7, $data['rank'])
            ->setParameter(8, $data['lengthservice'])
            ->setParameter(9, $data['lengthservicepolice'])
            ->setParameter(10, $data['retirementstatus'])
            ->setParameter(11, $data['retirementyear'])
            ->setParameter(12, $data['certificatenumber'])
            ->setParameter(13, $data['certificatevalidity'])
            ->setParameter(14, $data['status'])
            ->setParameter(15, $data['yearentrytopolice'])
            ->setParameter(16, $data['duty'])
            ->setParameter(17, $data['mobilephone'])
            ->setParameter(18, $data['reservephone'])
            ->setParameter(19, $data['email'])
            ->setParameter(20, $data['passport'])
            ->setParameter(21, $data['awards'])
            ->setParameter(22, $data['disability'])
            ->setParameter(23, $data['hostilitiesparticipation'])
            ->setParameter(24, $data['additionally'])
            ->setParameter(25, $data['yearofdismissal'])
            ->executeQuery();
    }

    public function deleteData(int $id): void
    {
        $stmt = $this->db->prepare(
            <<<SQL
            DELETE
            FROM veterans
            where id = :id;
            SQL
        );
        $stmt->executeQuery(['id' => $id]);
    }

}
