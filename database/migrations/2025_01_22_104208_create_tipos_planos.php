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
        Schema::create('tipos_planos', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Nome do plano (Individual ou Empresarial)
            $table->decimal('valor_base', 10, 2); // Valor inicial do plano
            $table->integer('limite_emails')->nullable(); // Limite de e-mails (null para ilimitado)
            $table->decimal('valor_por_email', 10, 2)->nullable(); // Custo por e-mail adicional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_planos');
    }
};
