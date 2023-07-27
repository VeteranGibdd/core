<?php

namespace Gibdd\Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class VeteranReport
{
    private array $filters = [
        // need to think how to count 'anniversaries' => NULL,
        'district' => NULL,
        // need to think how to count 'specificAge' => NULL,
        // need to think how to count 'ageFrom' => NULL,
        'disability' => NULL,
        'dutyStatus' => NULL,
        // what is it? 'excluded' => NULL,
        // what is it? 'deceased' => NULL,
        'status' => NULL
    ];
    private array $sorting = [
        'orderBy' => NULL
    ];
    private QueryBuilder $builder;

    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function buildReport(): array
    {
        // prepareFilters
        $this->mainQuery();

        $this->builder->select('*')
            ->from('veterans', 'v')
            ->innerJoin('v', 'passports', 'p', 'v.passport = p.id')
            ->innerjoin('v', 'duty', 'd', 'v.duty = d.id')
            ->innerjoin('v', 'organisation', 'o', 'v.organisation = o.id');

        $this->prepareFilters();

        $this->builder->orderBy('last_name', 'ASC');
        $this->sorting['orderBy'] ?? $this->builder->addOrderBy($this->builder->createNamedParameter($this->sorting['orderBy']), 'ASC');

        $result = [];
        foreach ($this->builder->executeQuery()->fetchAllAssociative() as $dbRow) {
            $result[] = new Veteran($dbRow);
        }

        return $result;
    }

    private function mainQuery(): void
    {
        $this->builder = $this->db->createQueryBuilder();
    }

    private function prepareFilters(): void
    {
        // допишу остальные, когда пойму что к чему
            $this->filters['district'] ?? $this->builder->where('district = ' . $this->builder->createPositionalParameter($this->filters['district']));
            $this->filters['disability'] ?? $this->builder->where('disability = ' . $this->builder->createPositionalParameter($this->filters['disability']));
            $this->filters['dutyStatus'] ?? $this->builder->where('dutyStatus = ' . $this->builder->createPositionalParameter($this->filters['dutyStatus']));
            $this->filters['status'] ?? $this->builder->where('status = ' . $this->builder->createPositionalParameter($this->filters['status']));
            $this->filters['district'] ?? $this->builder->where('district = ' . $this->builder->createPositionalParameter($this->filters['district']));
    }

    // anniversaries, district, age = 40 > 40, disability, remaining in force, excluded, deceased, status
    public function addFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    // age, certNumber, birthdays, district
    public function sortBy(array $sorting): void
    {
        $this->sorting = $sorting;
    }

}
