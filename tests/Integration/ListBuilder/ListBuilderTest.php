<?php

namespace Gibdd\Core\Tests\Integration\ListBuilder;

use Doctrine\DBAL\Exception;
use Gibdd\Core\ListBuilder\Veteran;
use Gibdd\Core\Tests\Integration\Connection\TestDbCase;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

class ListBuilderTest extends TestDbCase
{
    public function testListBuilderContainPassportData(): void
    {
        $listBuilder = $this->listBuilder();
        self::assertStringContainsString('LEFT JOIN passports p ON v.passport', $listBuilder->query()->getSQL());
    }

    public function testCanApplyFilters(): void
    {
        $listBuilder = $this->listBuilder();

        $parameters = ['district' => 'Adler'];

        $listBuilder->configure($parameters);

        self::assertArrayHasKey('Adler', array_flip($listBuilder->totalQuery()->getParameter('dcValue1')));
    }

    public function testCalculateAnniversariesAge(): void
    {
        $listBuilder = $this->listBuilder();

        $parameters = ['yearsOldWillBeThisYear' => 40];
        $listBuilder->configure($parameters);

        $fortyYearAgo = (new \DateTime('now'))->sub(new \DateInterval('P40Y'))->add(new \DateInterval('P1D'));

        self::assertStringContainsString('12-31', $listBuilder->query()->getSQL());
        self::assertStringContainsString($fortyYearAgo->format('Y-m-d'), $listBuilder->query()->getSQL());
    }

