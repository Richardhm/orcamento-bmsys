<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cupons', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->unique();
            $table->decimal('desconto_plano', 8, 2);
            $table->decimal('desconto_extra', 8, 2);
            $table->integer('duracao_horas');
            $table->integer('duracao_minutos');
            $table->integer('duracao_segundos');
            $table->dateTime('validade');
            $table->integer('usos_maximos')->nullable();
            $table->integer('usos')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupons');
    }
};
