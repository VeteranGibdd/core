<?php

namespace Gibdd\Core\Tests\Integration\ListBuilder;

use Gibdd\Core\ListBuilder\Veteran;
use Gibdd\Core\Tests\Integration\TestDbCase;
use Gibdd\Core\VeteranStorage;
use function PHPUnit\Framework\assertCount;

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
        self::assertStringContainsString('Adler', $listBuilder->query()->getSQL());
    }

    public function testCalculateAge(): void
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

        self::assertStringContainsString('ORDER BY cert_number DESC', $listBuilder->query()->getSQL());
    }

    public function testGetVeteransList(): void
    {
        $storage = new VeteranStorage(self::$db);
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
            'district' => 'Сочи',

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
