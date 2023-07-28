<?php

namespace Gibdd\Core\ListBuilder;

use Doctrine\DBAL\Query\QueryBuilder;
use Ifedko\DoctrineDbalPagination\Filter;
use Ifedko\DoctrineDbalPagination\Filter\Base\DateRangeFilter;
use Ifedko\DoctrineDbalPagination\ListBuilder;
use Ifedko\DoctrineDbalPagination\Sorting\ByColumn;

class Veteran extends ListBuilder
{
    /**
     * @param array $parameters
     * @return $this
     * anniversaries, district, age = 40 > 40, disability, remaining in force, excluded, deceased, status
     */
    protected function configureFilters($parameters): Veteran
    {
        $mapAvailableFilterByParameter = [
            'district' => new Filter\Base\MultipleEqualFilter('district', \PDO::PARAM_STR),
            'dutyStatus' => new Filter\Base\EqualFilter('dutyStatus', \PDO::PARAM_STR),
            'status' => new Filter\Base\EqualFilter('status', \PDO::PARAM_STR),
            'disability' => new Filter\Base\EqualFilter('disability', \PDO::PARAM_BOOL)
        ];

        /* @var $filter Filter\FilterInterface */
        foreach ($mapAvailableFilterByParameter as $parameterName => $filter) {
            if (isset($parameters[$parameterName])) {
                $filter->bindValues($parameters[$parameterName]);
                $this->filters[] = $filter;
            }
        }

        if (isset($parameters['yearsOldWillBeThisYear'])) {
            $this->filters[] = $this->ageFilter($parameters['yearsOldWillBeThisYear']);
        }
        return $this;
    }

    /**
     * @param int $age
     * @return DateRangeFilter
     */
    private function ageFilter(int $age): Filter\Base\DateRangeFilter
    {
        $xYearsAgo = (new \DateTime('now'))->sub(new \DateInterval("P{$age}Y"))
            ->add(new \DateInterval('P1D'));
        $xYearAgoLastYearDay = new \DateTime("{$xYearsAgo->format('Y')}-12-31");

        $filter = new Filter\Base\DateRangeFilter('birth_date');
        $filter->bindValues(
            [
                'begin' => $xYearsAgo->format('Y-m-d'),
                'end' => $xYearAgoLastYearDay->format('Y-m-d')
            ]);

        return $filter;
    }

    /**
     * @param $parameters
     * age, certNumber, birthdays, district
     * @return $this
     */
    protected function configureSorting($parameters): Veteran
    {
        $this->sortUsing(new ByColumn('lastName', 'last_name'), $parameters);
        $this->sortUsing(new ByColumn('certNumber', 'certificate_number'), $parameters);
        $this->sortUsing(new ByColumn('district', 'district'), $parameters);

        return $this;
    }

    /**
     * @return QueryBuilder
     */
    protected function baseQuery(): QueryBuilder
    {
        $builder = $this->dbConnection->createQueryBuilder();

        $builder->select('*')
            ->from('veterans', 'v')
            ->leftJoin('v', 'passports', 'p', 'v.passport = p.id')
            ->leftJoin('v', 'duty', 'd', 'v.duty = d.id')
            ->leftJoin('v', 'organisation', 'o', 'v.organisation = o.id');
        return $builder;
    }
}
