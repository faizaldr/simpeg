<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../app/Helpers/Crypto.php';

/**
 * Data pegawai dummy. Seluruh alamat email memakai domain inixindo.id
 * (lihat SEED_EMAIL_DOMAIN di .env.example), BUKAN domain publik asli.
 */
final class KaryawanSeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return ['UserSeeder'];
    }

    public function run(): void
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->safeLoad();
        $domain = $_ENV['SEED_EMAIL_DOMAIN'] ?? 'inixindo.id';

        $faker = Faker\Factory::create('id_ID');

        $rows = [];
        // id_user 1=admin, 2=demo, 3..10 = pegawai1..pegawai8 (lihat UserSeeder)
        for ($i = 0; $i < 8; $i++) {
            $nama = $faker->name();
            $slugNama = strtolower(str_replace(' ', '.', preg_replace('/[^A-Za-z ]/', '', $nama)));

            $rows[] = [
                'nik' => (string) $faker->unique()->numberBetween(3170000000000000, 3170000000009999),
                'nama' => $nama,
                'email' => $slugNama . '@' . $domain,
                'no_rekening' => Crypto::encrypt((string) $faker->numberBetween(1000000000, 9999999999)),
                'foto_url' => null,
                'id_atasan' => $i === 0 ? null : 1,
                'id_user' => 3 + $i,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->table('karyawan')->insert($rows)->saveData();
    }
}
