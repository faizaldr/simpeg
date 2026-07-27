<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

final class PengaturanSistemSeeder extends AbstractSeed
{
    public function run(): void
    {
        $this->table('pengaturan_sistem')->insert([
            [
                'key' => 'rumus_tunjangan',
                // Nilai ini dijalankan lewat eval() — titik CWE-94, lihat public/settings/rumus_tunjangan.php
                'value' => '2000000 + ($masa_kerja * 50000)',
            ],
        ])->saveData();
    }
}
