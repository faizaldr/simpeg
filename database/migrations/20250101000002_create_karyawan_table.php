<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateKaryawanTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('karyawan')
            ->addColumn('nik', 'string', ['limit' => 20])
            ->addColumn('nama', 'string', ['limit' => 100])
            // Domain email dummy: inixindo.id (lihat SEED_EMAIL_DOMAIN di .env.example)
            ->addColumn('email', 'string', ['limit' => 150, 'null' => true])
            ->addColumn('no_rekening', 'string', ['limit' => 255, 'null' => true]) // terenkripsi, lihat app/Helpers/Crypto.php
            ->addColumn('foto_url', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('id_atasan', 'integer', ['null' => true])
            ->addColumn('id_user', 'integer', ['null' => true])
            ->addTimestamps()
            ->addIndex(['nik'], ['unique' => true])
            ->create();
    }
}
