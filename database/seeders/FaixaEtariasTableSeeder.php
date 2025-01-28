<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaixaEtariasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faixa_etarias')->insert([
            [
                'id' => 1,
                'nome' => '00 a 18',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 2,
                'nome' => '19 a 23',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 3,
                'nome' => '24 a 28',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 4,
                'nome' => '29 a 33',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 5,
                'nome' => '34 a 38',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 6,
                'nome' => '39 a 43',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 7,
                'nome' => '44 a 48',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 8,
                'nome' => '49 a 53',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 9,
                'nome' => '54 a 58',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 10,
                'nome' => '59 ou mais',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
        ]);
    }
}
