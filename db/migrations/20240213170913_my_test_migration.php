<?php

use Phinx\Migration\AbstractMigration;

class MyTestMigration extends AbstractMigration
{
    public function change()
    {
        // create the table
        $table = $this->table('user_logins');
        $table->addColumn('user_id', 'integer')
              ->addColumn('created', 'datetime')
              ->create();
    }
}