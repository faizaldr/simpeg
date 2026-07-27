<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

final class AbsensiSeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return ['KaryawanSeeder'];
    }

    public function run(): void
    {
        $rows = [];
        for ($idKaryawan = 1; $idKaryawan <= 3; $idKaryawan++) {
            for ($hari = 1; $hari <= 3; $hari++) {
                $rows[] = [
                    'id_karyawan' => $idKaryawan,
                    'tanggal' => date('Y-m-d', strtotime("-$hari days")),
                    'jam_masuk' => '08:00:00',
                    'jam_keluar' => '17:00:00',
                    'sumber_import' => 'seed',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        $this->table('absensi')->insert($rows)->saveData();
    }
}
