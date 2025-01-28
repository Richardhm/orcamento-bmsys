<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('layouts')->insert([
            ['imagem' => 'layouts/01.png', 'nome' => 'Layout 1'],
            ['imagem' => 'layouts/02.png', 'nome' => 'Layout 2']
        ]);
    }
}
