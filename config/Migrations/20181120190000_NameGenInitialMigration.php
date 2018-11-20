<?php
use Migrations\AbstractMigration;

class NameGenInitialMigration extends AbstractMigration
{
    public function up()
    {

        $this->table('name_gen_family')
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 30,
                'null' => false,
            ])
            ->addColumn('locale', 'string', [
                'default' => '',
                'limit' => 5,
                'null' => false,
            ])
            ->create();

        $this->table('name_gen_given')
            ->addColumn('name', 'string', [
                'default' =>  '',
                'limit' => 30,
                'null' => false,
            ])
            ->addColumn('gender', 'string', [
                'default' => '',
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('locale', 'string', [
                'default' => '',
                'limit' => 5,
                'null' => false,
            ])
            ->create();

        $this->table('name_gen_middle')
            ->addColumn('name', 'string', [
                'default' =>  '',
                'limit' => 30,
                'null' => false,
            ])
            ->addColumn('gender', 'string', [
                'default' => '',
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('locale', 'string', [
                'default' => '',
                'limit' => 5,
                'null' => false,
            ])
            ->create();

    }

    public function down()
    {
        $this->dropTable('name_gen_family');
        $this->dropTable('name_gen_given');
        $this->dropTable('name_gen_middle');
    }

}
