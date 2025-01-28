<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministradorasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('administradoras')->insert([
            [
                'id' => 1,
                'nome' => 'Allcare',
                'logo' => 'administradoras/DFtouoq3wx8OdRPP5XTafQ0bjEwsYYzNoQdVs06r.png',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'nome' => 'Alter',
                'logo' => 'administradoras/6ZjO0muhLB9iYyqnZZkQ6QFHafcfmVa7nRflJ0Du.png',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'nome' => 'Qualicorp',
                'logo' => 'administradoras/DfToWIc1dXnu7ZEkQV2EwSaYhljtc24Y4ynUSXNn.png',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'nome' => 'Hapvida',
                'logo' => 'administradoras/UisK2enZ0615AYLSAZi3zD464jEawvGbEKjzKLBB.png',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
