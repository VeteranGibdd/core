<?php

namespace Gibdd\Core;

use Doctrine\DBAL\Connection;

class VeteranStorage
{
    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function veteranById(int $id): array
    {
        $result = [];
        foreach ($this->db->fetchAllAssociative('SELECT * FROM veterans WHERE id IN (?)', [$id]) as $dbRow) {
            $result[] = new Veteran($dbRow);
        }
        return $result;
    }

    public function allVeterans(): array
    {
        $result = [];
        foreach ($this->db->fetchAllAssociative('SELECT * FROM veterans') as $dbRow) {
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
            ->setParameter(5, $data['liveaddress'] ?? null)
            ->setParameter(6, $data['passportaddress'] ?? null)
            ->setParameter(7, $data['rank'] ?? null)
            ->setParameter(8, $data['lengthservice'] ?? null)
            ->setParameter(9, $data['lengthservicepolice'] ?? null)
            ->setParameter(10, $data['retirementstatus'])
            ->setParameter(11, $data['retirementyear'] ?? null)
            ->setParameter(12, $data['certificatenumber'] ?? null)
            ->setParameter(13, $data['certificatevalidity'] ?? null)
            ->setParameter(14, $data['status'])
            ->setParameter(15, $data['yearentrytopolice'] ?? null)
            ->setParameter(16, $data['duty'] ?? null)
            ->setParameter(17, $data['mobilephone'] ?? null)
            ->setParameter(18, $data['reservephone'] ?? null)
            ->setParameter(19, $data['email'] ?? null)
            ->setParameter(20, $data['passport'] ?? null)
            ->setParameter(21, $data['awards'] ?? null)
            ->setParameter(22, $data['disability'] ?? null)
            ->setParameter(23, $data['hostilitiesparticipation'] ?? null)
            ->setParameter(24, $data['additionally'] ?? null)
            ->setParameter(25, $data['yearofdismissal'] ?? null)
            ->executeQuery();
    }

    public function deleteData(int $id): void
    {
        $this->db->executeQuery('DELETE FROM veterans where id IN (?)',[$id]);
    }

}
