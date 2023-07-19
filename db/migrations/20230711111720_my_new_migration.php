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
        $tableVeterans = $this->table('veterans');
        $tablePassports = $this->table('passports');
        $tableDuty = $this->table('duty');
        $tableRetirement = $this->table('retirement');

        $tableVeterans->addColumn('first_name', 'text', ['null' => false]);
        $tableVeterans->addColumn('last_name', 'text', ['null' => false]);
        $tableVeterans->addColumn('middle_name', 'text', ['null' => false]);
        $tableVeterans->addColumn('birth_date', 'text', ['null' => false]);
        $tableVeterans->addColumn('live_address', 'text');
        $tableVeterans->addColumn('mobile_phone', 'text');
        $tableVeterans->addColumn('reserve_phone', 'text');
        $tableVeterans->addColumn('email', 'text');
        $tableVeterans->addColumn('additionally', 'text');
        $tableVeterans->addTimestamps();
        $tableVeterans->addIndex(['id'], ['unique' => true]);
        $tableVeterans->create();

        $tablePassports->addColumn('address', 'text');
        $tablePassports->addColumn('serial_number', 'text');
        $tablePassports->addTimestamps();
        $tablePassports->addIndex(['id'], ['unique' => true]);
        $tablePassports->create();

        $tableRetirement->addColumn('status', 'text', ['null' => false]);
        $tableRetirement->addColumn('year_entry_to_veteran_org', 'integer');
        $tableRetirement->addColumn('certificate_number', 'text');
        $tableRetirement->addColumn('certificate_validity', 'text');
        $tableRetirement->addTimestamps();
        $tableRetirement->addIndex(['id'], ['unique' => true]);
        $tableRetirement->create();

        $tableDuty->addColumn('rank', 'text');
        $tableDuty->addColumn('length_service', 'integer');
        $tableDuty->addColumn('length_service_police', 'integer');
        $tableDuty->addColumn('retirement_status', 'text');
        $tableDuty->addColumn('retirement_year', 'integer');
        $tableDuty->addColumn('duty', 'text');
        $tableDuty->addColumn('awards', 'text');
        $tableDuty->addColumn('disability', 'text');
        $tableDuty->addColumn('hostilities_participation', 'text');
        $tableDuty->addTimestamps();
        $tableDuty->addIndex(['id'], ['unique' => true]);
        $tableDuty->create();
    }
}
