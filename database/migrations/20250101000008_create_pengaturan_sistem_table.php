<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePengaturanSistemTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('pengaturan_sistem')
            ->addColumn('key', 'string', ['limit' => 100])
            // Menyimpan konfigurasi dinamis, termasuk rumus tunjangan (titik CWE-94)
            ->addColumn('value', 'text', ['null' => true])
            ->addIndex(['key'], ['unique' => true])
            ->create();
    }
}
