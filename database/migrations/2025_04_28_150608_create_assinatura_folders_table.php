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
        Schema::create('assinatura_folders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assinatura_id');
            $table->foreign('assinatura_id')->references('id')->on('assinaturas')->onDelete('cascade');

            $table->unsignedBigInteger('tabela_origens_id');
            $table->foreign('tabela_origens_id')->references('id')->on('tabela_origens')->onDelete('cascade');

            $table->string('folder');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assinatura_folders');
    }
};
