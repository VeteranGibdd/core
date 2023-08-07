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
     * anniversaries, district, age = 40, > 40, < 40, disability, remaining in force, excluded, deceased, status
     */
    protected function configureFilters($parameters): Veteran
    {
        $mapAvailableFilterByParameter = [
            'district' => new Filter\Base\MultipleEqualFilter('district'),
            'dutyStatus' => new Filter\Base\EqualFilter('dutyStatus', \PDO::PARAM_STR),
            'status' => new Filter\Base\EqualFilter('status', \PDO::PARAM_STR),
            'disability' => new Filter\Base\MultipleEqualFilter('disability')
        ];

        /* @var $filter Filter\FilterInterface */
        foreach ($mapAvailableFilterByParameter as $parameterName => $filter) {
            if (isset($parameters[$parameterName])) {
                $filter->bindValues($parameters[$parameterName]);
                $this->filters[] = $filter;
            }
        }

        if (isset($parameters['yearsOldWillBeThisYear'])) {
            if (is_array($this->anniversariesAgeFilter($parameters['yearsOldWillBeThisYear']))) {
                foreach ($this->anniversariesAgeFilter($parameters['yearsOldWillBeThisYear']) as $filter) {
                    $this->filters[] = $filter;
                }
            } else {
                $this->filters[] = $this->anniversariesAgeFilter($parameters['yearsOldWillBeThisYear']);
            }

        }

        if (isset($parameters['age'])) {
            $this->filters[] = $this->currentAgeFilter($parameters['age']);
        }

        if (isset($parameters['fromAge'])) {
            $this->filters[] = $this->fromAgeFilter($parameters['fromAge']);
        }

        if (isset($parameters['beforeAge'])) {
            $this->filters[] = $this->beforeAgeFilter($parameters['beforeAge']);
        }

        return $this;
    }

    private function fromAgeFilter(int $age): Filter\Base\LessThanOrEqualFilter
    {
        $xYearsAgo = (new \DateTime('now'))->sub(new \DateInterval("P{$age}Y"));

        $filter = new Filter\Base\LessThanOrEqualFilter('birth_date');

        $filter->bindValues($xYearsAgo->format('Y-m-d'));

        return $filter;
    }

    private function beforeAgeFilter(int $age): Filter\Base\GreaterThanOrEqualFilter
    {
        $xYearsAgo = (new \DateTime('now'))->sub(new \DateInterval("P{$age}Y"));

        $filter = new Filter\Base\GreaterThanOrEqualFilter('birth_date');

        $filter->bindValues($xYearsAgo->format('Y-m-d'));

        return $filter;
    }

    private function anniversariesAgeFilterPrepare(int $age): Filter\Base\DateRangeFilter
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
     * @param int|array $age
     * @return DateRangeFilter|array
     */
    private function anniversariesAgeFilter(int|array $age): Filter\Base\DateRangeFilter|array
    {
        if (!is_array($age)) {
            return $this->anniversariesAgeFilterPrepare($age);
        } else {
            $filters = [];
            foreach ($age as $years) {
                $filters[] = $this->anniversariesAgeFilterPrepare($years);
            }
            return $filters;
        }

    }

    private function currentAgeFilter(int $age): Filter\Base\DateRangeFilter
    {
        $ageMax = $age + 1;
        $xYearsAgo = (new \DateTime('now'))->sub(new \DateInterval("P{$age}Y"));
        $xPlusOneYearAgo = (new \DateTime('now'))->sub(new \DateInterval("P{$ageMax}Y"))
            ->add(new \DateInterval('P1D'));

        $filter = new Filter\Base\DateRangeFilter('birth_date');

        $filter->bindValues(
            [
                'begin' => $xYearsAgo->format('Y-m-d'),
                'end' => $xPlusOneYearAgo->format('Y-m-d')
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

        // Sort by birthday: ASC - from older to younger, DESC - from younger to older
        $this->sortUsing(new ByColumn('birthDate', 'birth_date'), $parameters);

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
