<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TabelaOrigensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tabela_origens')->insert([
            [
                'id' => 1,
                'nome' => 'Anápolis',
                'uf' => 'GO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 2,
                'nome' => 'Goiânia',
                'uf' => 'GO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 3,
                'nome' => 'Rondonópolis',
                'uf' => 'MT',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 4,
                'nome' => 'Cuiabá',
                'uf' => 'MT',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 5,
                'nome' => 'Três Lagoas',
                'uf' => 'MS',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 6,
                'nome' => 'Dourados',
                'uf' => 'MS',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 7,
                'nome' => 'Campo Grande',
                'uf' => 'MS',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 8,
                'nome' => 'Brasília',
                'uf' => 'DF',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 9,
                'nome' => 'Rio Verde',
                'uf' => 'GO',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 10,
                'nome' => 'Bahia',
                'uf' => 'BA',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
        ]);
    }
}
