<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

final class CutiSeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return ['KaryawanSeeder'];
    }

    public function run(): void
    {
        $rows = [
            [
                'id_karyawan' => 1,
                'tanggal_mulai' => date('Y-m-d', strtotime('-10 days')),
                'tanggal_selesai' => date('Y-m-d', strtotime('-8 days')),
                'saldo_dipakai' => 2,
                'status' => 'disetujui',
                'catatan' => 'Cuti keluarga.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_karyawan' => 2,
                'tanggal_mulai' => date('Y-m-d'),
                'tanggal_selesai' => date('Y-m-d', strtotime('+1 day')),
                'saldo_dipakai' => 1,
                'status' => 'diajukan',
                'catatan' => 'Menunggu persetujuan atasan.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->table('cuti')->insert($rows)->saveData();
    }
}
