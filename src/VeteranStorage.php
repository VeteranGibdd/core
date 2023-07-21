<?php

namespace Gibdd\Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use stdClass;

class VeteranStorage
{
    const VETERANS_TABLE_NAME = 'veterans';
    const PASSPORTS_TABLE_NAME = 'passports';
    const DUTY_TABLE_NAME = 'duty';
    const ORGANISATION_TABLE_NAME = 'organisation';
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
        return new Veteran($this->db->fetchAssociative('
        SELECT *
        FROM veterans v
        LEFT JOIN passports p ON v.id = p.id
        LEFT JOIN duty d on v.id = d.id
        LEFT JOIN organisation o on v.id = o.id
WHERE v.id IN (?)', [$id]));
    }

    /**
     * Create array with all veterans
     * @return array
     * @throws Exception
     */
    public function allVeterans(): array
    {
        $result = [];
        foreach ($this->db->fetchAllAssociative('
        SELECT *
        FROM veterans v
        LEFT JOIN passports p ON v.id = p.id
        LEFT JOIN duty d on v.id = d.id
        LEFT JOIN organisation o on v.id = o.id') as $dbRow) {
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
    public function add(stdClass $data): void
    {
        $mapper = new VeteranMapper($data);

        try {
            $this->db->beginTransaction();

            $mappedPassportRow = $mapper->mappedPassportRow();
            $this->db->insert(self::PASSPORTS_TABLE_NAME, $mappedPassportRow);

            $dutyId = $organisationId = $veteranId = $this->db->lastInsertId();

            $mapper->addDutyId($dutyId);
            $mappedDutyRow = $mapper->mappedDutyRow();
            $this->db->insert(self::DUTY_TABLE_NAME, $mappedDutyRow);

            $mapper->addOrganisationId($organisationId);
            $mappedOrganisationRow = $mapper->mappedOrganisationRow();
            $this->db->insert(self::ORGANISATION_TABLE_NAME, $mappedOrganisationRow);

            $mapper->addVeteranId($veteranId);
            $mappedVetRow = $mapper->mappedVeteranRow();
            $this->db->insert(self::VETERANS_TABLE_NAME, $mappedVetRow);

            $this->db->commit();

        } catch (\Exception $exception) {
            $this->db->rollBack();
        }
    }

    /**
     * Update data to database by id
     * @param stdClass $data
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function update(stdClass $data, int $id): void
    {
        $mapper = new VeteranMapper($data);
        $mappedVetRow = $mapper->mappedVeteranRow();
        $mappedPassportRow = $mapper->mappedPassportRow();
        $mappedDutyRow = $mapper->mappedDutyRow();
        $mappedRetirementRow = $mapper->mappedOrganisationRow();

        try {
            $this->db->beginTransaction();
            $this->db->update(self::VETERANS_TABLE_NAME, $mappedVetRow, ['id' => $id]);
            $this->db->update(self::PASSPORTS_TABLE_NAME, $mappedPassportRow, ['id' => $id]);
            $this->db->update(self::DUTY_TABLE_NAME, $mappedDutyRow, ['id' => $id]);
            $this->db->update(self::ORGANISATION_TABLE_NAME, $mappedRetirementRow, ['id' => $id]);

            $this->db->commit();

        } catch (\Exception $exception) {
            $this->db->rollBack();
        }

    }

    /**
     * Delete all data from tables by veteran.id
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function delete(int $id): void
    {
        $this->db->executeQuery('
DELETE FROM veterans WHERE id IN (?);
DELETE FROM passports WHERE passports.id IN (?);
DELETE FROM organisation WHERE organisation.id IN (?);
DELETE FROM duty WHERE duty.id IN (?);', [$id]);
    }

}
