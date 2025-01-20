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
        Schema::create('tabelas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('administradora_id')->unsigned();
            $table->bigInteger('tabela_origens_id')->unsigned();
            $table->bigInteger('plano_id')->unsigned();
            $table->bigInteger('acomodacao_id')->unsigned();
            $table->bigInteger('faixa_etaria_id')->unsigned();
            $table->tinyInteger('coparticipacao');
            $table->tinyInteger('odonto');
            $table->decimal('valor', 8, 2);
            $table->timestamps();
            $table->foreign('administradora_id')->references('id')->on('administradoras')->onDelete('cascade');
            $table->foreign('tabela_origens_id')->references('id')->on('tabela_origens')->onDelete('cascade');
            $table->foreign('plano_id')->references('id')->on('planos')->onDelete('cascade');
            $table->foreign('acomodacao_id')->references('id')->on('acomodacoes')->onDelete('cascade');
            $table->foreign('faixa_etaria_id')->references('id')->on('faixa_etarias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabelas');
    }
};
