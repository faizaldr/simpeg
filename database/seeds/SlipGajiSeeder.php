<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

final class SlipGajiSeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return ['KaryawanSeeder'];
    }

    public function run(): void
    {
        $rows = [];
        foreach ([1, 2, 3] as $idKaryawan) {
            $rows[] = [
                'id_karyawan' => $idKaryawan,
                'periode' => date('Y-m'),
                'komponen' => json_encode(['gaji_pokok' => 5000000, 'tunjangan' => 500000]),
                // Berkas ini sengaja belum benar-benar ada di /uploads/slip_gaji/ —
                // dibuat manual oleh peserta saat sesi CWE-22 Path Traversal.
                'file_pdf' => "slip_{$idKaryawan}_" . date('Ym') . '.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->table('slip_gaji')->insert($rows)->saveData();
    }
}
