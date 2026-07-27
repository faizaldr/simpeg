<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

require_once __DIR__ . '/../../app/Helpers/Auth.php';

/**
 * Akun uji bawaan baseline (lihat desain_dan_kebutuhan_aplilkasi.md §10):
 *  - admin/admin & demo/demo -> CWE-1392 Default Credentials
 *  - 8 akun staf dengan pola username=password -> CWE-521/CWE-307
 * (Akun cadangan "superadmin" TIDAK ada di sini — ia tertanam di kode,
 * lihat public/auth/login.php, demonstrasi CWE-259.)
 */
final class UserSeeder extends AbstractSeed
{
    public function run(): void
    {
        $rows = [
            ['username' => 'admin', 'password' => Auth::hashPassword('admin'), 'role' => 'hrd'],
            ['username' => 'demo', 'password' => Auth::hashPassword('demo'), 'role' => 'staf'],
        ];

        $polaNip = ['198501', '199002', '199203', '198804', '199505', '199706', '199807', '199908'];
        foreach ($polaNip as $i => $nip) {
            $username = 'pegawai' . ($i + 1);
            $rows[] = [
                // Kata sandi SENGAJA sama dengan username -> CWE-521 Weak Password Requirements
                'username' => $username,
                'password' => Auth::hashPassword($username),
                'role' => 'staf',
            ];
        }

        $this->table('user')->insert($rows)->saveData();
    }
}
