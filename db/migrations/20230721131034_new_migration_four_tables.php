<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class NewMigrationFourTables extends AbstractMigration
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
        $tablePoliceDuty = $this->table('duty');
        $tableOrganisation = $this->table('organisation');

        $tableVeterans->addColumn('first_name', 'text', ['null' => false]);
        $tableVeterans->addColumn('last_name', 'text', ['null' => false]);
        $tableVeterans->addColumn('middle_name', 'text', ['null' => false]);
        $tableVeterans->addColumn('birth_date', 'text', ['null' => false]);
        $tableVeterans->addColumn('district', 'text');
        $tableVeterans->addColumn('address', 'text');
        $tableVeterans->addColumn('mobile_phone', 'text');
        $tableVeterans->addColumn('reserve_phone', 'text');
        $tableVeterans->addColumn('email', 'text');
        $tableVeterans->addColumn('disability', 'text');
        $tableVeterans->addColumn('additionally', 'text');
        $tableVeterans->addColumn('passport', 'integer');
        $tableVeterans->addColumn('duty', 'integer');
        $tableVeterans->addColumn('organisation', 'integer');
        $tableVeterans->addForeignKey('passport', 'passports', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $tableVeterans->addForeignKey('duty', 'duty', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $tableVeterans->addForeignKey('organisation', 'organisation', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $tableVeterans->addTimestamps();
        $tableVeterans->addIndex(['id'], ['unique' => true]);
        $tableVeterans->create();

        $tablePassports->addColumn('serial', 'text');
        $tablePassports->addColumn('number', 'text');
        $tablePassports->addColumn('date_of_issue', 'text');
        $tablePassports->addForeignKey('id', 'veterans', 'passport', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $tablePassports->addTimestamps();
        $tablePassports->addIndex(['id'], ['unique' => true]);
        $tablePassports->create();

        $tableOrganisation->addColumn('status', 'text', ['null' => false]);
        $tableOrganisation->addColumn('joining_year', 'integer');
        $tableOrganisation->addColumn('role', 'text');
        $tableOrganisation->addColumn('certificate_number', 'text');
        $tableOrganisation->addColumn('certificate_validity', 'text');
        $tableOrganisation->addForeignKey('id', 'veterans', 'organisation', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $tableOrganisation->addTimestamps();
        $tableOrganisation->addIndex(['id'], ['unique' => true]);
        $tableOrganisation->create();

        $tablePoliceDuty->addColumn('rank', 'text');
        $tablePoliceDuty->addColumn('length_service', 'integer');
        $tablePoliceDuty->addColumn('length_service_traffic_police', 'integer');
        $tablePoliceDuty->addColumn('duty_status', 'text');
        $tablePoliceDuty->addColumn('retirement_year', 'integer');
        $tablePoliceDuty->addColumn('awards', 'text');
        $tablePoliceDuty->addColumn('hostilities_participation', 'text');
        $tablePoliceDuty->addForeignKey('id', 'veterans', 'duty', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $tablePoliceDuty->addTimestamps();
        $tablePoliceDuty->addIndex(['id'], ['unique' => true]);
        $tablePoliceDuty->create();
    }
}
