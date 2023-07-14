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

}
