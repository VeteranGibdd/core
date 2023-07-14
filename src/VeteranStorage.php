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

}
