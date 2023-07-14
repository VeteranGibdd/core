<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;

function connectVeteranDb(): \Doctrine\DBAL\Connection
{
    $connectionParams = [
        'path' => __DIR__ . '/../db/veterans.sqlite3',
        'driver' => 'sqlite3',
    ];

    return DriverManager::getConnection($connectionParams);
}
