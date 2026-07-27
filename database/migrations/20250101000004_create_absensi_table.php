<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateAbsensiTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('absensi')
            ->addColumn('id_karyawan', 'integer')
            ->addColumn('tanggal', 'date')
            ->addColumn('jam_masuk', 'time', ['null' => true])
            ->addColumn('jam_keluar', 'time', ['null' => true])
            ->addColumn('sumber_import', 'string', ['limit' => 20, 'default' => 'manual'])
            ->addTimestamps()
            ->addIndex(['id_karyawan'])
            ->create();
    }
}
