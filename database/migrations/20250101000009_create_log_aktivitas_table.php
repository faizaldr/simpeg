<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateLogAktivitasTable extends AbstractMigration
{
    public function change(): void
    {
        // Tabel ini SENGAJA dibuat tapi tidak diisi lewat kode aplikasi mana
        // pun pada baseline (CWE-778 Insufficient Logging) — baru dipakai
        // setelah patch menambahkan pemanggilan logger di tiap modul.
        $this->table('log_aktivitas')
            ->addColumn('waktu', 'datetime')
            ->addColumn('id_user', 'integer', ['null' => true])
            ->addColumn('aksi', 'string', ['limit' => 100])
            ->addColumn('ip', 'string', ['limit' => 45, 'null' => true])
            ->addColumn('detail', 'text', ['null' => true])
            ->create();
    }
}
