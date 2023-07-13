<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MyNewMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('veterans');

        $table->addColumn('first_name', 'text', ['null' => false])
            ->addColumn('last_name', 'text', ['null' => false])
            ->addColumn('middle_name', 'text', ['null' => false])
            ->addColumn('birth_date', 'text', ['null' => false])
            ->addColumn('live_address', 'text')
            ->addColumn('passport_address', 'text')
            ->addColumn('rank', 'text')
            ->addColumn('length_service', 'integer')
            ->addColumn('length_service_police', 'integer')
            ->addColumn('retirement_status', 'text', ['null' => false])
            ->addColumn('retirement_year', 'integer')
            ->addColumn('certificate_number', 'integer')
            ->addColumn('certificate_validity', 'text')
            ->addColumn('status', 'text', ['null' => false])
            ->addColumn('year_entry_to_police', 'integer')
            ->addColumn('duty', 'text')
            ->addColumn('mobile_phone', 'text')
            ->addColumn('reserve_phone', 'text')
            ->addColumn('email', 'text')
            ->addColumn('passport', 'text')
            ->addColumn('awards', 'text')
            ->addColumn('disability', 'text')
            ->addColumn('hostilities_participation', 'text')
            ->addColumn('additionally', 'text')
            ->addColumn('year_of_dismissal', 'integer')
            ->addTimestamps()
            ->addIndex(['id', 'passport'], ['unique' => true])
            ->create();
    }
}
