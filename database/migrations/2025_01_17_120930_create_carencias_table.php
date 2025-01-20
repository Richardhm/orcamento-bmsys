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
        Schema::create('carencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plano_id');
            $table->unsignedBigInteger('tabela_origens_id');
            $table->integer('tempo'); // int(11)
            $table->text('detalhe'); // Para armazenar detalhes maiores
            $table->string('frase')->nullable(); // Campo opcional
            $table->timestamps();

            // Chaves estrangeiras
            $table->foreign('plano_id')->references('id')->on('planos')->onDelete('cascade');
            $table->foreign('tabela_origens_id')->references('id')->on('tabela_origens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carencias');
    }
};
