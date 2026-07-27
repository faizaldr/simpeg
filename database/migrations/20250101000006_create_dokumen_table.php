<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDokumenTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('dokumen')
            ->addColumn('id_karyawan', 'integer')
            ->addColumn('jenis', 'string', ['limit' => 20])
            ->addColumn('path_file', 'string', ['limit' => 255])
            ->addColumn('uploaded_at', 'datetime')
            ->addIndex(['id_karyawan'])
            ->create();
    }
}
