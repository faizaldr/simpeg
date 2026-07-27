<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('user')
            ->addColumn('username', 'string', ['limit' => 50])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('role', 'string', ['limit' => 20, 'default' => 'staf'])
            ->addColumn('remember_token', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('last_login', 'datetime', ['null' => true])
            ->addColumn('gagal_login', 'integer', ['default' => 0])
            ->addTimestamps()
            ->addIndex(['username'], ['unique' => true])
            ->create();
    }
}