    public function testCanApplySortings(): void
    {
        $listBuilder = $this->listBuilder();
        $parameters = [
            'sortBy' => 'certNumber',
            'sortOrder' => 'DESC'
        ];

        $listBuilder->configure($parameters);

        self::assertStringContainsString('ORDER BY certificate_number DESC', $listBuilder->query()->getSQL());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetVeteransList(): void
    {
        $storage = new \Gibdd\Core\Storage\Veteran(self::$db);
        $storage->add($this->veteran());
        $storage->add($this->veteran());
        $storage->add($this->veteran());

        $listBuilder = $this->listBuilder();
        $parameters = [
            'sortBy' => 'certNumber',
            'sortOrder' => 'DESC'
        ];

        $listBuilder->configure($parameters);
        assertCount(3, $listBuilder->query()->fetchAllAssociative());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testSortingByAge(): void
    {
        $storage = new \Gibdd\Core\Storage\Veteran(self::$db);
        $veteran2 = $this->veteran();
        $veteran3 = $this->veteran();
        $veteran2->birthDate = '1969-08-15';
        $veteran3->birthDate = '1988-01-19';
        $storage->add($this->veteran());
        $storage->add($veteran2);
        $storage->add($veteran3);

        $listBuilder = $this->listBuilder();
        $parameters = [
            'sortBy' => 'birthDate',
            'sortOrder' => 'ASC'
        ];

        $listBuilder->configure($parameters);

        assertSame(2, $listBuilder->query()->fetchOne());
    }

    public function testCanApplySeveralFilters(): void
    {
        $listBuilder = $this->listBuilder();

        $parameters = ['district' => 'Adler', 'yearsOldWillBeThisYear' => 40];

        $listBuilder->configure($parameters);
        $fortyYearAgo = (new \DateTime('now'))->sub(new \DateInterval('P40Y'))->add(new \DateInterval('P1D'));

        self::assertArrayHasKey($parameters['district'], array_flip($listBuilder->totalQuery()->getParameter('dcValue1')));
        self::assertStringContainsString($fortyYearAgo->format('Y-m-d'), $listBuilder->query()->getSQL());
    }

    public function testCanApplySeveralSimilarFilters(): void
    {
        $listBuilder = $this->listBuilder();

        $parameters = ['district' => ['Adler', 'Center']];

        $listBuilder->configure($parameters);

        foreach ($parameters['district'] as $district) {
            self::assertArrayHasKey($district, array_flip($listBuilder->totalQuery()->getParameter('dcValue1')));
        }
    }

    public function testCanApplySeveralSimilarFiltersForAnniversariesAge(): void
    {
        $listBuilder = $this->listBuilder();

        $parameters = ['yearsOldWillBeThisYear' => [40, 50]];

        $listBuilder->configure($parameters);

        foreach ($parameters['yearsOldWillBeThisYear'] as $age) {
            $date = (new \DateTime('now'))->sub(new \DateInterval("P{$age}Y"))->add(new \DateInterval('P1D'));
            self::assertStringContainsString($date->format('Y-m-d'), $listBuilder->query()->getSQL());
        }
    }

    public function testCalculateAge(): void
    {
        $listBuilder = $this->listBuilder();

        $parameters = ['age' => 40];
        $listBuilder->configure($parameters);

        $fortyYearAgo = (new \DateTime('now'))->sub(new \DateInterval('P40Y'));
        $plusOneYearAgo = (new \DateTime('now'))->sub(new \DateInterval("P41Y"))
            ->add(new \DateInterval('P1D'));

        self::assertStringContainsString($plusOneYearAgo->format('Y-m-d'), $listBuilder->query()->getSQL());
        self::assertStringContainsString($fortyYearAgo->format('Y-m-d'), $listBuilder->query()->getSQL());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testFilterFromAge(): void
    {
        $storage = new \Gibdd\Core\Storage\Veteran(self::$db);
        $veteran2 = $this->veteran();
        $veteran3 = $this->veteran();
        $veteran2->birthDate = '1989-08-15';
        $veteran3->birthDate = '1971-01-19';
        $storage->add($this->veteran());
        $storage->add($veteran2);
        $storage->add($veteran3);

        $listBuilder = $this->listBuilder();
        $parameters = ['fromAge' => 50];

        $listBuilder->configure($parameters);

        assertCount(2, $listBuilder->query()->fetchAllAssociative());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testFilterAfterAge(): void
    {
        $storage = new \Gibdd\Core\Storage\Veteran(self::$db);
        $veteran2 = $this->veteran();
        $veteran3 = $this->veteran();
        $veteran2->birthDate = '1989-08-15';
        $veteran3->birthDate = '1984-01-19';
        $storage->add($this->veteran());
        $storage->add($veteran2);
        $storage->add($veteran3);

        $listBuilder = $this->listBuilder();
        $parameters = ['beforeAge' => 40];

        $listBuilder->configure($parameters);

        assertCount(2, $listBuilder->query()->fetchAllAssociative());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testComplicateFiltering(): void
    {
        $storage = new \Gibdd\Core\Storage\Veteran(self::$db);
        $veteran2 = $this->veteran();
        $veteran3 = $this->veteran();
        $veteran4 = $this->veteran();
        $veteran2->birthDate = '1989-08-15';
        $veteran2->district = 'Центр';
        $veteran3->birthDate = '1961-01-19';
        $veteran3->district = 'Адлер';
        $veteran4->birthDate = '1971-01-19';
        $veteran4->district = 'Хоста';
        $storage->add($this->veteran());
        $storage->add($veteran2);
        $storage->add($veteran3);
        $storage->add($veteran4);

        $listBuilder = $this->listBuilder();
        $parameters = ['district' => ['Центр', 'Адлер'], 'fromAge' => 30, 'beforeAge' => 60];
        $listBuilder->configure($parameters);

        assertCount(2, $listBuilder->query()->fetchAllAssociative());
    }

    private function listBuilder(): Veteran
    {
        return new Veteran(self::$db);
    }

    private function veteran(): \stdClass
    {
        return (object)[
            'firstName' => 'Иван',
            'lastName' => 'Ивановванов',
            'middleName' => 'Иванович',
            'birthDate' => '1970-03-25',
            'district' => 'Центр',

            'policeDuty' => (object)[
                'rank' => 'майор полиции',
                'dutyStatus' => 'В отставке',
            ],

            'organisation' => (object)[
                'status' => 'Ветеран',
                'joiningYear' => 2008,
            ],
        ];
    }
}
