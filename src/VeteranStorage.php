<?php

namespace Gibdd\Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use stdClass;

class VeteranStorage
{
    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Create Veteran by id
     * @param int $id
     * @return Veteran
     * @throws Exception
     */
    public function byId(int $id): Veteran
    {
        return new Veteran($this->db->fetchAssociative('SELECT * FROM veterans WHERE id IN (?)', [$id]));
    }

    /**
     * Create array with all veterans
     * @return array
     * @throws Exception
     */
    public function allVeterans(): array
    {
        $result = [];
        foreach ($this->db->fetchAllAssociative('SELECT * FROM veterans') as $dbRow) {
            $result[] = new Veteran($dbRow);
        }
        return $result;
    }

    /**
     * Add data to database
     * @param stdClass $data
     * @return void
     * @throws Exception
     */
    public function addData(stdClass $data): void
    {
        $builder = $this->db->createQueryBuilder();
        $builder->insert('veterans');
        $builder->setValue('id', $builder->createNamedParameter($data->id));
        $builder->setValue('first_name', $builder->createNamedParameter($data->firstName));
        $builder->setValue('last_name', $builder->createNamedParameter($data->lastName));
        $builder->setValue('middle_name', $builder->createNamedParameter($data->middleName));
        $builder->setValue('birth_date', $builder->createNamedParameter($data->birthDate));
        $builder->setValue('live_address', $builder->createNamedParameter($data->liveAddress ?? null));
        $builder->setValue('passport_address', $builder->createNamedParameter($data->passportAddress ?? null));
        $builder->setValue('rank', $builder->createNamedParameter($data->rank ?? null));
        $builder->setValue('length_service', $builder->createNamedParameter($data->lengthService ?? null));
        $builder->setValue('length_service_police', $builder->createNamedParameter($data->lengthServicePolice ?? null));
        $builder->setValue('retirement_status', $builder->createNamedParameter($data->retirementStatus));
        $builder->setValue('retirement_year', $builder->createNamedParameter($data->retirementYear ?? null));
        $builder->setValue('certificate_number', $builder->createNamedParameter($data->certificateNumber ?? null));
        $builder->setValue('certificate_validity', $builder->createNamedParameter($data->certificateValidity ?? null));
        $builder->setValue('status', $builder->createNamedParameter($data->status));
        $builder->setValue('year_entry_to_police', $builder->createNamedParameter($data->yearEntryToPolice ?? null));
        $builder->setValue('duty', $builder->createNamedParameter($data->duty ?? null));
        $builder->setValue('mobile_phone', $builder->createNamedParameter($data->mobilePhone ?? null));
        $builder->setValue('reserve_phone', $builder->createNamedParameter($data->reservePhone ?? null));
        $builder->setValue('email', $builder->createNamedParameter($data->email ?? null));
        $builder->setValue('passport', $builder->createNamedParameter($data->passport ?? null));
        $builder->setValue('awards', $builder->createNamedParameter($data->awards ?? null));
        $builder->setValue('disability', $builder->createNamedParameter($data->disability ?? null));
        $builder->setValue('hostilities_participation', $builder->createNamedParameter($data->hostilitiesParticipation ?? null));
        $builder->setValue('additionally', $builder->createNamedParameter($data->additionally ?? null));
        $builder->setValue('year_of_dismissal', $builder->createNamedParameter($data->yearOfDismissal ?? null));
        $builder->executeQuery();
    }

    /**
     * Update data to database by id
     * @param stdClass $data
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function updateById(stdClass $data, int $id): void
    {
        $builder = $this->db->createQueryBuilder();
        $builder->update('veterans');
        $builder->set('first_name', empty($data->firstName) ? 'first_name' : $builder->createNamedParameter($data->firstName));
        $builder->set('last_name', empty($data->lastName) ? 'last_name' : $builder->createNamedParameter($data->lastName));
        $builder->set('middle_name', empty($data->middleName) ? 'middle_name' : $builder->createNamedParameter($data->middleName));
        $builder->set('birth_date', empty($data->birthDate) ? 'birth_date' : $builder->createNamedParameter($data->birthDate));
        $builder->set('live_address', empty($data->liveAddress) ? 'live_address' : $builder->createNamedParameter($data->liveAddress));
        $builder->set('passport_address', empty($data->passportAddress) ? 'passport_address' : $builder->createNamedParameter($data->passportAddress));
        $builder->set('rank', empty($data->rank) ? 'rank' : $builder->createNamedParameter($data->rank));
        $builder->set('length_service', empty($data->lengthService) ? 'length_service' : $builder->createNamedParameter($data->lengthService));
        $builder->set('length_service_police', empty($data->lengthServicePolice) ? 'length_service_police' : $builder->createNamedParameter($data->lengthServicePolice));
        $builder->set('retirement_status', empty($data->retirementStatus) ? 'retirement_status' : $builder->createNamedParameter($data->retirementStatus));
        $builder->set('retirement_year', empty($data->retirementYear) ? 'retirement_year' : $builder->createNamedParameter($data->retirementYear));
        $builder->set('certificate_number', empty($data->certificateNumber) ? 'certificate_number' : $builder->createNamedParameter($data->certificateNumber));
        $builder->set('certificate_validity', empty($data->certificateValidity) ? 'certificate_validity' : $builder->createNamedParameter($data->certificateValidity));
        $builder->set('status', empty($data->status) ? 'status' : $builder->createNamedParameter($data->status));
        $builder->set('year_entry_to_police', empty($data->yearEntryToPolice) ? 'year_entry_to_police' : $builder->createNamedParameter($data->yearEntryToPolice));
        $builder->set('duty', empty($data->duty) ? 'duty' : $builder->createNamedParameter($data->duty));
        $builder->set('mobile_phone', empty($data->mobilePhone) ? 'mobile_phone' : $builder->createNamedParameter($data->mobilePhone));
        $builder->set('reserve_phone', empty($data->reservePhone) ? 'reserve_phone' : $builder->createNamedParameter($data->reservePhone));
        $builder->set('email', empty($data->email) ? 'email' : $builder->createNamedParameter($data->email));
        $builder->set('passport', empty($data->passport) ? 'passport' : $builder->createNamedParameter($data->passport));
        $builder->set('awards', empty($data->awards) ? 'awards' : $builder->createNamedParameter($data->awards));
        $builder->set('disability', empty($data->disability) ? 'disability' : $builder->createNamedParameter($data->disability));
        $builder->set('hostilities_participation', empty($data->hostilitiesParticipation) ? 'hostilities_participation' : $builder->createNamedParameter($data->hostilitiesParticipation));
        $builder->set('additionally', empty($data->additionally) ? 'additionally' : $builder->createNamedParameter($data->additionally));
        $builder->set('year_of_dismissal', empty($data->yearOfDismissal) ? 'year_of_dismissal' : $builder->createNamedParameter($data->yearOfDismissal));
        $builder->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery();
    }

    /**
     * Delete all data from table
     * @return void
     * @throws Exception
     */
    public function deleteData(): void
    {
        $this->db->executeQuery('DELETE FROM veterans');
    }

}
