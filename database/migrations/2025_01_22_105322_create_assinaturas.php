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
        Schema::create('assinaturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relacionamento com users
            $table->foreignId('tipo_plano_id')->constrained('tipos_planos')->onDelete('cascade'); // Relacionamento com tipos_planos
            $table->decimal('preco_base', 10, 2); // Valor base da assinatura
            $table->integer('emails_permitidos')->default(1);
            $table->integer('emails_extra')->default(0); // Apenas para plano empresarial
            $table->decimal('preco_total', 10, 2);
            $table->string('status')->default('ativo'); // Status da assinatura
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assinaturas');
    }
};
