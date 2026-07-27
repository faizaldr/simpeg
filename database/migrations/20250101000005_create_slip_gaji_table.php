<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSlipGajiTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('slip_gaji')
            ->addColumn('id_karyawan', 'integer')
            ->addColumn('periode', 'string', ['limit' => 7]) // format YYYY-MM
            ->addColumn('komponen', 'text', ['null' => true]) // JSON
            // Nama berkas ini yang jadi titik path traversal (CWE-22) di public/payroll/download.php
            ->addColumn('file_pdf', 'string', ['limit' => 255, 'null' => true])
            ->addTimestamps()
            ->addIndex(['id_karyawan'])
            ->create();
    }
}
