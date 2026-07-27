<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePreferensiDashboardTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('preferensi_dashboard')
            ->addColumn('id_user', 'integer')
            // Data terserialisasi PHP — titik CWE-502 (lihat public/dashboard/preferensi.php)
            ->addColumn('data', 'text')
            ->addTimestamps()
            ->addIndex(['id_user'])
            ->create();
    }
}
