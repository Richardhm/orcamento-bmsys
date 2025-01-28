<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcomodacoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('acomodacoes')->insert([
            [
                'id' => 1,
                'nome' => 'Apartamento',
                'created_at' => '2023-01-31 23:40:15',
                'updated_at' => '2023-01-31 23:40:17',
            ],
            [
                'id' => 2,
                'nome' => 'Enfermaria',
                'created_at' => '2023-01-31 23:40:31',
                'updated_at' => '2023-01-31 23:40:33',
            ],
            [
                'id' => 3,
                'nome' => 'Ambulatorial',
                'created_at' => '2023-01-31 23:40:44',
                'updated_at' => '2023-01-31 23:40:45',
            ],
        ]);
    }
}
