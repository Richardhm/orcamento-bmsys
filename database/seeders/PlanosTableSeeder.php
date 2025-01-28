<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('planos')->insert([
            [
                'id' => 1,
                'nome' => 'Individual',
                'empresarial' => NULL,
                'created_at' => '2023-02-01 02:53:57',
                'updated_at' => '2023-02-01 02:53:57',
            ],
            [
                'id' => 2,
                'nome' => 'Corporit',
                'empresarial' => NULL,
                'created_at' => '2023-02-01 02:56:52',
                'updated_at' => '2023-02-01 02:56:52',
            ],
            [
                'id' => 3,
                'nome' => 'Coletivo por Adesão',
                'empresarial' => NULL,
                'created_at' => '2023-02-01 02:57:16',
                'updated_at' => '2023-02-01 02:57:16',
            ],
            [
                'id' => 4,
                'nome' => 'PME',
                'empresarial' => 1,
                'created_at' => '2023-02-21 04:22:01',
                'updated_at' => '2023-02-21 04:22:02',
            ],
            [
                'id' => 5,
                'nome' => 'Super Simples',
                'empresarial' => 1,
                'created_at' => '2023-02-21 04:22:37',
                'updated_at' => '2023-02-21 04:22:38',
            ],
            [
                'id' => 6,
                'nome' => 'Sindipão',
                'empresarial' => 1,
                'created_at' => '2023-02-21 04:22:37',
                'updated_at' => '2023-02-21 04:22:38',
            ],
            [
                'id' => 8,
                'nome' => 'Coletivo Integrado',
                'empresarial' => 1,
                'created_at' => '2023-02-21 04:22:37',
                'updated_at' => '2023-02-21 04:22:38',
            ],
            [
                'id' => 9,
                'nome' => 'Sindimaco',
                'empresarial' => 1,
                'created_at' => '2023-02-21 04:22:37',
                'updated_at' => '2023-02-21 04:22:38',
            ],
            [
                'id' => 10,
                'nome' => 'Super Simples - Integrado',
                'empresarial' => 1,
                'created_at' => '2023-02-21 04:22:37',
                'updated_at' => '2023-02-21 04:22:38',
            ],
            [
                'id' => 11,
                'nome' => 'Super Simples - Pleno',
                'empresarial' => 1,
                'created_at' => '2023-02-21 04:22:37',
                'updated_at' => '2023-02-21 04:22:38',
            ],
            [
                'id' => 13,
                'nome' => 'Sincofarma',
                'empresarial' => 1,
                'created_at' => '2023-02-21 04:22:37',
                'updated_at' => '2023-02-21 04:22:38',
            ],
            [
                'id' => 14,
                'nome' => 'Coletivo Total',
                'empresarial' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
        ]);
    }
}
