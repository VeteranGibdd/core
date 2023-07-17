<?php

namespace Gibdd\Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Log\NullLogger;

class VeteranStorage
{
    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function byId(int $id): Veteran
    {
        return new Veteran($this->db->fetchAssociative('SELECT * FROM veterans WHERE id IN (?)', [$id]));
    }

    public function allVeterans(): array
    {
        $result = [];
        foreach ($this->db->fetchAllAssociative('SELECT * FROM veterans') as $dbRow) {
            $result[] = new Veteran($dbRow);
        }
        return $result;
    }

    public function addData(\stdClass $data): void
    {
        $builder = $this->db->createQueryBuilder();
        $builder->insert('veterans');
        $builder->setValue('id', $builder->createNamedParameter($data->id));
        $builder->setValue('first_name', $builder->createNamedParameter($data->firstname));
        $builder->setValue('last_name', $builder->createNamedParameter($data->lastname));
        $builder->setValue('middle_name', $builder->createNamedParameter($data->middlename));
        $builder->setValue('birth_date', $builder->createNamedParameter($data->birthdate));
        $builder->setValue('live_address', $builder->createNamedParameter($data->liveaddress ?? null));
        $builder->setValue('passport_address', $builder->createNamedParameter($data->passportaddress ?? null));
        $builder->setValue('rank', $builder->createNamedParameter($data->rank ?? null));
        $builder->setValue('length_service', $builder->createNamedParameter($data->lengthservice ?? null));
        $builder->setValue('length_service_police', $builder->createNamedParameter($data->lengthservicepolice ?? null));
        $builder->setValue('retirement_status', $builder->createNamedParameter($data->retirementstatus));
        $builder->setValue('retirement_year', $builder->createNamedParameter($data->retirementyear ?? null));
        $builder->setValue('certificate_number', $builder->createNamedParameter($data->certificatenumber ?? null));
        $builder->setValue('certificate_validity', $builder->createNamedParameter($data->certificatevalidity ?? null));
        $builder->setValue('status', $builder->createNamedParameter($data->status));
        $builder->setValue('year_entry_to_police', $builder->createNamedParameter($data->yearentrytopolice ?? null));
        $builder->setValue('duty', $builder->createNamedParameter($data->duty ?? null));
        $builder->setValue('mobile_phone', $builder->createNamedParameter($data->mobilephone ?? null));
        $builder->setValue('reserve_phone', $builder->createNamedParameter($data->reservephone ?? null));
        $builder->setValue('email', $builder->createNamedParameter($data->email ?? null));
        $builder->setValue('passport', $builder->createNamedParameter($data->passport ?? null));
        $builder->setValue('awards', $builder->createNamedParameter($data->awards ?? null));
        $builder->setValue('disability', $builder->createNamedParameter($data->disability ?? null));
        $builder->setValue('hostilities_participation', $builder->createNamedParameter($data->hostilitiesparticipation ?? null));
        $builder->setValue('additionally', $builder->createNamedParameter($data->additionally ?? null));
        $builder->setValue('year_of_dismissal', $builder->createNamedParameter($data->yearofdismissal ?? null));
        $builder->executeQuery();
    }

    public function updateById(\stdClass $data, int $id): void
    {
        $builder = $this->db->createQueryBuilder();
        $builder->update('veterans');
        $builder->set('first_name', empty($data->firstname) ? 'first_name' : $builder->createNamedParameter($data->firstname));
        $builder->set('last_name', empty($data->lastname) ? 'last_name' : $builder->createNamedParameter($data->lastname));
        $builder->set('middle_name', empty($data->middlename) ? 'middle_name' : $builder->createNamedParameter($data->middlename));
        $builder->set('birth_date', empty($data->birthdate) ? 'birth_date' : $builder->createNamedParameter($data->birthdate));
        $builder->set('live_address', empty($data->liveaddress) ? 'live_address' : $builder->createNamedParameter($data->liveaddress));
        $builder->set('passport_address', empty($data->passportaddress) ? 'passport_address' : $builder->createNamedParameter($data->passportaddress));
        $builder->set('rank', empty($data->rank) ? 'rank' : $builder->createNamedParameter($data->rank));
        $builder->set('length_service', empty($data->lengthservice) ? 'length_service' : $builder->createNamedParameter($data->lengthservice));
        $builder->set('length_service_police', empty($data->lengthservicepolice) ? 'length_service_police' : $builder->createNamedParameter($data->lengthservicepolice));
        $builder->set('retirement_status', empty($data->retirementstatus) ? 'retirement_status' : $builder->createNamedParameter($data->retirementstatus));
        $builder->set('retirement_year', empty($data->retirementyear) ? 'retirement_year' : $builder->createNamedParameter($data->retirementyear));
        $builder->set('certificate_number', empty($data->certificatenumber) ? 'certificate_number' : $builder->createNamedParameter($data->certificatenumber));
        $builder->set('certificate_validity', empty($data->certificatevalidity) ? 'certificate_validity' : $builder->createNamedParameter($data->certificatevalidity));
        $builder->set('status', empty($data->status) ? 'status' : $builder->createNamedParameter($data->status));
        $builder->set('year_entry_to_police', empty($data->yearentrytopolice) ? 'year_entry_to_police' : $builder->createNamedParameter($data->yearentrytopolice));
        $builder->set('duty', empty($data->duty) ? 'duty' : $builder->createNamedParameter($data->duty));
        $builder->set('mobile_phone', empty($data->mobilephone) ? 'mobile_phone' : $builder->createNamedParameter($data->mobilephone));
        $builder->set('reserve_phone', empty($data->reservephone) ? 'reserve_phone' : $builder->createNamedParameter($data->reservephone));
        $builder->set('email', empty($data->email) ? 'email' : $builder->createNamedParameter($data->email));
        $builder->set('passport', empty($data->passport) ? 'passport' : $builder->createNamedParameter($data->passport));
        $builder->set('awards', empty($data->awards) ? 'awards' : $builder->createNamedParameter($data->awards));
        $builder->set('disability', empty($data->disability) ? 'disability' : $builder->createNamedParameter($data->disability));
        $builder->set('hostilities_participation', empty($data->hostilitiesparticipation) ? 'hostilities_participation' : $builder->createNamedParameter($data->hostilitiesparticipation));
        $builder->set('additionally', empty($data->additionally) ? 'additionally' : $builder->createNamedParameter($data->additionally));
        $builder->set('year_of_dismissal', empty($data->yearofdismissal) ? 'year_of_dismissal' : $builder->createNamedParameter($data->yearofdismissal));
        $builder->where( 'id = :id')
            ->setParameter('id', $id)
            ->executeQuery();
    }

    public function deleteData(): void
    {
        $this->db->executeQuery('DELETE FROM veterans');
    }

}
