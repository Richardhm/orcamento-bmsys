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
        Schema::create('pdf_excecao', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plano_id');
            $table->unsignedBigInteger('tabela_origens_id');
            $table->string('linha01')->nullable();
            $table->string('linha02')->nullable();
            $table->string('linha03')->nullable();
            $table->string('consultas_eletivas_total')->nullable();
            $table->string('pronto_atendimento')->nullable();
            $table->string('faixa_1')->nullable();
            $table->string('faixa_2')->nullable();
            $table->string('faixa_3')->nullable();
            $table->string('faixa_4')->nullable();
            $table->timestamps();

            $table->foreign('plano_id')->references('id')->on('planos')->onDelete('cascade');
            $table->foreign('tabela_origens_id')->references('id')->on('tabela_origens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdf_excecao');
    }
};
