<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCutiTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('cuti')
            ->addColumn('id_karyawan', 'integer')
            ->addColumn('tanggal_mulai', 'date')
            ->addColumn('tanggal_selesai', 'date')
            ->addColumn('saldo_dipakai', 'integer', ['default' => 0])
            ->addColumn('status', 'string', ['limit' => 20, 'default' => 'diajukan'])
            // Kolom ini SENGAJA jadi titik XSS tersimpan (CWE-79) di baseline.
            ->addColumn('catatan', 'text', ['null' => true])
            ->addTimestamps()
            ->addIndex(['id_karyawan'])
            ->create();
    }
}
