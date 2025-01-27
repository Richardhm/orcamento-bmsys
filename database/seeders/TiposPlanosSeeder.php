<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposPlanosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_planos')->insert([
            [
                'id' => 1,
                'nome' => 'Individual',
                'valor_base' => 29.90,
                'limite_emails' => 1,
                'valor_por_email' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nome' => 'Empresarial',
                'valor_base' => 129.90,
                'limite_emails' => 5,
                'valor_por_email' => 30.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
